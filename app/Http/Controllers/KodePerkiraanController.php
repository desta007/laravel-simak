<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\GroupAccount;
use App\Models\KodePerkiraan;
use App\Models\Proyek;
use App\Models\SaldoAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class KodePerkiraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        session()->forget('totalAmountD');

        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;
        $id_cabang = auth()->user()->id_cabang;

        $search = $request->input('search');

        $query = KodePerkiraan::with(['cabang', 'proyek', 'groupaccount'])->orderBy('kode');

        // Apply user group filters
        if ($id_group_user == 2) {
            $query->where('id_cabang', $id_cabang)->where('id_proyek', 0);
        } elseif ($id_group_user == 3) {
            $query->whereIn('id_proyek', function ($subquery) use ($id_user) {
                $subquery->select('id_proyek')
                    ->from('user_proyeks')
                    ->where('id_user', $id_user);
            });
        }

        // Apply search filter (if provided)
        if (!empty($search)) {
            $search = strtolower($search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(kode) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(keterangan) LIKE ?', ["%{$search}%"]);
            });
        }

        // Paginate results
        $kodePerkiraans = $query->paginate(10);

        // Alert dialog
        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('master.kodePerkiraan', compact('kodePerkiraans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_cabang' => 'required',
            'id_proyek' => 'required',
            'id_group_account' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => '',
        ]);

        try {
            KodePerkiraan::create($validatedData);
            Alert::success('Berhasil', 'Kode Perkiraan berhasil disimpan');
            return redirect()->route('kodePerkiraan.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Kode Perkiraan gagal disimpan, silahkan periksa kembali inputan anda');
            return redirect()->route('kodePerkiraan.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cabangs = Cabang::all();

        $groupaccs = GroupAccount::all();
        $kodePerkiraan = KodePerkiraan::findOrFail($id);

        $proyeks = Proyek::where('id_cabang', '=', $kodePerkiraan->id_cabang)->get();

        return view('master.kodePerkiraanedit', compact('kodePerkiraan', 'cabangs', 'proyeks', 'groupaccs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kodePerkiraan = KodePerkiraan::findOrFail($id);

        $validatedData = $request->validate([
            'id_group_account' => 'required',
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => '',
        ]);

        $kodePerkiraan->update($validatedData);

        Alert::success('Berhasil', 'Kode Perkiraan berhasil diupdate');
        return redirect()->route('kodePerkiraan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kodePerkiraan = KodePerkiraan::findOrFail($id);
        $kodePerkiraan->delete();
        Alert::success('Berhasil', 'Kode Perkiraan berhasil dihapus');
        return redirect()->route('kodePerkiraan.index');
    }

    public function addModal()
    {
        // 01-05-2024
        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;
        $id_cabang = auth()->user()->id_cabang;

        // get list cabang by group user
        if ($id_group_user == 1) {
            // admin
            $cabangs = Cabang::all();
        } else if ($id_group_user == 2) {
            // cabang
            $cabangs = Cabang::where('id', $id_cabang)->get();
        } else {
            // proyek
            $cabangs = Cabang::where('id', $id_cabang)->get();
        }

        //$cabangs = Cabang::all();
        $groupaccs = GroupAccount::all();

        return view('modal.addKodePerkiraan', [
            'title' => 'Tambah Data Kode Perkiraan',
            'cabangs' => $cabangs,
            //'proyeks' => $proyeks,
            'groupaccs' => $groupaccs
        ]);
    }

    public function listProyek(Request $request)
    {
        $id_cabang = $request->input('id_cabang');
        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;

        // 01-05-2024
        if ($id_group_user == 3) {
            $listProyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)
                ->where('proyeks.id_cabang', $id_cabang)
                ->get();

            // $proyek_first = Proyek::select('proyeks.*')
            //     ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
            //     ->where('user_proyeks.id_user', $id_user)
            //     ->where('proyeks.id_cabang', $id_cabang)
            //     ->first();

            // $id_proyek = $proyek_first['id'];
        } else {
            $listProyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
        }
        // ------------

        $values = [];
        foreach ($listProyeks as $option) {
            $values[$option->id] = $option->nama . ' (WO: ' . $option->nomor_wo . ')';
        }

        return $values;
    }

    public function saldoAwal()
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;
        $id_cabang = auth()->user()->id_cabang;

        // get list cabang by group user
        if ($id_group_user == 1) {
            // admin
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();
            $id_proyek = 'all';
        } else if ($id_group_user == 2) {
            // cabang
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
            $id_proyek = 'all';
        } else {
            // proyek
            $cabangs = Cabang::where('id', $id_cabang)->get();

            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->get();

            $proyek_first = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->first();

            $id_proyek = $proyek_first['id'];
        }
        $isView = '';
        $tahun = date('Y');

        return view('transaksi.saldoAwal', compact('id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks', 'isView', 'tahun'));
    }

    public function saldoAwalSearch(Request $request)
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;
        //$id_cabang = auth()->user()->id_cabang;

        $id_cabang = $request->input('id_cabang');
        $id_proyek = $request->input('id_proyek');
        $tahun = $request->input('tahun');

        // get list cabang by group user
        if ($id_group_user == 1) {
            // admin
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();
        } else if ($id_group_user == 2) {
            // cabang
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
        } else {
            // proyek
            $cabangs = Cabang::where('id', $id_cabang)->get();

            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->get();

            $proyek_first = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->first();
        }

        $isView = 1;

        // $saldoAkuns = SaldoAkun::query();
        // $saldoAkuns->where('id_cabang', $id_cabang)
        //     ->where('id_proyek', $id_proyek);

        //     KodePerkiraan::leftJoin('saldo_akuns', 'kode_perkiraans.id', '=', 'saldo_akuns.id_kode_perkiraan')
        // ->select('kode_perkiraans.*', 'saldo_akuns.saldo_debet', 'saldo_akuns.saldo_kredit')
        // ->get();

        // $results = KodePerkiraan::leftJoin('saldo_akuns', 'kode_perkiraans.id', '=', 'saldo_akuns.id_kode_perkiraan')
        //     ->select('kode_perkiraans.kode', 'kode_perkiraans.nama', 'saldo_akuns.saldo_debet', 'saldo_akuns.saldo_kredit')
        //     ->where('kode_perkiraans.id_cabang', $id_cabang)
        //     ->where('kode_perkiraans.id_proyek', $id_proyek)
        //     ->where('saldo_akuns.tahun', $tahun)
        //     ->where('saldo_akuns.is_saldo_awal', 1)
        //     ->orderBy('kode_perkiraans.kode');

        $results = KodePerkiraan::select(
            'kode_perkiraans.*',
            DB::raw('(SELECT saldo_debet FROM saldo_akuns WHERE saldo_akuns.id_kode_perkiraan = kode_perkiraans.id AND saldo_akuns.is_saldo_awal = 1 AND saldo_akuns.tahun = ' . $tahun . ' LIMIT 1) AS saldo_debet'),
            DB::raw('(SELECT saldo_kredit FROM saldo_akuns WHERE saldo_akuns.id_kode_perkiraan = kode_perkiraans.id AND saldo_akuns.is_saldo_awal = 1 AND saldo_akuns.tahun = ' . $tahun . ' LIMIT 1) AS saldo_kredit')
        )->where('id_cabang', $id_cabang)
            ->where('id_proyek', $id_proyek)->get();

        // dd($results->toSql());

        return view('transaksi.saldoAwal', compact('id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks', 'tahun', 'isView', 'results'));
    }

    public function saldoAwalUpdate(Request $request)
    {
        $tahun = $request['tahun1'];
        // detailnya berupa array
        $id_kode_perkiraan = $request['id_kode_perkiraan'];
        $saldo_debet = $request['saldo_debet'];
        $saldo_kredit = $request['saldo_kredit'];

        try {
            DB::beginTransaction();

            for ($i = 0; $i < count($id_kode_perkiraan); $i++) {
                $saldo_debet[$i] = str_replace(',', '', $saldo_debet[$i]);
                $saldo_kredit[$i] = str_replace(',', '', $saldo_kredit[$i]);

                // cek apakah sudah ada data saldo awal
                $saldoakunnya = SaldoAkun::where('id_kode_perkiraan', $id_kode_perkiraan[$i])
                    ->where('tahun', $tahun)
                    ->where('is_saldo_awal', 1)->first();

                if ($saldoakunnya == null) {
                    SaldoAkun::create([
                        'id_kode_perkiraan' => $id_kode_perkiraan[$i],
                        'bulan' => null,
                        'tahun' => $tahun,
                        'saldo_debet' => $saldo_debet[$i],
                        'saldo_kredit' => $saldo_kredit[$i],
                        'is_saldo_awal' => 1
                    ]);
                } else {
                    $saldoakunnya->update([
                        'saldo_debet' => $saldo_debet[$i],
                        'saldo_kredit' => $saldo_kredit[$i]
                    ]);
                }
            }

            // Commit the transaction if all operations are successful
            DB::commit();

            Alert::success('Berhasil', 'Saldo awal berhasil disimpan');
            return redirect()->route('saldoAwal');
        } catch (\Exception $e) {
            DB::rollback();

            Alert::error('Gagal', 'Saldo awal gagal disimpan, silahkan periksa kembali inputan anda');
            return redirect()->route('saldoAwal');
        }
    }
}

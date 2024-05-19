<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\KodeBukti;
use App\Models\KodePerkiraan;
use App\Models\KunciTransaksi;
use App\Models\Proyek;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    public function index()
    {
        //$isView = '1';
        $tgl_awal = Carbon::now()->startOfMonth()->toDateString();
        $tgl_akhir = Carbon::now()->toDateString();
        $noBukti = '';

        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;
        $id_cabang = auth()->user()->id_cabang;

        $transaksis = Transaksi::query()
            ->addSelect([
                'isLock' => KunciTransaksi::query()
                    ->select('status_akses')
                    ->whereColumn('id_cabang', 'transaksis.id_cabang')
                    ->whereColumn('id_proyek', 'transaksis.id_proyek')
                    ->whereRaw('bulan = MONTH(transaksis.tgl)')
                    ->whereRaw('tahun = YEAR(transaksis.tgl)')
                    ->limit(1)
            ]);
        $transaksis->whereBetween('tgl', array($tgl_awal, $tgl_akhir));

        // get list cabang by group user
        if ($id_group_user == 1) {
            // admin
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();
            $id_proyek = 'all';

            // $transaksis->withSum(['transaksiDetail' => function ($query) {
            //     $query->where('jenis', 'D');
            // }], 'jumlah');

            $transaksis->orderBy('created_at', 'desc');
        } else if ($id_group_user == 2) {
            // cabang
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
            $id_proyek = 'all';

            $transaksis->where('id_cabang', $id_cabang)
                // ->where('id_proyek', $id_proyek)
                ->orderBy('created_at', 'desc');
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

            $transaksis->where('id_cabang', $id_cabang)
                ->where('id_proyek', $id_proyek)
                ->orderBy('created_at', 'desc');
        }

        //dd($transaksis->toSql());
        $results = $transaksis->get();

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('transaksi.transaksi', compact('id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks', 'tgl_awal', 'tgl_akhir', 'noBukti', 'results'));
    }

    public function search(Request $request)
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;

        $id_cabang = $request->input('id_cabang');
        $id_proyek = $request->input('id_proyek');
        $noBukti = $request->input('noBukti');
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');

        // new code
        $transaksis = Transaksi::query()
            ->addSelect([
                'isLock' => KunciTransaksi::query()
                    ->select('status_akses')
                    ->whereColumn('id_cabang', 'transaksis.id_cabang')
                    ->whereColumn('id_proyek', 'transaksis.id_proyek')
                    ->whereRaw('bulan = MONTH(transaksis.tgl)')
                    ->whereRaw('tahun = YEAR(transaksis.tgl)')
                    ->limit(1)
            ]);
        $transaksis->whereBetween('tgl', array($tgl_awal, $tgl_akhir));

        if ($id_group_user == 1) {
            // admin
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();

            if ($id_cabang != '')
                $transaksis->where('id_cabang', $id_cabang);

            if ($id_proyek != 'all') {
                $transaksis->where('id_proyek', $id_proyek);
            }

            $transaksis->where('no_urut_bukti', 'like', '%' . $noBukti . '%');
            $transaksis->orderBy('created_at', 'desc');
        } else if ($id_group_user == 2) {
            // cabang
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();

            $transaksis->where('id_cabang', $id_cabang);
            if ($id_proyek != 'all') {
                $transaksis->where('id_proyek', $id_proyek);
            }
            $transaksis->where('no_urut_bukti', 'like', '%' . $noBukti . '%');
            $transaksis->orderBy('created_at', 'desc');
        } else {
            // proyek
            $cabangs = Cabang::where('id', $id_cabang)->get();

            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->get();

            $proyek_first = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->first();

            $transaksis->where('id_cabang', $id_cabang)
                ->where('id_proyek', $id_proyek)
                ->where('no_urut_bukti', 'like', '%' . $noBukti . '%')
                ->orderBy('created_at', 'desc');
        }

        //dd($transaksis->toSql());
        $results = $transaksis->get();

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('transaksi.transaksi', compact('id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks', 'tgl_awal', 'tgl_akhir', 'noBukti', 'results'));
        // --------
    }

    public function create()
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_cabang = auth()->user()->id_cabang;

        // get list cabang by group user
        if ($id_group_user == 1) {
            // admin
            $cabangs = Cabang::all();
        } else {
            // cabang/proyek
            $cabangs = Cabang::where('id', $id_cabang)->get();
        }

        // get list proyek setelah onchange cabang (khusus user admin)
        $proyeks = '';
        // utk user cabang/proyek, otomatis muncul list proyeknya by cabang
        if ($id_group_user == 2) {
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
        } else if ($id_group_user == 3) {
            $id_user = auth()->user()->id;

            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)
                ->orderBy('proyeks.created_at', 'desc')->get();
        }

        // get list kode bukti
        $kode_buktis = KodeBukti::all();
        $tgl = Carbon::now()->toDateString();

        return view('transaksi.transaksiadd', [
            'cabangs' => $cabangs,
            'proyeks' => $proyeks,
            'kode_buktis' => $kode_buktis,
            'id_group_user' => $id_group_user,
            'tgl' => $tgl
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cabang' => 'required',
            'id_kode_bukti' => 'required',
            'no_urut_bukti' => 'required',
            'tgl' => 'required'
        ]);

        //$counter = $request->input('counter');

        // detailnya
        $id_kode_perkiraan1 = $request['id_kode_perkiraan1'];
        $jenis1 = $request['jenis1'];
        $jumlah1 = $request['jumlah1'];

        if (!is_array($id_kode_perkiraan1)) {
            Alert::error('Input Error', 'Data detail transaksi harus diisi');
            return redirect()->route('addTransJurnal');
        }

        try {
            DB::beginTransaction();

            // generate no jurnal
            $month = \Carbon\Carbon::parse($request['tgl'])->format('m');
            $year = Carbon::parse($request['tgl'])->year;

            $noUrutJurnal = Transaksi::where('id_cabang', $request['id_cabang'])
                ->where('id_proyek', $request['id_proyek'])
                ->whereYear('tgl', $year)
                ->whereMonth('tgl', $month)
                ->max('no_urut_jurnal');
            $noUrutJurnal = $noUrutJurnal + 1;

            $noBukti = KodeBukti::where('id', $request['id_kode_bukti'])->first();
            $noBuktiFull = $request['no_urut_bukti'] . '/' . $noBukti['kode'] . '/' . $month . '/' . $year;

            $fileName = '';
            if ($request->file_dokumen != '') {
                $extension = $request->file('file_dokumen')->getClientOriginalExtension();

                $fileName = date("Ymd") . '_' . time() . '.' . $extension;
                $request->file('file_dokumen')->storeAs('transaksis', $fileName);
            }

            $trx = Transaksi::create([
                'id_cabang' => $request['id_cabang'],
                'id_proyek' => $request['id_proyek'],
                'id_kode_bukti' => $request['id_kode_bukti'],
                'tgl' => $request['tgl'],
                'no_bukti' => $noBuktiFull,
                'no_urut_bukti' => $request['no_urut_bukti'],
                'keterangan' => $request['keterangan'],
                'no_urut_jurnal' => $noUrutJurnal,
                'file_dokumen' => $fileName
            ]);

            // save transaksi detail
            $id_trx = $trx->id;

            // foreach ($id_kode_perkiraan1 as $kode_acc) {
            for ($i = 0; $i < count($id_kode_perkiraan1); $i++) {
                TransaksiDetail::create([
                    'id_transaksi' => $id_trx,
                    'id_kode_perkiraan' => $id_kode_perkiraan1[$i],
                    'jenis' => $jenis1[$i],
                    'jumlah' => $jumlah1[$i]
                ]);
            }

            // Commit the transaction if all operations are successful
            DB::commit();

            Alert::success('Berhasil', 'Transaksi berhasil disimpan');
            return redirect()->route('transJurnal');
        } catch (\Exception $e) {
            DB::rollback();

            Alert::error('Gagal', 'Transaksi gagal disimpan, silahkan periksa kembali inputan anda');
            return redirect()->route('addTransJurnal');
        }
    }

    public function addModalDetail(Request $request)
    {
        $id_cabang = $request->query('id_cabang');
        $id_proyek = $request->query('id_proyek');
        $id_group_user = auth()->user()->id_group_user;

        $kodePerkiraans = KodePerkiraan::where('id_cabang', $id_cabang)
            ->where('id_proyek', $id_proyek)
            ->orderBy('kode', 'asc')->get();

        // if ($id_group_user == 1) {
        //     $kodePerkiraans = KodePerkiraan::orderBy('kode', 'asc')->get();
        // } else {
        //     if ($id_group_user == 2) {
        //         $kodePerkiraans = KodePerkiraan::where('id_cabang', $id_cabang)
        //             ->where('id_proyek', 0)
        //             ->orderBy('kode', 'asc')->get();
        //     } else if ($id_group_user == 3) {
        //         $kodePerkiraans = KodePerkiraan::where('id_cabang', $id_cabang)
        //             ->where('id_proyek', $id_proyek)
        //             ->orderBy('kode', 'asc')->get();
        //     }
        // }

        return view('modal.addTransJurnalDetail', [
            'title' => 'Tambah Data Detail',
            'kodePerkiraans' => $kodePerkiraans
        ]);
    }

    public function viewModalDetail(Request $request)
    {
        $id_trx = $request->query('id');

        $transaksiDetails = TransaksiDetail::where('id_transaksi', $id_trx)->get();
        return view('modal.viewDetailTrx', [
            'title' => 'Detail Transaksi',
            'transaksiDetails' => $transaksiDetails
        ]);
    }

    public function hapusDetailById($id)
    {
        $transaksiDetail = TransaksiDetail::findOrFail($id);

        $id_trx = $transaksiDetail['id_transaksi'];

        try {
            DB::beginTransaction();

            $transaksiDetail->delete();

            // Commit the transaction if all operations are successful
            DB::commit();

            Alert::success('Berhasil', 'Detail transaksi berhasil dihapus');
            return redirect()->route('editTransJurnal', $id_trx);
        } catch (\Exception $e) {
            DB::rollback();

            Alert::error('Gagal', 'Transaksi gagal dihapus');
            return redirect()->route('editTransJurnal', $id_trx);
        }
    }

    public function edit($id)
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_cabang = auth()->user()->id_cabang;

        // get list cabang by group user
        if ($id_group_user == 1) {
            // admin
            $cabangs = Cabang::all();
        } else {
            // cabang/proyek
            $cabangs = Cabang::where('id', $id_cabang)->get();
        }

        $proyeks = '';
        // utk user cabang/proyek, otomatis muncul list proyeknya by cabang
        if ($id_group_user == 2) {
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
        } else if ($id_group_user == 3) {
            $id_user = auth()->user()->id;

            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)
                ->orderBy('proyeks.created_at', 'desc')->get();
        }

        // get list kode bukti
        $kode_buktis = KodeBukti::all();
        $transaksi = Transaksi::findOrFail($id);

        $countDetail = count($transaksi->transaksiDetail);

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data detail?";
        confirmDelete($title, $text);

        //return view('transaksi.transaksiedit', compact('transaksi', 'cabangs', 'proyeks', 'groupusers', 'userproyeks'));
        return view('transaksi.transaksiedit', [
            'cabangs' => $cabangs,
            'proyeks' => $proyeks,
            'kode_buktis' => $kode_buktis,
            'id_group_user' => $id_group_user,
            'transaksi' => $transaksi,
            'countDetail' => $countDetail
        ]);
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'id_kode_bukti' => 'required',
            'no_urut_bukti' => 'required'
        ]);

        // ------------
        try {
            DB::beginTransaction();

            // generate no jurnal
            $month = \Carbon\Carbon::parse($request['tgl'])->format('m');
            $year = Carbon::parse($request['tgl'])->year;

            $noBukti = KodeBukti::where('id', $request['id_kode_bukti'])->first();
            $noBuktiFull = $request['no_urut_bukti'] . '/' . $noBukti['kode'] . '/' . $month . '/' . $year;

            $transaksi->tgl = $request->tgl;
            $transaksi->keterangan = $request->keterangan;

            if ($request->file_dokumen != '') {
                $oldFile = $transaksi->file_dokumen;
                if ($oldFile != '') {
                    Storage::delete('transaksis/' . $oldFile);
                }

                $extension = $request->file('file_dokumen')->getClientOriginalExtension();

                $fileName = date("Ymd") . '_' . time() . '.' . $extension;
                $request->file('file_dokumen')->storeAs('transaksis', $fileName);

                $transaksi->file_dokumen = $fileName;
            }

            $transaksi->save();

            // save transaksi detail
            // detailnya
            $id1 = $request['id1'];
            $id_kode_perkiraan1 = $request['id_kode_perkiraan1'];
            $jenis1 = $request['jenis1'];
            $jumlah1 = $request['jumlah1'];

            for ($i = 0; $i < count($id_kode_perkiraan1); $i++) {
                if ($id1[$i] == 0) {
                    TransaksiDetail::create([
                        'id_transaksi' => $id,
                        'id_kode_perkiraan' => $id_kode_perkiraan1[$i],
                        'jenis' => $jenis1[$i],
                        'jumlah' => $jumlah1[$i]
                    ]);
                }
            }

            // Commit the transaction if all operations are successful
            DB::commit();

            Alert::success('Berhasil', 'Transaksi berhasil diupdate');
            return redirect()->route('transJurnal');
        } catch (\Exception $e) {
            DB::rollback();

            Alert::error('Gagal', 'Transaksi gagal diupdate, silahkan periksa kembali inputan anda');
            return redirect()->route('editTransJurnal', $id);
        }
        // ------------
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        try {
            DB::beginTransaction();

            if ($transaksi->file_dokumen != '')
                Storage::delete('transaksis/' . $transaksi->file_dokumen);

            TransaksiDetail::where('id_transaksi', $id)->delete();
            $transaksi->delete();

            // Commit the transaction if all operations are successful
            DB::commit();

            Alert::success('Berhasil', 'Transaksi berhasil dihapus');
            return redirect()->route('transJurnal');
        } catch (\Exception $e) {
            DB::rollback();

            Alert::error('Gagal', 'Transaksi gagal dihapus');
            return redirect()->route('addTransJurnal');
        }
    }

    public function getNoUrutBukti(Request $request)
    {
        $id_cabang = $request->input('id_cabang');
        $id_proyek = $request->input('id_proyek');
        $id_kode_bukti = $request->input('id_kode_bukti');
        $tgl = $request->input('tgl');

        $noUrutBukti = '';
        if ($id_kode_bukti != '') {
            $month = \Carbon\Carbon::parse($tgl)->format('m');
            $year = Carbon::parse($tgl)->year;

            $noUrutBukti = Transaksi::where('id_cabang', $id_cabang)
                ->where('id_proyek', $id_proyek)
                ->where('id_kode_bukti', $id_kode_bukti)
                ->whereYear('tgl', $year)
                ->whereMonth('tgl', $month)
                ->max('no_urut_bukti');

            $noUrutBukti = $noUrutBukti + 1;

            if ($noUrutBukti < 10)
                $noUrutBukti = '000' . $noUrutBukti;
            else if ($noUrutBukti < 100)
                $noUrutBukti = '00' . $noUrutBukti;
            else if ($noUrutBukti < 1000)
                $noUrutBukti = '0' . $noUrutBukti;
        }

        return $noUrutBukti;
    }

    public function bukuTambahan()
    {
        $tgl_awal = Carbon::now()->startOfMonth()->toDateString();
        $tgl_akhir = Carbon::now()->toDateString();
        $kodePerkiraan = '';

        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;
        $id_cabang = auth()->user()->id_cabang;

        // $transaksis = Transaksi::query();
        // $transaksis->whereBetween('tgl', array($tgl_awal, $tgl_akhir));

        // get list cabang by group user
        if ($id_group_user == 1) {
            // admin
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();
            $id_proyek = 'all';

            // $transaksis->orderBy('created_at', 'desc');
        } else if ($id_group_user == 2) {
            // cabang
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
            $id_proyek = 'all';

            // $transaksis->where('id_cabang', $id_cabang)
            //     ->orderBy('created_at', 'desc');
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

            // $transaksis->where('id_cabang', $id_cabang)
            //     ->where('id_proyek', $id_proyek)
            //     ->orderBy('created_at', 'desc');
        }

        //dd($transaksis->toSql());
        //$results = $transaksis->get();
        $isView = '';
        return view('transaksi.bukuTambahan', compact('id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks', 'tgl_awal', 'tgl_akhir', 'kodePerkiraan', 'isView'));
    }

    public function bukuTambahanSearch(Request $request)
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;

        $id_cabang = $request->input('id_cabang');
        $id_proyek = $request->input('id_proyek');
        $kodePerkiraan = $request->input('kodePerkiraan');
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');

        /*
$transaksis = Transaksi::query()
            ->addSelect([
                'isLock' => KunciTransaksi::query()
                    ->select('status_akses')
                    ->whereColumn('id_cabang', 'transaksis.id_cabang')
                    ->whereColumn('id_proyek', 'transaksis.id_proyek')
                    ->whereRaw('bulan = MONTH(transaksis.tgl)')
                    ->whereRaw('tahun = YEAR(transaksis.tgl)')
                    ->limit(1)
            ]);
        $transaksis->whereBetween('tgl', array($tgl_awal, $tgl_akhir));
        */

        $transaksiDetails = TransaksiDetail::with(['kodePerkiraan', 'transaksi.cabang', 'transaksi.proyek'])
            ->join('transaksis', 'transaksis.id', '=', 'transaksi_details.id_transaksi')
            ->addSelect([
                'isLock' => KunciTransaksi::query()
                    ->select('status_akses')
                    ->whereColumn('id_cabang', 'transaksis.id_cabang')
                    ->whereColumn('id_proyek', 'transaksis.id_proyek')
                    ->whereRaw('bulan = MONTH(transaksis.tgl)')
                    ->whereRaw('tahun = YEAR(transaksis.tgl)')
                    ->limit(1)
            ]);

        $transaksiDetails->whereBetween('transaksis.tgl', [$tgl_awal, $tgl_akhir]);

        //->get(['transaksi_details.id', 'transaksi_details.id_kode_perkiraan', 'transaksi_details.id_transaksi']);

        // $transaksis = Transaksi::query()
        //     ->join('transaksi_details', 'transaksis.id', '=', 'transaksi_details.id_transaksi')
        //     ->whereBetween('tgl', array($tgl_awal, $tgl_akhir));

        //->select('transaksis.*', 'transaksi_details.*');
        // $transaksis->orderBy('created_at', 'desc');

        if ($id_group_user == 1) {
            // admin
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();

            if ($id_cabang != '')
                $transaksiDetails->where('id_cabang', $id_cabang);

            if ($id_proyek != 'all') {
                $transaksiDetails->where('id_proyek', $id_proyek);
            }
        } else if ($id_group_user == 2) {
            // cabang
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();

            $transaksiDetails->where('id_cabang', $id_cabang);
            if ($id_proyek != 'all') {
                $transaksiDetails->where('id_proyek', $id_proyek);
            }
        } else {
            // proyek
            $cabangs = Cabang::where('id', $id_cabang)->get();

            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->get();

            $proyek_first = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->first();

            $transaksiDetails->where('id_cabang', $id_cabang)
                ->where('id_proyek', $id_proyek);
        }

        $transaksiDetails->whereHas('kodePerkiraan', function ($query) use ($kodePerkiraan) {
            $query->where('kode', 'like', '%' . $kodePerkiraan . '%');
        });
        $transaksiDetails->orderBy('transaksis.tgl', 'asc')->orderBy('transaksi_details.jenis', 'asc');

        // dd($transaksiDetails->toSql());
        $results = $transaksiDetails->get([
            'isLock',
            'transaksi_details.id',
            'transaksi_details.id_kode_perkiraan', 'transaksi_details.id_transaksi',
            'transaksi_details.jenis', 'transaksi_details.jumlah'
        ]);
        // dd($results);
        $isView = 1;
        return view('transaksi.bukuTambahan', compact('id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks', 'tgl_awal', 'tgl_akhir', 'kodePerkiraan', 'results', 'isView'));
        // --------
    }
}

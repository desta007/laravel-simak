<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\GroupAccount;
use App\Models\KodePerkiraan;
use App\Models\Proyek;
use App\Models\SaldoAkun;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generalLedger()
    {
        // $bulan1 = Carbon::now()->month;
        $bulan1 = 1;
        $bulan2 = Carbon::now()->month;
        $tahun = Carbon::now()->year;
        $kodePerkiraan = '';

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
        return view('report.generalLedger', compact('id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks', 'bulan1', 'bulan2', 'tahun', 'kodePerkiraan', 'isView'));
    }

    public function generalLedgerSearch(Request $request)
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;

        $bulan1 = $request->input('bulan1');
        $bulan2 = $request->input('bulan2');
        $tahun = $request->input('tahun');

        $id_cabang = $request->input('id_cabang');
        $id_proyek = $request->input('id_proyek');
        $kodePerkiraan = $request->input('kodePerkiraan');

        // get list cabang by group user
        if ($id_group_user == 1) {
            // admin
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();
            //$id_proyek = 'all';
        } else if ($id_group_user == 2) {
            // cabang
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
            //$id_proyek = 'all';
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

        // get data kode perkiraan dan saldo
        $listAkun = KodePerkiraan::query();
        if ($id_cabang != '')
            $listAkun->where('id_cabang', $id_cabang);
        if ($id_proyek != 'all')
            $listAkun->where('id_proyek', $id_proyek);
        $listAkun->where('kode', 'like', $kodePerkiraan . '%')
            ->orderBy('kode', 'desc');
        //dd($listAkun->toSql());

        $results = $listAkun->get();

        $listData = array();
        foreach ($results as $akun) {
            // get saldo awal, mutasi, dan saldo akhir
            // 1. saldo awal tahun
            $dataSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($akun, $id_cabang, $id_proyek) {
                    $query->where('kode', $akun->kode);
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();
            // dd($dataSaldoAwal);

            $saldoAwalDebet = 0;
            $saldoAwalKredit = 0;
            foreach ($dataSaldoAwal as $sa) {
                $saldoAwalDebet += $sa->saldo_debet;
                $saldoAwalKredit += $sa->saldo_kredit;
            }

            //$jumlahSaldoAwal = 0;
            if (substr($akun->kode, 0, 1) == '1' || substr($akun->kode, 0, 1) == '5' || substr($akun->kode, 0, 1) == '6' || substr($akun->kode, 0, 1) == '8') {
                $jumlahSaldoAwal = $saldoAwalDebet - $saldoAwalKredit;
            } else {
                $jumlahSaldoAwal = $saldoAwalKredit - $saldoAwalDebet;
            }

            // 2. hitung total dari jan s/d bulan1
            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan1; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($akun, $id_cabang, $id_proyek) {
                        $query->where('kode', $akun->kode);
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    if (substr($akunnya->kodePerkiraan->kode, 0, 1) == '1' || substr($akunnya->kodePerkiraan->kode, 0, 1) == '5' || substr($akunnya->kodePerkiraan->kode, 0, 1) == '6' || substr($akunnya->kodePerkiraan->kode, 0, 1) == '8') {
                        $jumlahSaldoAwal += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                    } else {
                        $jumlahSaldoAwal += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                    }
                }
            }
            // smape sini done 17-04-2024 4:54.
            // lanjut 18-04-2024

            // mutasi dari bulan awal s/d bulan akhir
            $jumlahSaldoMutasi = 0;
            $jumlahSaldoMutasiDebet = 0;
            $jumlahSaldoMutasiKredit = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($akun, $id_cabang, $id_proyek) {
                        $query->where('kode', $akun->kode);
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlahSaldoMutasiDebet += $akunnya->saldo_debet;
                    $jumlahSaldoMutasiKredit += $akunnya->saldo_kredit;

                    if (substr($akunnya->kodePerkiraan->kode, 0, 1) == '1' || substr($akunnya->kodePerkiraan->kode, 0, 1) == '5' || substr($akunnya->kodePerkiraan->kode, 0, 1) == '6' || substr($akunnya->kodePerkiraan->kode, 0, 1) == '8') {
                        $jumlahSaldoMutasi += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                    } else {
                        $jumlahSaldoMutasi += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                    }
                }
            }

            // saldo akhir, perhitungan
            $jumlahSaldoAkhir = $jumlahSaldoAwal + $jumlahSaldoMutasi;
            //echo $akun->kode . " " . $akunnya->saldo_debet . " " . $akunnya->saldo_kredit . " " . $jumlahSaldoMutasi . "<br>";

            $listData[] = array(
                'kode' => $akun->kode,
                'nama' => $akun->nama,
                'saldo_awal' => $jumlahSaldoAwal,
                'mutasi_debet' => $jumlahSaldoMutasiDebet,
                'mutasi_kredit' => $jumlahSaldoMutasiKredit,
                'saldo_akhir' => $jumlahSaldoAkhir
            );
        }
        //die();

        $isView = 1;

        return view('report.generalLedger', compact(
            'id_group_user',
            'id_cabang',
            'id_proyek',
            'cabangs',
            'proyeks',
            'bulan1',
            'bulan2',
            'tahun',
            'kodePerkiraan',
            'isView',
            'listData'
        ));
    }

    public function labaRugi()
    {
        // $bulan1 = Carbon::now()->month;
        $bulan1 = 1;
        $bulan2 = Carbon::now()->month;
        $tahun = Carbon::now()->year;

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
        return view('report.labaRugi', compact('id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks', 'bulan1', 'bulan2', 'tahun', 'isView'));
    }

    public function labaRugiSearch(Request $request)
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;

        $bulan1 = $request->input('bulan1');
        $bulan2 = $request->input('bulan2');
        $tahun = $request->input('tahun');

        $id_cabang = $request->input('id_cabang');
        $id_proyek = $request->input('id_proyek');

        // echo $bulan1 . " " . $bulan2 . " " . $tahun . " " . $id_cabang . " " . $id_proyek;
        // die();

        // get list cabang by group user
        if ($id_group_user == 1) {
            // admin
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();
            //$id_proyek = 'all';
        } else if ($id_group_user == 2) {
            // cabang
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
            //$id_proyek = 'all';
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

        // alur, dari query ini di simkso (lanjut besok):
        //select * from tbl_laporan where jenis_laporan='LABA/RUGI' and kelompok_laporan='LABA/RUGI' order by kode_sub_laporan::int

        // 1. HASIL PENJUALAN (40x)
        $listGroupAcc40x = GroupAccount::where('kode', 'like', '40%')->orderBy('kode', 'asc')->get();
        $listData40x = array();
        foreach ($listGroupAcc40x as $groupAcc40x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc40x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc40x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }
            if ($jumlah != 0) {
                $listData40x[] = array(
                    'kode' => $groupAcc40x->kode,
                    'nama' => $groupAcc40x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 2. BIAYA PENJUALAN/PROYEK (50X)
        $listGroupAcc50x = GroupAccount::where('kode', 'like', '50%')->orderBy('kode', 'asc')->get();
        $listData50x = array();
        foreach ($listGroupAcc50x as $groupAcc50x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc50x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc50x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }
            if ($jumlah != 0) {
                $listData50x[] = array(
                    'kode' => $groupAcc50x->kode,
                    'nama' => $groupAcc50x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 4. HASIL JOINT OPERATION (41x)
        $listGroupAcc41x = GroupAccount::where('kode', 'like', '41%')->orderBy('kode', 'asc')->get();
        $listData41x = array();
        foreach ($listGroupAcc41x as $groupAcc41x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc41x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc41x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }
            if ($jumlah != 0) {
                $listData41x[] = array(
                    'kode' => $groupAcc41x->kode,
                    'nama' => $groupAcc41x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 5. BIAYA JOINT OPERATION (51x)
        $listGroupAcc51x = GroupAccount::where('kode', 'like', '51%')->orderBy('kode', 'asc')->get();
        $listData51x = array();
        foreach ($listGroupAcc51x as $groupAcc51x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc51x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc51x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }
            if ($jumlah != 0) {
                $listData51x[] = array(
                    'kode' => $groupAcc51x->kode,
                    'nama' => $groupAcc51x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 7. HASIL PENJUALAN PROPERTY (42x)
        $listGroupAcc42x = GroupAccount::where('kode', 'like', '42%')->orderBy('kode', 'asc')->get();
        $listData42x = array();
        foreach ($listGroupAcc42x as $groupAcc42x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc42x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc42x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }
            if ($jumlah != 0) {
                $listData42x[] = array(
                    'kode' => $groupAcc42x->kode,
                    'nama' => $groupAcc42x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 8. HARGA POKOK PROPERTY (52x)
        $listGroupAcc52x = GroupAccount::where('kode', 'like', '52%')->orderBy('kode', 'asc')->get();
        $listData52x = array();
        foreach ($listGroupAcc52x as $groupAcc52x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc52x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc52x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }
            if ($jumlah != 0) {
                $listData52x[] = array(
                    'kode' => $groupAcc52x->kode,
                    'nama' => $groupAcc52x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 10. HASIL PENJUALAN BRG/TRADING (43x)
        $listGroupAcc43x = GroupAccount::where('kode', 'like', '43%')->orderBy('kode', 'asc')->get();
        $listData43x = array();
        foreach ($listGroupAcc43x as $groupAcc43x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc43x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc43x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }
            if ($jumlah != 0) {
                $listData43x[] = array(
                    'kode' => $groupAcc43x->kode,
                    'nama' => $groupAcc43x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 11. HARGA POKOK BRG/TRADING (53x)
        $listGroupAcc53x = GroupAccount::where('kode', 'like', '53%')->orderBy('kode', 'asc')->get();
        $listData53x = array();
        foreach ($listGroupAcc53x as $groupAcc53x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc53x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc53x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }
            if ($jumlah != 0) {
                $listData53x[] = array(
                    'kode' => $groupAcc53x->kode,
                    'nama' => $groupAcc53x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 13. HASIL SEWA PROPERTY/PERALATAN (44x)
        $listGroupAcc44x = GroupAccount::where('kode', 'like', '44%')->orderBy('kode', 'asc')->get();
        $listData44x = array();
        foreach ($listGroupAcc44x as $groupAcc44x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc44x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc44x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }
            if ($jumlah != 0) {
                $listData44x[] = array(
                    'kode' => $groupAcc44x->kode,
                    'nama' => $groupAcc44x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 14. BIAYA SEWA PROPERTY/PERALATAN (54x)
        $listGroupAcc54x = GroupAccount::where('kode', 'like', '54%')->orderBy('kode', 'asc')->get();
        $listData54x = array();
        foreach ($listGroupAcc54x as $groupAcc54x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc54x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc54x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }
            if ($jumlah != 0) {
                $listData54x[] = array(
                    'kode' => $groupAcc54x->kode,
                    'nama' => $groupAcc54x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 17. BIAYA TIDAK LANGSUNG (60X)
        $listGroupAcc60x = GroupAccount::where('kode', 'like', '60%')->orderBy('kode', 'asc')->get();
        $listData60x = array();
        foreach ($listGroupAcc60x as $groupAcc60x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc60x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc60x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }
            if ($jumlah != 0) {
                $listData60x[] = array(
                    'kode' => $groupAcc60x->kode,
                    'nama' => $groupAcc60x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 19. HASIL LAIN-LAIN (7xx)
        $listGroupAcc7xx = GroupAccount::where('kode', 'like', '7%')->orderBy('kode', 'asc')->get();
        $listData7xx = array();
        foreach ($listGroupAcc7xx as $groupAcc7xx) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc7xx, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc7xx->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }
            if ($jumlah != 0) {
                $listData7xx[] = array(
                    'kode' => $groupAcc7xx->kode,
                    'nama' => $groupAcc7xx->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 20. BIAYA LAIN-LAIN (80x)
        $listGroupAcc80x = GroupAccount::where('kode', 'like', '80%')->orderBy('kode', 'asc')->get();
        $listData80x = array();
        foreach ($listGroupAcc80x as $groupAcc80x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc80x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc80x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }
            if ($jumlah != 0) {
                $listData80x[] = array(
                    'kode' => $groupAcc80x->kode,
                    'nama' => $groupAcc80x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        // 23. PAJAK FINAL (83x)
        $listGroupAcc83x = GroupAccount::where('kode', 'like', '83%')->orderBy('kode', 'asc')->get();
        $listData83x = array();
        foreach ($listGroupAcc83x as $groupAcc83x) {

            // get saldo tiap bulan
            $jumlah = 0;
            for ($i = $bulan1; $i <= $bulan2; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc83x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc83x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }
            if ($jumlah != 0) {
                $listData83x[] = array(
                    'kode' => $groupAcc83x->kode,
                    'nama' => $groupAcc83x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ------------------------------------------------------------------------

        /*
        3. LABA (RUGI) USAHA (1-2)

        6. LABA (RUGI) OPERATION (4-5)

        9. LABA (RUGI) PROPERTY (7-8)

        12. LABA (RUGI) TRADING (10-11)

        15. LABA (RUGI) SEWA PROPERTY/PERALATAN (13-14)

        16. LABA(RUGI) USAHA BRUTO (3+6+9+12+15)

        18. LABA(RUGI) USAHA (16-17)

        21. LABA(RUGI) LAIN-LAIN (19-20)
        22. LABA(RUGI) KOMPREHENSIF SEBELUM PPh (18+21)

        24. LABA(RUGI) KOMPREHENSIF SETELAH PPh (22-23)

        */

        $isView = 1;

        return view('report.labaRugi', compact(
            'id_group_user',
            'id_cabang',
            'id_proyek',
            'cabangs',
            'proyeks',
            'bulan1',
            'bulan2',
            'tahun',
            'isView',
            'listData40x',
            'listData50x',
            'listData41x',
            'listData51x',
            'listData42x',
            'listData52x',
            'listData43x',
            'listData53x',
            'listData44x',
            'listData54x',
            'listData60x',
            'listData7xx',
            'listData80x',
            'listData83x',
        ));
    }

    public function neraca()
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

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
        return view('report.neraca', compact(
            'id_group_user',
            'id_cabang',
            'id_proyek',
            'cabangs',
            'proyeks',
            'bulan',
            'tahun',
            'isView'
        ));
    }

    public function neracaSearch(Request $request)
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $id_cabang = $request->input('id_cabang');
        $id_proyek = $request->input('id_proyek');

        $btnView = $request->input('view');
        // $btnExport = $request->input('export');

        // echo $btnView . " " . $btnExport;
        // die();

        // TO DO alur:
        // dibikin terpisah untuk masing2 bagian kedalam variabel result array seperti biasa di CI
        // misal aset lancar, bikin query utk get data summary account ke variabel $data10x, $data11x, dst
        // dan juga lainnya sama
        /*

        ASET
        --------------
        I. ASET LANCAR
            - get data summary (tabel saldo_akuns) dgn kode group acc awalan 10x, 11x, 12x, 13x, 14x, 15x, 16x
        II. INVESTASI JANGKA PANJANG
            - get data summary kode group acc 17x
        III. ASET TETAP
            - get data summary kode group acc 18x
        IV. HAK PENGELOLAAN
            - get data summary kode group acc 19x
        V. ASET TAK BERWUJUD
            - get data summary kode group acc 1Ax
        VI. ASET LAIN-LAIN
            - get data summary kode group acc 1Bx

        LIABILITAS & EKUITAS
        I. LIABILITAS JANGKA PENDEK
            - get data summary kode group acc 20x, 21x, 22x, 23x, 24x
        II. LIABILITAS JANGKA PANJANG
            - get data summary kode group acc 25x, 26x
        III. LIABILITAS LAIN-LAIN
            - get data summary kode group acc 27x, 28x
        IV. EKUITAS
            - get data summary kode group acc 30x, 31x, 32x
        */

        // get list cabang by group user
        if ($id_group_user == 1) {
            // admin
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();
            //$id_proyek = 'all';
        } else if ($id_group_user == 2) {
            // cabang
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
            //$id_proyek = 'all';
        } else {
            // proyek
            $cabangs = Cabang::where('id', $id_cabang)->get();

            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->get();

            $proyek_first = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->first();

            //$id_proyek = $proyek_first['id'];
        }

        // query get data group akun dgn awalan 10x
        // perulangan dari bulan 1 s/d $bulan didalam perulangan group akun
        // query get jumlah data kode akun (10x) utk tiap bulan tsb

        $listGroupAcc10x = GroupAccount::where('kode', 'like', '10%')->orderBy('kode', 'asc')->get();
        // $listData10x = [];
        $listData10x = array();
        foreach ($listGroupAcc10x as $groupAcc10x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc10x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc10x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();
            //dd($listAkunSaldoAwal->toSql());

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc10x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc10x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }
            if ($jumlah != 0) {
                $listData10x[] = array(
                    'kode' => $groupAcc10x->kode,
                    'nama' => $groupAcc10x->nama,
                    'saldo' => $jumlah
                );
            }
            // else
            //     $listData10x = '';
        }
        // ------------------------------------------------------------------------

        // akun 11
        $listGroupAcc11x = GroupAccount::where('kode', 'like', '11%')->orderBy('kode', 'asc')->get();
        $listData11x = array();
        foreach ($listGroupAcc11x as $groupAcc11x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc11x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc11x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc11x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc11x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }

            if ($jumlah != 0) {
                $listData11x[] = array(
                    'kode' => $groupAcc11x->kode,
                    'nama' => $groupAcc11x->nama,
                    'saldo' => $jumlah
                );
            }
            // else {
            //     $listData11x = '';
            // }
        }
        // ------------------------------------------------------------------------

        // akun 12
        $listGroupAcc12x = GroupAccount::where('kode', 'like', '12%')->orderBy('kode', 'asc')->get();
        $listData12x = array();
        foreach ($listGroupAcc12x as $groupAcc12x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc12x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc12x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc12x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc12x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }

            if ($jumlah != 0) {
                $listData12x[] = array(
                    'kode' => $groupAcc12x->kode,
                    'nama' => $groupAcc12x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // akun 13
        $listGroupAcc13x = GroupAccount::where('kode', 'like', '13%')->orderBy('kode', 'asc')->get();
        $listData13x = array();
        foreach ($listGroupAcc13x as $groupAcc13x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc13x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc13x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc13x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc13x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }

            if ($jumlah != 0) {
                $listData13x[] = array(
                    'kode' => $groupAcc13x->kode,
                    'nama' => $groupAcc13x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // akun 14
        $listGroupAcc14x = GroupAccount::where('kode', 'like', '14%')->orderBy('kode', 'asc')->get();
        $listData14x = array();
        foreach ($listGroupAcc14x as $groupAcc14x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc14x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc14x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc14x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc14x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }

            if ($jumlah != 0) {
                $listData14x[] = array(
                    'kode' => $groupAcc14x->kode,
                    'nama' => $groupAcc14x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // akun 15
        $listGroupAcc15x = GroupAccount::where('kode', 'like', '15%')->orderBy('kode', 'asc')->get();
        $listData15x = array();
        foreach ($listGroupAcc15x as $groupAcc15x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc15x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc15x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc15x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc15x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }

            if ($jumlah != 0) {
                $listData15x[] = array(
                    'kode' => $groupAcc15x->kode,
                    'nama' => $groupAcc15x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // akun 16
        $listGroupAcc16x = GroupAccount::where('kode', 'like', '16%')->orderBy('kode', 'asc')->get();
        $listData16x = array();
        foreach ($listGroupAcc16x as $groupAcc16x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc16x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc16x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc16x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc16x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }

            if ($jumlah != 0) {
                $listData16x[] = array(
                    'kode' => $groupAcc16x->kode,
                    'nama' => $groupAcc16x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // akun 17
        $listGroupAcc17x = GroupAccount::where('kode', 'like', '17%')->orderBy('kode', 'asc')->get();
        $listData17x = array();
        foreach ($listGroupAcc17x as $groupAcc17x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc17x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc17x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc17x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc17x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }

            if ($jumlah != 0) {
                $listData17x[] = array(
                    'kode' => $groupAcc17x->kode,
                    'nama' => $groupAcc17x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // akun 18
        $listGroupAcc18x = GroupAccount::where('kode', 'like', '18%')->orderBy('kode', 'asc')->get();
        $listData18x = array();
        foreach ($listGroupAcc18x as $groupAcc18x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc18x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc18x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc18x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc18x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }

            if ($jumlah != 0) {
                $listData18x[] = array(
                    'kode' => $groupAcc18x->kode,
                    'nama' => $groupAcc18x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // akun 19
        $listGroupAcc19x = GroupAccount::where('kode', 'like', '19%')->orderBy('kode', 'asc')->get();
        $listData19x = array();
        foreach ($listGroupAcc19x as $groupAcc19x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc19x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc19x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc19x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc19x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }

            if ($jumlah != 0) {
                $listData19x[] = array(
                    'kode' => $groupAcc19x->kode,
                    'nama' => $groupAcc19x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // akun 1A
        $listGroupAcc1Ax = GroupAccount::where('kode', 'like', '1A%')->orderBy('kode', 'asc')->get();
        $listData1Ax = array();
        foreach ($listGroupAcc1Ax as $groupAcc1Ax) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc1Ax, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc1Ax->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc1Ax, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc1Ax->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }

            if ($jumlah != 0) {
                $listData1Ax[] = array(
                    'kode' => $groupAcc1Ax->kode,
                    'nama' => $groupAcc1Ax->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // akun 1B
        $listGroupAcc1Bx = GroupAccount::where('kode', 'like', '1B%')->orderBy('kode', 'asc')->get();
        $listData1Bx = array();
        foreach ($listGroupAcc1Bx as $groupAcc1Bx) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc1Bx, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc1Bx->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc1Bx, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc1Bx->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                }
            }

            if ($jumlah != 0) {
                $listData1Bx[] = array(
                    'kode' => $groupAcc1Bx->kode,
                    'nama' => $groupAcc1Bx->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // AKUN LIABILITAS & EKUITAS (20x, 21x, 22x, 23x, 24x, 25x, 26x, 27x, 28x, 30x, 31x, 32x)

        // 20X
        $listGroupAcc20x = GroupAccount::where('kode', 'like', '20%')->orderBy('kode', 'asc')->get();
        $listData20x = array();
        foreach ($listGroupAcc20x as $groupAcc20x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc20x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc20x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet; // khusus akun 2, dibalik kredit-debet
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc20x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc20x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }

            if ($jumlah != 0) {
                $listData20x[] = array(
                    'kode' => $groupAcc20x->kode,
                    'nama' => $groupAcc20x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // 21X
        $listGroupAcc21x = GroupAccount::where('kode', 'like', '21%')->orderBy('kode', 'asc')->get();
        $listData21x = array();
        foreach ($listGroupAcc21x as $groupAcc21x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc21x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc21x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet; // khusus akun 2, dibalik kredit-debet
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc21x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc21x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }

            if ($jumlah != 0) {
                $listData21x[] = array(
                    'kode' => $groupAcc21x->kode,
                    'nama' => $groupAcc21x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // 22X
        $listGroupAcc22x = GroupAccount::where('kode', 'like', '22%')->orderBy('kode', 'asc')->get();
        $listData22x = array();
        foreach ($listGroupAcc22x as $groupAcc22x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc22x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc22x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet; // khusus akun 2, dibalik kredit-debet
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc22x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc22x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }

            if ($jumlah != 0) {
                $listData22x[] = array(
                    'kode' => $groupAcc22x->kode,
                    'nama' => $groupAcc22x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // 23X
        $listGroupAcc23x = GroupAccount::where('kode', 'like', '23%')->orderBy('kode', 'asc')->get();
        $listData23x = array();
        foreach ($listGroupAcc23x as $groupAcc23x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc23x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc23x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet; // khusus akun 2, dibalik kredit-debet
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc23x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc23x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }

            if ($jumlah != 0) {
                $listData23x[] = array(
                    'kode' => $groupAcc23x->kode,
                    'nama' => $groupAcc23x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // 24X
        $listGroupAcc24x = GroupAccount::where('kode', 'like', '24%')->orderBy('kode', 'asc')->get();
        $listData24x = array();
        foreach ($listGroupAcc24x as $groupAcc24x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc24x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc24x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet; // khusus akun 2, dibalik kredit-debet
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc24x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc24x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }

            if ($jumlah != 0) {
                $listData24x[] = array(
                    'kode' => $groupAcc24x->kode,
                    'nama' => $groupAcc24x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // 25X
        $listGroupAcc25x = GroupAccount::where('kode', 'like', '25%')->orderBy('kode', 'asc')->get();
        $listData25x = array();
        foreach ($listGroupAcc25x as $groupAcc25x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc25x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc25x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet; // khusus akun 2, dibalik kredit-debet
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc25x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc25x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }

            if ($jumlah != 0) {
                $listData25x[] = array(
                    'kode' => $groupAcc25x->kode,
                    'nama' => $groupAcc25x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // 26X
        $listGroupAcc26x = GroupAccount::where('kode', 'like', '26%')->orderBy('kode', 'asc')->get();
        $listData26x = array();
        foreach ($listGroupAcc26x as $groupAcc26x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc26x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc26x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet; // khusus akun 2, dibalik kredit-debet
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc26x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc26x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }

            if ($jumlah != 0) {
                $listData26x[] = array(
                    'kode' => $groupAcc26x->kode,
                    'nama' => $groupAcc26x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // 27X
        $listGroupAcc27x = GroupAccount::where('kode', 'like', '27%')->orderBy('kode', 'asc')->get();
        $listData27x = array();
        foreach ($listGroupAcc27x as $groupAcc27x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc27x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc27x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet; // khusus akun 2, dibalik kredit-debet
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc27x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc27x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }

            if ($jumlah != 0) {
                $listData27x[] = array(
                    'kode' => $groupAcc27x->kode,
                    'nama' => $groupAcc27x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // 28X
        $listGroupAcc28x = GroupAccount::where('kode', 'like', '28%')->orderBy('kode', 'asc')->get();
        $listData28x = array();
        foreach ($listGroupAcc28x as $groupAcc28x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc28x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc28x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet; // khusus akun 2, dibalik kredit-debet
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc28x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc28x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }

            if ($jumlah != 0) {
                $listData28x[] = array(
                    'kode' => $groupAcc28x->kode,
                    'nama' => $groupAcc28x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // 30X
        $listGroupAcc30x = GroupAccount::where('kode', 'like', '30%')->orderBy('kode', 'asc')->get();
        $listData30x = array();
        foreach ($listGroupAcc30x as $groupAcc30x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc30x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc30x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet; // khusus akun 2, dibalik kredit-debet
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc30x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc30x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }

            if ($jumlah != 0) {
                $listData30x[] = array(
                    'kode' => $groupAcc30x->kode,
                    'nama' => $groupAcc30x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // 31X
        $listGroupAcc31x = GroupAccount::where('kode', 'like', '31%')->orderBy('kode', 'asc')->get();
        $listData31x = array();
        foreach ($listGroupAcc31x as $groupAcc31x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc31x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc31x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet; // khusus akun 2, dibalik kredit-debet
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc31x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc31x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }

            if ($jumlah != 0) {
                $listData31x[] = array(
                    'kode' => $groupAcc31x->kode,
                    'nama' => $groupAcc31x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        // 32X
        $listGroupAcc32x = GroupAccount::where('kode', 'like', '32%')->orderBy('kode', 'asc')->get();
        $listData32x = array();
        foreach ($listGroupAcc32x as $groupAcc32x) {
            // get saldo awal tahun
            $listAkunSaldoAwal = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($query) use ($groupAcc32x, $id_cabang, $id_proyek) {
                    $query->where('kode', 'like', $groupAcc32x->kode . '%');
                    if ($id_cabang != '')
                        $query->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $query->where('id_proyek', $id_proyek);
                })->get();

            $jumlah = 0;
            foreach ($listAkunSaldoAwal as $akunnya) {
                $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet; // khusus akun 2, dibalik kredit-debet
            }

            // get saldo tiap bulan
            for ($i = 1; $i <= $bulan; $i++) {
                $listAkunSaldo = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($query) use ($groupAcc32x, $id_cabang, $id_proyek) {
                        $query->where('kode', 'like', $groupAcc32x->kode . '%');
                        if ($id_cabang != '')
                            $query->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $query->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($listAkunSaldo as $akunnya) {
                    $jumlah += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                }
            }

            if ($jumlah != 0) {
                $listData32x[] = array(
                    'kode' => $groupAcc32x->kode,
                    'nama' => $groupAcc32x->nama,
                    'saldo' => $jumlah
                );
            }
        }
        // ---------------------------------------------------------------------------

        $isView = 1;
        return view('report.neraca', compact(
            'id_group_user',
            'id_cabang',
            'id_proyek',
            'cabangs',
            'proyeks',
            'bulan',
            'tahun',
            'isView',
            'listData10x',
            'listData11x',
            'listData12x',
            'listData13x',
            'listData14x',
            'listData15x',
            'listData16x',
            'listData17x',
            'listData18x',
            'listData19x',
            'listData1Ax',
            'listData1Bx',

            'listData20x',
            'listData21x',
            'listData22x',
            'listData23x',
            'listData24x',
            'listData25x',
            'listData26x',
            'listData27x',
            'listData28x',
            'listData30x',
            'listData31x',
            'listData32x',
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDataRequest;
use App\Models\Cabang;
use App\Models\GroupAccount;
use App\Models\KodePerkiraan;
use App\Models\Proyek;
use App\Models\SaldoAkun;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ProsesBulananController extends Controller
{
    public function index()
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

        return view('transaksi.prosesBulanan', compact('cabangs', 'proyeks'));
    }

    public function proses(StoreDataRequest $request)
    {
        $validatedData = $request->validated();

        $id_cabang = $request->input('id_cabang');
        $id_proyek = $request->input('id_proyek');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();

        // Construct the end date for the given month and year
        $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        // $transaksis = Transaksi::query();
        // $transaksis->whereBetween('tgl', array($tgl_awal, $tgl_akhir));

        // get nama cabang dan proyek
        $getCabang = Cabang::where('id', $id_cabang)->first();
        $namaCabang = $getCabang->nama;

        // get nama proyek
        if ($id_proyek != 0) {
            $getProyek = Proyek::where('id', $id_proyek)->first();
            $namaProyek = $getProyek->nama;
        } else
            $namaProyek = '(Non Proyek)';

        try {
            DB::beginTransaction();

            // get semua akun by cabang dan proyek
            $kodePerkiraans = KodePerkiraan::where('id_cabang', $id_cabang)
                ->where('id_proyek', $id_proyek)->get();

            $listAkun = [];
            foreach ($kodePerkiraans as $kodePerkiraan) {
                $listAkun[] = $kodePerkiraan->id;
            }

            // get semua akun di bulan transaksi yg dipilih
            $allTransAkun = Transaksi::join('transaksi_details', 'transaksis.id', '=', 'transaksi_details.id_transaksi')
                ->whereBetween('transaksis.tgl', array($startDate, $endDate))
                ->where('transaksis.id_cabang', $id_cabang)
                ->where('transaksis.id_proyek', $id_proyek)
                ->groupBy('transaksi_details.id_kode_perkiraan')
                ->pluck('transaksi_details.id_kode_perkiraan');

            $listTransAkun = [];
            foreach ($allTransAkun as $akun) {
                $listTransAkun[] = $akun;

                // query get total transaksi debet utk tiap2 akun
                $sumDebet = Transaksi::join('transaksi_details', 'transaksis.id', '=', 'transaksi_details.id_transaksi')
                    ->whereBetween('transaksis.tgl', array($startDate, $endDate))
                    ->where('transaksis.id_cabang', $id_cabang)
                    ->where('transaksis.id_proyek', $id_proyek)
                    ->where('transaksi_details.id_kode_perkiraan', $akun)
                    ->where('transaksi_details.jenis', 'D')
                    ->sum('transaksi_details.jumlah');
                // echo $sumDebet . "<br>";

                // query get total transaksi kredit utk semua akun
                $sumKredit = Transaksi::join('transaksi_details', 'transaksis.id', '=', 'transaksi_details.id_transaksi')
                    ->whereBetween('transaksis.tgl', array($startDate, $endDate))
                    ->where('transaksis.id_cabang', $id_cabang)
                    ->where('transaksis.id_proyek', $id_proyek)
                    ->where('transaksi_details.id_kode_perkiraan', $akun)
                    ->where('transaksi_details.jenis', 'K')
                    ->sum('transaksi_details.jumlah');

                // echo $sumKredit . "<br>";

                // $kodePerkiraans = KodePerkiraan::where('id', $akun)->first();
                // $kodeGroupAcc = $kodePerkiraans->groupaccount->kode;
                //$firstKode = substr($kodeGroupAcc, 0, 1);
                // coding diatas utk keperluan laporan neraca. jika kode = 1 maka hitung pake saldo awal tahun

                // save ke tabel saldo_akun. cek apakah sudah ada data
                $saldoakunnya = SaldoAkun::where('id_kode_perkiraan', $akun)
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)->first();

                if ($saldoakunnya == null) {
                    SaldoAkun::create([
                        'id_kode_perkiraan' => $akun,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                        'saldo_debet' => $sumDebet,
                        'saldo_kredit' => $sumKredit
                    ]);
                } else {
                    $saldoakunnya->update([
                        'saldo_debet' => $sumDebet,
                        'saldo_kredit' => $sumKredit
                    ]);
                }
            }

            // cek akun apakah ada yg tidak ada didalam transaksi
            $akunDiluarTrx  = array_diff($listAkun, $listTransAkun);

            if (!empty($akunDiluarTrx)) {
                // insert data saldo dgn angka 0
                foreach ($akunDiluarTrx as $akun2) {
                    // cek apakah sudah ada data
                    $cekSaldoAkun = SaldoAkun::where('id_kode_perkiraan', $akun2)
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun)->first();

                    if ($cekSaldoAkun == null) {
                        SaldoAkun::create([
                            'id_kode_perkiraan' => $akun2,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'saldo_debet' => 0,
                            'saldo_kredit' => 0
                        ]);
                    } else {
                        $cekSaldoAkun->update([
                            'saldo_debet' => 0,
                            'saldo_kredit' => 0
                        ]);
                    }
                }
            }

            // 22-04-2024 hitung laba rugi di bulan ini, contek skrip labaRugiSearch, simpan ke akun 320 (D) dan 900 (K)
            // 1. HASIL PENJUALAN (40x)
            $listGroupAcc40x = GroupAccount::where('kode', 'like', '40%')->orderBy('kode', 'asc')->get();
            $subtotal40x = 0;
            foreach ($listGroupAcc40x as $groupAcc40x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal40x += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 2. BIAYA PENJUALAN/PROYEK (50X)
            $listGroupAcc50x = GroupAccount::where('kode', 'like', '50%')->orderBy('kode', 'asc')->get();
            $subtotal50x = 0;
            foreach ($listGroupAcc50x as $groupAcc50x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal50x += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 3. LABA (RUGI) PENJUALAN (1-2)
            $laba_rugi_penjualan = $subtotal40x - $subtotal50x;

            // 4. HASIL JOINT OPERATION (41x)
            $listGroupAcc41x = GroupAccount::where('kode', 'like', '41%')->orderBy('kode', 'asc')->get();
            $subtotal41x = 0;
            foreach ($listGroupAcc41x as $groupAcc41x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal41x += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 5. BIAYA JOINT OPERATION (51x)
            $listGroupAcc51x = GroupAccount::where('kode', 'like', '51%')->orderBy('kode', 'asc')->get();
            $subtotal51x = 0;
            foreach ($listGroupAcc51x as $groupAcc51x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal51x += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 6. LABA (RUGI) JOINT OPERATION (4-5)
            $laba_rugi_joint_operation = $subtotal41x - $subtotal51x;

            // 7. HASIL PENJUALAN PROPERTY (42x)
            $listGroupAcc42x = GroupAccount::where('kode', 'like', '42%')->orderBy('kode', 'asc')->get();
            $subtotal42x = 0;
            foreach ($listGroupAcc42x as $groupAcc42x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal42x += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 8. HARGA POKOK PROPERTY (52x)
            $listGroupAcc52x = GroupAccount::where('kode', 'like', '52%')->orderBy('kode', 'asc')->get();
            $subtotal52x = 0;
            foreach ($listGroupAcc52x as $groupAcc52x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal52x += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 9. LABA (RUGI) PROPERTY (7-8)
            $laba_rugi_property = $subtotal42x - $subtotal52x;

            // 10. HASIL PENJUALAN BRG/TRADING (43x)
            $listGroupAcc43x = GroupAccount::where('kode', 'like', '43%')->orderBy('kode', 'asc')->get();
            $subtotal43x = 0;
            foreach ($listGroupAcc43x as $groupAcc43x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal43x += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 11. HARGA POKOK BRG/TRADING (53x)
            $listGroupAcc53x = GroupAccount::where('kode', 'like', '53%')->orderBy('kode', 'asc')->get();
            $subtotal53x = 0;
            foreach ($listGroupAcc53x as $groupAcc53x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal53x += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 12. LABA (RUGI) TRADING (10-11)
            $laba_rugi_trading = $subtotal43x - $subtotal53x;

            // 13. HASIL SEWA PROPERTY/PERALATAN (44x)
            $listGroupAcc44x = GroupAccount::where('kode', 'like', '44%')->orderBy('kode', 'asc')->get();
            $subtotal44x = 0;
            foreach ($listGroupAcc44x as $groupAcc44x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal44x += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 14. BIAYA SEWA PROPERTY/PERALATAN (54x)
            $listGroupAcc54x = GroupAccount::where('kode', 'like', '54%')->orderBy('kode', 'asc')->get();
            $subtotal54x = 0;
            foreach ($listGroupAcc54x as $groupAcc54x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal54x += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 15. LABA (RUGI) SEWA PROPERTY/PERALATAN (13-14)
            $laba_rugi_sewa = $subtotal44x - $subtotal54x;

            // 16. LABA(RUGI) USAHA BRUTO (3+6+9+12+15)
            $laba_rugi_bruto =
                $laba_rugi_penjualan +
                $laba_rugi_joint_operation +
                $laba_rugi_property +
                $laba_rugi_trading +
                $laba_rugi_sewa;

            // 17. BIAYA TIDAK LANGSUNG (60X)
            $listGroupAcc60x = GroupAccount::where('kode', 'like', '60%')->orderBy('kode', 'asc')->get();
            $subtotal60x = 0;
            foreach ($listGroupAcc60x as $groupAcc60x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal60x += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 18. LABA(RUGI) USAHA (16-17)
            $laba_rugi_bersih = $laba_rugi_bruto - $subtotal60x;

            // 19. HASIL LAIN-LAIN (7xx)
            $listGroupAcc7xx = GroupAccount::where('kode', 'like', '7%')->orderBy('kode', 'asc')->get();
            $subtotal7xx = 0;
            foreach ($listGroupAcc7xx as $groupAcc7xx) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal7xx += $akunnya->saldo_kredit - $akunnya->saldo_debet;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 20. BIAYA LAIN-LAIN (80x)
            $listGroupAcc80x = GroupAccount::where('kode', 'like', '80%')->orderBy('kode', 'asc')->get();
            $subtotal80x = 0;
            foreach ($listGroupAcc80x as $groupAcc80x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal80x += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 21. LABA(RUGI) LAIN-LAIN (19-20)
            $laba_rugi_lain = $subtotal7xx - $subtotal80x;

            // 22. LABA(RUGI) KOMPREHENSIF SEBELUM PPh (18+21)
            $laba_rugi_sebelum_pph = $laba_rugi_bersih - $laba_rugi_lain;

            // 23. PAJAK FINAL (83x)
            $listGroupAcc83x = GroupAccount::where('kode', 'like', '83%')->orderBy('kode', 'asc')->get();
            $subtotal83x = 0;
            foreach ($listGroupAcc83x as $groupAcc83x) {
                // get saldo tiap bulan
                for ($i = $bulan; $i <= $bulan; $i++) {
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
                        $subtotal83x += $akunnya->saldo_debet - $akunnya->saldo_kredit;
                    }
                }
            }
            // ------------------------------------------------------------------------

            // 24. LABA(RUGI) KOMPREHENSIF SETELAH PPh (22-23)
            $laba_rugi_setelah_pph = $laba_rugi_sebelum_pph - $subtotal83x;

            // ambil kode akun 320 berdasarkan cabang dan proyek dipilih
            $akun320 = KodePerkiraan::where('id_cabang', $id_cabang)
                ->where('id_proyek', $id_proyek)
                ->where('kode', 'like', '320%')
                ->first();

            // insert/update saldo 320 di bulan dan tahun tsb.
            if ($akun320 != null) {
                $saldoAkun320 = SaldoAkun::where('id_kode_perkiraan', $akun320->id)
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)->first();

                if ($saldoAkun320 == null) {
                    if ($laba_rugi_setelah_pph >= 0) {
                        SaldoAkun::create([
                            'id_kode_perkiraan' => $akun320->id,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'saldo_debet' => 0,
                            'saldo_kredit' => abs($laba_rugi_setelah_pph)
                        ]);
                    } else {
                        SaldoAkun::create([
                            'id_kode_perkiraan' => $akun320->id,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'saldo_debet' => abs($laba_rugi_setelah_pph),
                            'saldo_kredit' => 0
                        ]);
                    }
                } else {
                    if ($laba_rugi_setelah_pph >= 0) {
                        $saldoAkun320->update([
                            'saldo_kredit' => abs($laba_rugi_setelah_pph)
                        ]);
                    } else {
                        $saldoAkun320->update([
                            'saldo_debet' => abs($laba_rugi_setelah_pph)
                        ]);
                    }
                }
            }

            // ambil kode akun 900 sebagai pasangan 320
            $akun900 = KodePerkiraan::where('id_cabang', $id_cabang)
                ->where('id_proyek', $id_proyek)
                ->where('kode', 'like', '900%')
                ->first();

            // insert/update saldo 900 di bulan dan tahun tsb.
            if ($akun900 != null) {
                $saldoAkun900 = SaldoAkun::where('id_kode_perkiraan', $akun900->id)
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)->first();

                if ($saldoAkun900 == null) {
                    if ($laba_rugi_setelah_pph >= 0) {
                        SaldoAkun::create([
                            'id_kode_perkiraan' => $akun900->id,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'saldo_debet' => abs($laba_rugi_setelah_pph),
                            'saldo_kredit' => 0
                        ]);
                    } else {
                        SaldoAkun::create([
                            'id_kode_perkiraan' => $akun900->id,
                            'bulan' => $bulan,
                            'tahun' => $tahun,
                            'saldo_debet' => 0,
                            'saldo_kredit' => abs($laba_rugi_setelah_pph)
                        ]);
                    }
                } else {
                    if ($laba_rugi_setelah_pph >= 0) {
                        $saldoAkun900->update([
                            'saldo_debet' => abs($laba_rugi_setelah_pph)
                        ]);
                    } else {
                        $saldoAkun900->update([
                            'saldo_kredit' => abs($laba_rugi_setelah_pph)
                        ]);
                    }
                }
            }

            // Commit the transaction if all operations are successful
            DB::commit();

            Alert::success('Berhasil', 'Proses data di cabang ' . $namaCabang . ' ' . $namaProyek . ' bulan ' . $bulan . ' tahun ' . $tahun . ' berhasil');
            return redirect()->route('prosesBulanan');
        } catch (\Exception $e) {
            DB::rollback();

            Alert::error('Gagal', 'Proses data bulanan gagal, silahkan ulangi kembali');
            return redirect()->route('prosesBulanan');
        }
        //die();
    }
}

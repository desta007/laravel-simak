<?php

namespace App\Http\Controllers;

use App\Exports\ExportLabaRugi;
use Illuminate\Http\Request;
use App\Exports\ExportNeraca;
use App\Models\Cabang;
use App\Models\GroupAccount;
use App\Models\KodePerkiraan;
use App\Models\Pejabat;
use App\Models\Proyek;
use App\Models\SaldoAkun;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ExportController extends Controller
{
    public function neracaExport(Request $request)
    {
        set_time_limit(300);
        $bulan = $request->input('bulan2');
        $tahun = $request->input('tahun2');

        $id_cabang = $request->input('id_cabang2');
        $id_proyek = $request->input('id_proyek2');

        $print = $request->input('print');
        $pdf = $request->input('pdf');
        $excel = $request->input('excel');

        if ($id_cabang != '') {
            $cabang = Cabang::where('id', $id_cabang)->first();
            $namaCabang = $cabang->nama;
        } else {
            $namaCabang = 'All';
        }

        if ($id_proyek != 0 && $id_proyek != 'all') {
            $proyek = Proyek::where('id', $id_proyek)->first();
            $namaProyek = $proyek->nama;
        } else {
            if ($id_proyek == 0)
                $namaProyek = 'Non Proyek';
            else
                $namaProyek = 'All';
        }

        $dataExcel[] = [
            'id_cabang' => $id_cabang
        ];
        // ----------- START PERHITUNGAN, NANTI DITAMPUNG DI ARRAY GLOBAL UTK VIEW DI LAYAR/PDF/EXCEL ------------------
        if ($id_cabang != '') {
            $dataExcel[] = [
                'A' => '', // Empty space for image
                'B' => '', // Empty space for image
                'C' => 'Laporan Neraca ' . date('F', mktime(0, 0, 0, $bulan, 1)) . ' ' . $tahun
            ];

            $dataExcel[] = [
                'A' => '',
                'B' => '',
                'C' => 'Cabang: ' . $namaCabang
            ];

            $dataExcel[] = [
                'A' => '',
                'B' => '',
                'C' => 'Proyek: ' . $namaProyek
            ];
        } else {
            $dataExcel[] = [
                'A' => '', // Empty space for image
                'B' => '', // Empty space for image
                'C' => '', // Empty space for image
                // 'D' => '', // Empty space for image
                'D' => 'Laporan Neraca ' . date('F', mktime(0, 0, 0, $bulan, 1)) . ' ' . $tahun
            ];

            $dataExcel[] = [
                'A' => '',
                'B' => '',
                'C' => '',
                // 'D' => '',
                'D' => 'Cabang: ' . $namaCabang
            ];

            $dataExcel[] = [
                'A' => '',
                'B' => '',
                'C' => '',
                // 'D' => '',
                'D' => 'Proyek: ' . $namaProyek
            ];
        }

        $dataExcel[] = [
            'Judul' => ''
        ];

        $dataExcel[] = [
            'Judul' => 'ASET'
        ];

        $dataExcel[] = [
            'Nomor' => 'I',
            'Judul' => 'ASET LANCAR'
        ];

        $jumlahAset = 0; // utk excel

        $listGroupAcc10x = GroupAccount::where('kode', 'like', '10%')->orderBy('kode', 'asc')->get();
        // $listData10x = [];
        $listData10x = array();
        // $jumlahSubtotal = 0; // utk excel
        $subtotal10x = 0;

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
            //$jumlahSubtotal += $jumlah; // utk excel
            $subtotal10x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc10x->kode,
                'Nama' => $groupAcc10x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $jumlahAset += $subtotal10x;
        // ------------------------------------------------------------------------

        // akun 11
        $listGroupAcc11x = GroupAccount::where('kode', 'like', '11%')->orderBy('kode', 'asc')->get();
        $listData11x = array();
        // $jumlahSubtotal = 0; // utk excel
        $subtotal11x = 0;

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

            // $jumlahSubtotal += $jumlah; // utk excel
            $subtotal11x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc11x->kode,
                'Nama' => $groupAcc11x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $jumlahAset += $subtotal11x; // sampe sini. nanti dilanjut ganti variabel jumlahSubtotal jadi masing2 group akun
        // ------------------------------------------------------------------------

        // akun 12
        $listGroupAcc12x = GroupAccount::where('kode', 'like', '12%')->orderBy('kode', 'asc')->get();
        $listData12x = array();
        $subtotal12x = 0;

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

            // $jumlahSubtotal += $jumlah; // utk excel
            $subtotal12x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc12x->kode,
                'Nama' => $groupAcc12x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $jumlahAset += $subtotal12x;
        // ---------------------------------------------------------------------------

        // akun 13
        $listGroupAcc13x = GroupAccount::where('kode', 'like', '13%')->orderBy('kode', 'asc')->get();
        $listData13x = array();
        $subtotal13x = 0; // utk excel

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

            $subtotal13x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc13x->kode,
                'Nama' => $groupAcc13x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $jumlahAset += $subtotal13x;
        // ---------------------------------------------------------------------------

        // akun 14
        $listGroupAcc14x = GroupAccount::where('kode', 'like', '14%')->orderBy('kode', 'asc')->get();
        $listData14x = array();
        $subtotal14x = 0; // utk excel

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

            $subtotal14x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc14x->kode,
                'Nama' => $groupAcc14x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $jumlahAset += $subtotal14x;
        // ---------------------------------------------------------------------------

        // akun 15
        $listGroupAcc15x = GroupAccount::where('kode', 'like', '15%')->orderBy('kode', 'asc')->get();
        $listData15x = array();
        $subtotal15x = 0; // utk excel

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

            $subtotal15x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc15x->kode,
                'Nama' => $groupAcc15x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $jumlahAset += $subtotal15x;
        // ---------------------------------------------------------------------------

        // akun 16
        $listGroupAcc16x = GroupAccount::where('kode', 'like', '16%')->orderBy('kode', 'asc')->get();
        $listData16x = array();
        $subtotal16x = 0; // utk excel

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

            $subtotal16x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc16x->kode,
                'Nama' => $groupAcc16x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $subtotal_aset_lancar =
            $subtotal10x +
            $subtotal11x +
            $subtotal12x +
            $subtotal13x +
            $subtotal14x +
            $subtotal15x +
            $subtotal16x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => 'JUMLAH ASET LANCAR',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($subtotal_aset_lancar)
        ];

        $jumlahAset += $subtotal16x;
        // ---------------------------------------------------------------------------

        $dataExcel[] = [
            'Nomor' => 'II',
            'Judul' => 'INVESTASI JANGKA PANJANG'
        ];

        // akun 17
        $listGroupAcc17x = GroupAccount::where('kode', 'like', '17%')->orderBy('kode', 'asc')->get();
        $listData17x = array();
        $subtotal17x = 0; // utk excel

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

            $subtotal17x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc17x->kode,
                'Nama' => $groupAcc17x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $subtotal_investasi_jangka_panjang = $subtotal17x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => 'JUMLAH INVESTASI JANGKA PANJANG',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($subtotal_investasi_jangka_panjang)
        ];

        $jumlahAset += $subtotal17x;
        // ---------------------------------------------------------------------------

        $dataExcel[] = [
            'Nomor' => 'III',
            'Judul' => 'ASET TETAP'
        ];

        // akun 18
        $listGroupAcc18x = GroupAccount::where('kode', 'like', '18%')->orderBy('kode', 'asc')->get();
        $listData18x = array();
        $subtotal18x = 0; // utk excel

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

            $subtotal18x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc18x->kode,
                'Nama' => $groupAcc18x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $subtotal_aset_tetap = $subtotal18x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => 'JUMLAH ASET TETAP',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($subtotal_aset_tetap)
        ];

        $jumlahAset += $subtotal18x;
        // ---------------------------------------------------------------------------

        $dataExcel[] = [
            'Nomor' => 'IV',
            'Judul' => 'HAK PENGELOLAAN'
        ];

        // akun 19
        $listGroupAcc19x = GroupAccount::where('kode', 'like', '19%')->orderBy('kode', 'asc')->get();
        $listData19x = array();
        $subtotal19x = 0; // utk excel

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

            $subtotal19x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc19x->kode,
                'Nama' => $groupAcc19x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $subtotal_hak_pengelolaan = $subtotal19x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => 'JUMLAH HAK PENGELOLAAN',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($subtotal_hak_pengelolaan)
        ];

        $jumlahAset += $subtotal19x;
        // ---------------------------------------------------------------------------
        $dataExcel[] = [
            'Nomor' => 'V',
            'Judul' => 'ASET TIDAK BERWUJUD'
        ];

        // akun 1A
        $listGroupAcc1Ax = GroupAccount::where('kode', 'like', '1A%')->orderBy('kode', 'asc')->get();
        $listData1Ax = array();
        $subtotal1Ax = 0; // utk excel

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

            $subtotal1Ax += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc1Ax->kode,
                'Nama' => $groupAcc1Ax->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $subtotal_aset_tidak_berwujud = $subtotal1Ax;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => 'JUMLAH ASET TIDAK BERWUJUD',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($subtotal_aset_tidak_berwujud)
        ];

        $jumlahAset += $subtotal1Ax;
        // ---------------------------------------------------------------------------
        $dataExcel[] = [
            'Nomor' => 'VI',
            'Judul' => 'ASET LAIN-LAIN'
        ];

        // akun 1B
        $listGroupAcc1Bx = GroupAccount::where('kode', 'like', '1B%')->orderBy('kode', 'asc')->get();
        $listData1Bx = array();
        $subtotal1Bx = 0; // utk excel

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

            $subtotal1Bx += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc1Bx->kode,
                'Nama' => $groupAcc1Bx->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $subtotal_aset_lain = $subtotal1Bx;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => 'JUMLAH ASET LAIN-LAIN',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($subtotal_aset_lain)
        ];

        $jumlahAset += $subtotal1Bx;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => 'JUMLAH ASET',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlahAset)
        ];
        // ---------------------------------------------------------------------------
        $dataExcel[] = [
            'Nomor' => ''
        ];

        // AKUN LIABILITAS & EKUITAS (20x, 21x, 22x, 23x, 24x, 25x, 26x, 27x, 28x, 30x, 31x, 32x)

        $dataExcel[] = [
            'Judul' => 'LIABILITAS & EKUITAS'
        ];

        $jumlahLiabilitas = 0;

        $dataExcel[] = [
            'Nomor' => 'I',
            'Judul' => 'LIABILITAS JANGKA PENDEK'
        ];

        // 20X
        $listGroupAcc20x = GroupAccount::where('kode', 'like', '20%')->orderBy('kode', 'asc')->get();
        $listData20x = array();
        $subtotal20x = 0; // utk excel

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

            $subtotal20x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc20x->kode,
                'Nama' => $groupAcc20x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $jumlahLiabilitas += $subtotal20x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];
        // ---------------------------------------------------------------------------

        // 21X
        $listGroupAcc21x = GroupAccount::where('kode', 'like', '21%')->orderBy('kode', 'asc')->get();
        $listData21x = array();
        $subtotal21x = 0; // utk excel

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

            $subtotal21x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc21x->kode,
                'Nama' => $groupAcc21x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $jumlahLiabilitas += $subtotal21x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];
        // ---------------------------------------------------------------------------

        // 22X
        $listGroupAcc22x = GroupAccount::where('kode', 'like', '22%')->orderBy('kode', 'asc')->get();
        $listData22x = array();
        $subtotal22x = 0; // utk excel

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

            $subtotal22x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc22x->kode,
                'Nama' => $groupAcc22x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $jumlahLiabilitas += $subtotal22x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];
        // ---------------------------------------------------------------------------

        // 23X
        $listGroupAcc23x = GroupAccount::where('kode', 'like', '23%')->orderBy('kode', 'asc')->get();
        $listData23x = array();
        $subtotal23x = 0; // utk excel

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

            $subtotal23x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc23x->kode,
                'Nama' => $groupAcc23x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $jumlahLiabilitas += $subtotal23x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];
        // ---------------------------------------------------------------------------

        // 24X
        $listGroupAcc24x = GroupAccount::where('kode', 'like', '24%')->orderBy('kode', 'asc')->get();
        $listData24x = array();
        $subtotal24x = 0; // utk excel

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

            $subtotal24x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc24x->kode,
                'Nama' => $groupAcc24x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $jumlahLiabilitas += $subtotal24x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $subtotal_liabilitas_jangka_pendek =
            $subtotal20x +
            $subtotal21x +
            $subtotal22x +
            $subtotal23x +
            $subtotal24x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => 'JUMLAH LIABILITAS JANGKA PENDEK',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($subtotal_liabilitas_jangka_pendek)
        ];
        // ---------------------------------------------------------------------------

        // 25X
        $listGroupAcc25x = GroupAccount::where('kode', 'like', '25%')->orderBy('kode', 'asc')->get();
        $listData25x = array();
        $subtotal25x = 0; // utk excel

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

            $subtotal25x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc25x->kode,
                'Nama' => $groupAcc25x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $jumlahLiabilitas += $subtotal25x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];
        // ---------------------------------------------------------------------------

        // 26X
        $listGroupAcc26x = GroupAccount::where('kode', 'like', '26%')->orderBy('kode', 'asc')->get();
        $listData26x = array();
        $subtotal26x = 0; // utk excel

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

            $subtotal26x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc26x->kode,
                'Nama' => $groupAcc26x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $jumlahLiabilitas += $subtotal26x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $subtotal_liabilitas_jangka_panjang = $subtotal25x + $subtotal26x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => 'JUMLAH LIABILITAS JANGKA PANJANG',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($subtotal_liabilitas_jangka_panjang)
        ];
        // ---------------------------------------------------------------------------

        // 27X
        $listGroupAcc27x = GroupAccount::where('kode', 'like', '27%')->orderBy('kode', 'asc')->get();
        $listData27x = array();
        $subtotal27x = 0; // utk excel

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

            $subtotal27x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc27x->kode,
                'Nama' => $groupAcc27x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $jumlahLiabilitas += $subtotal27x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];
        // ---------------------------------------------------------------------------

        // 28X
        $listGroupAcc28x = GroupAccount::where('kode', 'like', '28%')->orderBy('kode', 'asc')->get();
        $listData28x = array();
        $subtotal28x = 0; // utk excel

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

            $subtotal28x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc28x->kode,
                'Nama' => $groupAcc28x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $jumlahLiabilitas += $subtotal28x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $subtotal_liabilitas_lain = $subtotal27x + $subtotal28x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => 'JUMLAH LIABILITAS LAIN-LAIN ',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($subtotal_liabilitas_lain)
        ];
        // ---------------------------------------------------------------------------

        // 30X
        $listGroupAcc30x = GroupAccount::where('kode', 'like', '30%')->orderBy('kode', 'asc')->get();
        $listData30x = array();
        $subtotal30x = 0; // utk excel

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

            $subtotal30x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc30x->kode,
                'Nama' => $groupAcc30x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $jumlahLiabilitas += $subtotal30x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];
        // ---------------------------------------------------------------------------

        // 31X
        $listGroupAcc31x = GroupAccount::where('kode', 'like', '31%')->orderBy('kode', 'asc')->get();
        $listData31x = array();
        $subtotal31x = 0; // utk excel

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

            $subtotal31x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc31x->kode,
                'Nama' => $groupAcc31x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $jumlahLiabilitas += $subtotal31x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];
        // ---------------------------------------------------------------------------

        // 32X
        $listGroupAcc32x = GroupAccount::where('kode', 'like', '32%')->orderBy('kode', 'asc')->get();
        $listData32x = array();
        $subtotal32x = 0; // utk excel

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

            $subtotal32x += $jumlah; // utk excel

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc32x->kode,
                'Nama' => $groupAcc32x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $jumlahLiabilitas += $subtotal32x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $subtotal_ekuitas = $subtotal30x + $subtotal31x + $subtotal32x;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => 'JUMLAH EKUITAS',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($subtotal_ekuitas)
        ];

        $jumlah_liabilitas_ekuitas =
            $subtotal_liabilitas_jangka_pendek +
            $subtotal_liabilitas_jangka_panjang +
            $subtotal_liabilitas_lain +
            $subtotal_ekuitas;

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => 'JUMLAH LIABILITAS + EKUITAS',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah_liabilitas_ekuitas)
        ];

        if ($print != '') {
            // 02-11-2024 qrcode dari nama pejabat
            $pejabats = Pejabat::where('is_active', 1)->where('is_ttd_laporan_neraca', 1)
                ->orderBy('id', 'asc')->get();

            $listPejabat = [];
            if (!$pejabats->isEmpty()) {
                foreach ($pejabats as $pejabat) {
                    $qrCode = QrCode::size(100)->generate('Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')');
                    // $qrCode = base64_encode(QrCode::format('svg')->size(100)->generate('Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')'));

                    $listPejabat[] = array(
                        'nama' => $pejabat->nama,
                        'jabatan' => $pejabat->jabatan,
                        'qrCode' => $qrCode
                    );
                }
            }

            return view('report.neracaPrint', compact(
                'listPejabat',
                'bulan',
                'tahun',
                'namaCabang',
                'namaProyek',
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

        if ($excel != '') {
            return Excel::download(new ExportNeraca($dataExcel), 'laporan_neraca.xlsx');
        }
        // modif 17-10-2024 utk excel. dikomen lagi, msh error
        /*if ($excel != '') {
            $data = [
                'bulan' => $bulan,
                'tahun' => $tahun,
                'namaCabang' => $namaCabang,
                'namaProyek' => $namaProyek,
                'listData10x' => $listData10x,
                'listData11x' => $listData11x,
                'listData12x' => $listData12x,
                'listData13x' => $listData13x,
                'listData14x' => $listData14x,
                'listData15x' => $listData15x,
                'listData16x' => $listData16x,
                'listData17x' => $listData17x,
                'listData18x' => $listData18x,
                'listData19x' => $listData19x,
                'listData1Ax' => $listData1Ax,
                'listData1Bx' => $listData1Bx,

                'listData20x' => $listData20x,
                'listData21x' => $listData21x,
                'listData22x' => $listData22x,
                'listData23x' => $listData23x,
                'listData24x' => $listData24x,
                'listData25x' => $listData25x,
                'listData26x' => $listData26x,
                'listData27x' => $listData27x,
                'listData28x' => $listData28x,
                'listData30x' => $listData30x,
                'listData31x' => $listData31x,
                'listData32x' => $listData32x,
            ];

            // dd($data);

            return Excel::download(new ExportNeraca($data), 'neraca.xlsx');
        } */

        if ($pdf != '') {
            // $data = [
            //     'bulan' => $bulan,
            //     'tahun' => $tahun,
            //     'namaCabang' => $namaCabang,
            //     'namaProyek' => $namaProyek,
            //     'listData10x' => $listData10x,
            //     'listData11x' => $listData11x,
            //     'listData12x' => $listData12x,
            //     'listData13x' => $listData13x,
            //     'listData14x' => $listData14x,
            //     'listData15x' => $listData15x,
            //     'listData16x' => $listData16x,
            //     'listData17x' => $listData17x,
            //     'listData18x' => $listData18x,
            //     'listData19x' => $listData19x,
            //     'listData1Ax' => $listData1Ax,
            //     'listData1Bx' => $listData1Bx,

            //     'listData20x' => $listData20x,
            //     'listData21x' => $listData21x,
            //     'listData22x' => $listData22x,
            //     'listData23x' => $listData23x,
            //     'listData24x' => $listData24x,
            //     'listData25x' => $listData25x,
            //     'listData26x' => $listData26x,
            //     'listData27x' => $listData27x,
            //     'listData28x' => $listData28x,
            //     'listData30x' => $listData30x,
            //     'listData31x' => $listData31x,
            //     'listData32x' => $listData32x,
            // ];
            // $pdf = PDF::loadView('report.neracaPdf', $data);

            // 02-11-2024 qrcode dari nama pejabat
            $pejabats = Pejabat::where('is_active', 1)->where('is_ttd_laporan_neraca', 1)
                ->orderBy('id', 'asc')->get();

            $listPejabat = [];
            if (!$pejabats->isEmpty()) {
                foreach ($pejabats as $pejabat) {
                    // $qrCode = QrCode::size(100)->generate('Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')');
                    $qrCode = base64_encode(QrCode::format('svg')->size(100)->generate('Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')'));

                    $listPejabat[] = array(
                        'nama' => $pejabat->nama,
                        'jabatan' => $pejabat->jabatan,
                        'qrCode' => $qrCode
                    );
                }
            }
            $pdf = Pdf::loadView('report.neracaPdf', compact(
                'listPejabat',
                'bulan',
                'tahun',
                'id_cabang',
                'namaCabang',
                'namaProyek',
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
                'listData32x'
            ));
            return $pdf->download('laporan_neraca.pdf');
        }

        // ------------------------------------------------------------------------------------------------------
    }

    // LABA RUGI
    public function labaRugiExport(Request $request)
    {
        set_time_limit(300);
        $bulan1 = $request->input('bulan12');
        $bulan2 = $request->input('bulan22');
        $tahun = $request->input('tahun2');

        $id_cabang = $request->input('id_cabang2');
        $id_proyek = $request->input('id_proyek2');

        $print = $request->input('print');
        $pdf = $request->input('pdf');
        $excel = $request->input('excel');

        if ($id_cabang != '') {
            $cabang = Cabang::where('id', $id_cabang)->first();
            $namaCabang = $cabang->nama;
        } else {
            $namaCabang = 'All';
        }

        if ($id_proyek != 0 && $id_proyek != 'all') {
            $proyek = Proyek::where('id', $id_proyek)->first();
            $namaProyek = $proyek->nama;
        } else {
            if ($id_proyek == 0)
                $namaProyek = 'Non Proyek';
            else
                $namaProyek = 'All';
        }

        $dataExcel[] = [
            'id_cabang' => $id_cabang
        ];

        // ----------- START PERHITUNGAN, NANTI DITAMPUNG DI ARRAY GLOBAL UTK VIEW DI LAYAR/PDF/EXCEL ------------------

        if ($id_cabang != '') {
            $dataExcel[] = [
                'A' => '', // Empty space for image
                'B' => '', // Empty space for image
                'C' => 'Laporan Laba/Rugi ' . date('F', mktime(0, 0, 0, $bulan1, 1)) . ' s.d. ' . date('F', mktime(0, 0, 0, $bulan2, 1)) . ' ' . $tahun
            ];

            $dataExcel[] = [
                'A' => '',
                'B' => '',
                'C' => 'Cabang: ' . $namaCabang
            ];

            $dataExcel[] = [
                'A' => '',
                'B' => '',
                'C' => 'Proyek: ' . $namaProyek
            ];
        } else {
            $dataExcel[] = [
                'A' => '', // Empty space for image
                'B' => '', // Empty space for image
                'C' => '', // Empty space for image
                // 'D' => '', // Empty space for image
                'D' => 'Laporan Laba/Rugi ' . date('F', mktime(0, 0, 0, $bulan1, 1)) . ' s.d. ' . date('F', mktime(0, 0, 0, $bulan2, 1)) . ' ' . $tahun
            ];

            $dataExcel[] = [
                'A' => '',
                'B' => '',
                'C' => '',
                // 'D' => '',
                'D' => 'Cabang: ' . $namaCabang
            ];

            $dataExcel[] = [
                'A' => '',
                'B' => '',
                'C' => '',
                // 'D' => '',
                'D' => 'Proyek: ' . $namaProyek
            ];
        }

        // $dataExcel[] = [
        //     'Judul' => 'Laporan Laba/Rugi ' . date('F', mktime(0, 0, 0, $bulan1, 1)) . ' s.d. ' . date('F', mktime(0, 0, 0, $bulan2, 1)) . ' ' . $tahun
        // ];

        // $dataExcel[] = [
        //     'Judul' => 'Cabang: ' . $namaCabang
        // ];

        // $dataExcel[] = [
        //     'Judul' => 'Proyek: ' . $namaProyek
        // ];

        $dataExcel[] = [
            'Judul' => ''
        ];

        $dataExcel[] = [
            'Judul' => 'LAPORAN LABA/RUGI'
        ];

        $dataExcel[] = [
            'Nomor' => '1',
            'Judul' => 'HASIL PENJUALAN'
        ];

        $laba_rugi_penjualan = 0;

        // 1. HASIL PENJUALAN (40x)
        $listGroupAcc40x = GroupAccount::where('kode', 'like', '40%')->orderBy('kode', 'asc')->get();
        $listData40x = array();
        $subtotal40x = 0;

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

            $subtotal40x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc40x->kode,
                'Nama' => $groupAcc40x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $laba_rugi_penjualan += $subtotal40x;

        $dataExcel[] = [
            'Nomor' => '2',
            'Judul' => 'BIAYA PENJUALAN/PROYEK'
        ];
        // ------------------------------------------------------------------------

        // 2. BIAYA PENJUALAN/PROYEK (50X)
        $listGroupAcc50x = GroupAccount::where('kode', 'like', '50%')->orderBy('kode', 'asc')->get();
        $listData50x = array();
        $subtotal50x = 0;

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

            $subtotal50x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc50x->kode,
                'Nama' => $groupAcc50x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $laba_rugi_penjualan -= $subtotal50x;

        $dataExcel[] = [
            'Nomor' => '3',
            'Kode' => 'LABA (RUGI) PENJUALAN',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($laba_rugi_penjualan)
        ];

        $dataExcel[] = [
            'Nomor' => '',
            'Judul' => ''
        ];
        // ------------------------------------------------------------------------

        $laba_rugi_joint_operation = 0;

        $dataExcel[] = [
            'Nomor' => '4',
            'Judul' => 'HASIL JOINT OPERATION'
        ];

        // 4. HASIL JOINT OPERATION (41x)
        $listGroupAcc41x = GroupAccount::where('kode', 'like', '41%')->orderBy('kode', 'asc')->get();
        $listData41x = array();
        $subtotal41x = 0;

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

            $subtotal41x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc41x->kode,
                'Nama' => $groupAcc41x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $laba_rugi_joint_operation += $subtotal41x;
        // ------------------------------------------------------------------------

        $dataExcel[] = [
            'Nomor' => '5',
            'Judul' => 'BIAYA JOINT OPERATION'
        ];

        // 5. BIAYA JOINT OPERATION (51x)
        $listGroupAcc51x = GroupAccount::where('kode', 'like', '51%')->orderBy('kode', 'asc')->get();
        $listData51x = array();
        $subtotal51x = 0;

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

            $subtotal51x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc51x->kode,
                'Nama' => $groupAcc51x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $laba_rugi_joint_operation -= $subtotal51x;

        $dataExcel[] = [
            'Nomor' => '6',
            'Kode' => 'LABA (RUGI) JOINT OPERATION',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($laba_rugi_joint_operation)
        ];

        $dataExcel[] = [
            'Nomor' => '',
            'Judul' => ''
        ];

        $dataExcel[] = [
            'Nomor' => '7',
            'Judul' => 'HASIL PENJUALAN PROPERTY'
        ];
        // ------------------------------------------------------------------------

        // 7. HASIL PENJUALAN PROPERTY (42x)
        $listGroupAcc42x = GroupAccount::where('kode', 'like', '42%')->orderBy('kode', 'asc')->get();
        $listData42x = array();
        $subtotal42x = 0;

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

            $subtotal42x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc42x->kode,
                'Nama' => $groupAcc42x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $dataExcel[] = [
            'Nomor' => '8',
            'Judul' => 'HARGA POKOK PROPERTY'
        ];
        // ------------------------------------------------------------------------

        // 8. HARGA POKOK PROPERTY (52x)
        $listGroupAcc52x = GroupAccount::where('kode', 'like', '52%')->orderBy('kode', 'asc')->get();
        $listData52x = array();
        $subtotal52x = 0;
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

            $subtotal52x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc52x->kode,
                'Nama' => $groupAcc52x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $laba_rugi_property = $subtotal42x - $subtotal52x;

        $dataExcel[] = [
            'Nomor' => '9',
            'Kode' => 'LABA (RUGI) PROPERTY',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($laba_rugi_property)
        ];

        $dataExcel[] = [
            'Nomor' => '',
            'Judul' => ''
        ];

        $dataExcel[] = [
            'Nomor' => '10',
            'Judul' => 'HASIL PENJUALAN BRG/TRADING'
        ];
        // ------------------------------------------------------------------------

        // 10. HASIL PENJUALAN BRG/TRADING (43x)
        $listGroupAcc43x = GroupAccount::where('kode', 'like', '43%')->orderBy('kode', 'asc')->get();
        $listData43x = array();
        $subtotal43x = 0;
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

            $subtotal43x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc43x->kode,
                'Nama' => $groupAcc43x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $dataExcel[] = [
            'Nomor' => '11',
            'Judul' => 'HARGA POKOK BRG/TRADING'
        ];
        // ------------------------------------------------------------------------

        // 11. HARGA POKOK BRG/TRADING (53x)
        $listGroupAcc53x = GroupAccount::where('kode', 'like', '53%')->orderBy('kode', 'asc')->get();
        $listData53x = array();
        $subtotal53x = 0;
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

            $subtotal53x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc53x->kode,
                'Nama' => $groupAcc53x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $laba_rugi_trading = $subtotal43x - $subtotal53x;

        $dataExcel[] = [
            'Nomor' => '12',
            'Kode' => 'LABA (RUGI) TRADING',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($laba_rugi_trading)
        ];

        $dataExcel[] = [
            'Nomor' => '',
            'Judul' => ''
        ];

        $dataExcel[] = [
            'Nomor' => '13',
            'Judul' => 'HASIL SEWA PROPERTY/PERALATAN'
        ];
        // ------------------------------------------------------------------------

        // 13. HASIL SEWA PROPERTY/PERALATAN (44x)
        $listGroupAcc44x = GroupAccount::where('kode', 'like', '44%')->orderBy('kode', 'asc')->get();
        $listData44x = array();
        $subtotal44x = 0;
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

            $subtotal44x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc44x->kode,
                'Nama' => $groupAcc44x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $dataExcel[] = [
            'Nomor' => '14',
            'Judul' => 'BIAYA SEWA PROPERTY/PERALATAN'
        ];
        // ------------------------------------------------------------------------

        // 14. BIAYA SEWA PROPERTY/PERALATAN (54x)
        $listGroupAcc54x = GroupAccount::where('kode', 'like', '54%')->orderBy('kode', 'asc')->get();
        $listData54x = array();
        $subtotal54x = 0;
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

            $subtotal54x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc54x->kode,
                'Nama' => $groupAcc54x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $laba_rugi_sewa = $subtotal44x - $subtotal54x;

        $dataExcel[] = [
            'Nomor' => '15',
            'Kode' => 'LABA (RUGI) SEWA PROPERTY/PERALATAN',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($laba_rugi_sewa)
        ];

        $dataExcel[] = [
            'Nomor' => '',
            'Judul' => ''
        ];

        $laba_rugi_bruto =
            $laba_rugi_penjualan +
            $laba_rugi_joint_operation +
            $laba_rugi_property +
            $laba_rugi_trading +
            $laba_rugi_sewa;

        $dataExcel[] = [
            'Nomor' => '16',
            'Judul' => 'LABA (RUGI) USAHA BRUTO',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($laba_rugi_bruto)
        ];

        $dataExcel[] = [
            'Nomor' => '',
            'Judul' => ''
        ];

        $dataExcel[] = [
            'Nomor' => '17',
            'Judul' => 'BIAYA TIDAK LANGSUNG'
        ];
        // ------------------------------------------------------------------------

        // 17. BIAYA TIDAK LANGSUNG (60X)
        $listGroupAcc60x = GroupAccount::where('kode', 'like', '60%')->orderBy('kode', 'asc')->get();
        $listData60x = array();
        $subtotal60x = 0;
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

            $subtotal60x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc60x->kode,
                'Nama' => $groupAcc60x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $laba_rugi_bersih = $laba_rugi_bruto - $subtotal60x;

        $dataExcel[] = [
            'Nomor' => '18',
            'Judul' => 'LABA (RUGI) USAHA BERSIH',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($laba_rugi_bersih)
        ];

        $dataExcel[] = [
            'Nomor' => '',
            'Judul' => ''
        ];

        $dataExcel[] = [
            'Nomor' => '19',
            'Judul' => 'HASIL LAIN-LAIN'
        ];
        // ------------------------------------------------------------------------

        // 19. HASIL LAIN-LAIN (7xx)
        $listGroupAcc7xx = GroupAccount::where('kode', 'like', '7%')->orderBy('kode', 'asc')->get();
        $listData7xx = array();
        $subtotal7xx = 0;
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

            $subtotal7xx += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc7xx->kode,
                'Nama' => $groupAcc7xx->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $dataExcel[] = [
            'Nomor' => '20',
            'Judul' => 'BIAYA LAIN-LAIN'
        ];
        // ------------------------------------------------------------------------

        // 20. BIAYA LAIN-LAIN (80x)
        $listGroupAcc80x = GroupAccount::where('kode', 'like', '80%')->orderBy('kode', 'asc')->get();
        $listData80x = array();
        $subtotal80x = 0;
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

            $subtotal80x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc80x->kode,
                'Nama' => $groupAcc80x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $laba_rugi_lain = $subtotal7xx - $subtotal80x;

        $dataExcel[] = [
            'Nomor' => '21',
            'Judul' => 'LABA (RUGI) LAIN-LAIN',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($laba_rugi_lain)
        ];

        $dataExcel[] = [
            'Nomor' => '',
            'Judul' => ''
        ];

        $laba_rugi_sebelum_pph = $laba_rugi_bersih - $laba_rugi_lain;

        $dataExcel[] = [
            'Nomor' => '22',
            'Judul' => 'LABA (RUGI) KOMPREHENSIF SEBELUM PPH',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($laba_rugi_sebelum_pph)
        ];

        $dataExcel[] = [
            'Nomor' => '',
            'Judul' => ''
        ];

        $dataExcel[] = [
            'Nomor' => '23',
            'Judul' => 'PAJAK FINAL'
        ];
        // ------------------------------------------------------------------------

        // 23. PAJAK FINAL (83x)
        $listGroupAcc83x = GroupAccount::where('kode', 'like', '83%')->orderBy('kode', 'asc')->get();
        $listData83x = array();
        $subtotal83x = 0;
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

            $subtotal83x += $jumlah;

            $dataExcel[] = [
                'Nomor' => '',
                'Kode' => $groupAcc83x->kode,
                'Nama' => $groupAcc83x->nama,
                'Saldo' => number_format($jumlah)
            ];
        }

        $dataExcel[] = [
            'Nomor' => '',
            'Kode' => '',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($jumlah)
        ];

        $laba_rugi_setelah_pph = $laba_rugi_sebelum_pph - $subtotal83x;

        $dataExcel[] = [
            'Nomor' => '24',
            'Judul' => 'LABA (RUGI) KOMPREHENSIF SETELAH PPH',
            'Nama' => '',
            'Saldo' => '',
            'Subtotal' => number_format($laba_rugi_setelah_pph)
        ];

        if ($print != '') {
            // 02-11-2024 qrcode dari nama pejabat
            $pejabats = Pejabat::where('is_active', 1)->where('is_ttd_laporan_neraca', 1)
                ->orderBy('id', 'asc')->get();

            $listPejabat = [];
            if (!$pejabats->isEmpty()) {
                foreach ($pejabats as $pejabat) {
                    $qrCode = QrCode::size(100)->generate('Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')');
                    // $qrCode = base64_encode(QrCode::format('svg')->size(100)->generate('Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')'));

                    $listPejabat[] = array(
                        'nama' => $pejabat->nama,
                        'jabatan' => $pejabat->jabatan,
                        'qrCode' => $qrCode
                    );
                }
            }

            return view('report.labaRugiPrint', compact(
                'listPejabat',
                'bulan1',
                'bulan2',
                'tahun',
                'namaCabang',
                'namaProyek',
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

        if ($excel != '') {
            return Excel::download(new ExportLabaRugi($dataExcel), 'laporan_labarugi.xlsx');
            // return view('report.labaRugiExcel', compact(
            //     'bulan1',
            //     'bulan2',
            //     'tahun',
            //     'namaCabang',
            //     'namaProyek',
            //     'listData40x',
            //     'listData50x',
            //     'listData41x',
            //     'listData51x',
            //     'listData42x',
            //     'listData52x',
            //     'listData43x',
            //     'listData53x',
            //     'listData44x',
            //     'listData54x',
            //     'listData60x',
            //     'listData7xx',
            //     'listData80x',
            //     'listData83x',
            // ));
        }

        if ($pdf != '') {
            // 02-11-2024 qrcode dari nama pejabat
            $pejabats = Pejabat::where('is_active', 1)->where('is_ttd_laporan_neraca', 1)
                ->orderBy('id', 'asc')->get();

            $listPejabat = [];
            if (!$pejabats->isEmpty()) {
                foreach ($pejabats as $pejabat) {
                    // $qrCode = QrCode::size(100)->generate('Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')');
                    $qrCode = base64_encode(QrCode::format('svg')->size(100)->generate('Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')'));

                    $listPejabat[] = array(
                        'nama' => $pejabat->nama,
                        'jabatan' => $pejabat->jabatan,
                        'qrCode' => $qrCode
                    );
                }
            }

            $pdf = Pdf::loadView('report.labaRugiPdf', compact(
                'listPejabat',
                'bulan1',
                'bulan2',
                'tahun',
                'id_cabang',
                'namaCabang',
                'namaProyek',
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
            return $pdf->download('laporan_laba_rugi.pdf');
        }

        // ------------------------------------------------------------------------------------------------------
    }

    // 05-11-2024
    public function generalLedgerExport(Request $request)
    {
        set_time_limit(300);
        $bulan1 = $request->input('bulan12');
        $bulan2 = $request->input('bulan22');
        $tahun = $request->input('tahun2');

        $id_cabang = $request->input('id_cabang2');
        $id_proyek = $request->input('id_proyek2');
        $kodePerkiraan = $request->input('kodePerkiraan2');

        $print = $request->input('print');
        $pdf = $request->input('pdf');
        $excel = $request->input('excel');

        if ($id_cabang != '') {
            $cabang = Cabang::where('id', $id_cabang)->first();
            $namaCabang = $cabang->nama;
        } else {
            $namaCabang = 'All';
        }

        if ($id_proyek != 0 && $id_proyek != 'all') {
            $proyek = Proyek::where('id', $id_proyek)->first();
            $namaProyek = $proyek->nama;
        } else {
            if ($id_proyek == 0)
                $namaProyek = 'Non Proyek';
            else
                $namaProyek = 'All';
        }

        // get data kode perkiraan dan saldo
        $listAkun = KodePerkiraan::query();
        if ($id_cabang != '')
            $listAkun->where('id_cabang', $id_cabang);
        if ($id_proyek != 'all')
            $listAkun->where('id_proyek', $id_proyek);
        $listAkun->where('kode', 'like', $kodePerkiraan . '%')
            ->orderBy('kode', 'asc');
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

            if ($jumlahSaldoAwal != 0 || $jumlahSaldoMutasiDebet != 0 || $jumlahSaldoMutasiKredit != 0 || $jumlahSaldoAkhir != 0) {
                $listData[] = array(
                    'kode' => $akun->kode,
                    'nama' => $akun->nama,
                    'saldo_awal' => $jumlahSaldoAwal,
                    'mutasi_debet' => $jumlahSaldoMutasiDebet,
                    'mutasi_kredit' => $jumlahSaldoMutasiKredit,
                    'saldo_akhir' => $jumlahSaldoAkhir
                );
            }
        }

        // 15-11-2024
        if ($print != '') {
            // 02-11-2024 qrcode dari nama pejabat
            $pejabats = Pejabat::where('is_active', 1)->where('is_ttd_laporan_neraca', 1)
                ->orderBy('id', 'asc')->get();

            $listPejabat = [];
            if (!$pejabats->isEmpty()) {
                foreach ($pejabats as $pejabat) {
                    $qrCode = QrCode::size(100)->generate('Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')');
                    // $qrCode = base64_encode(QrCode::format('svg')->size(100)->generate('Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')'));

                    $listPejabat[] = array(
                        'nama' => $pejabat->nama,
                        'jabatan' => $pejabat->jabatan,
                        'qrCode' => $qrCode
                    );
                }
            }

            return view('report.generalLedgerPrint', compact(
                'listPejabat',
                'bulan1',
                'bulan2',
                'tahun',
                'namaCabang',
                'namaProyek',
                'listData'
            ));
        }

        if ($pdf != '') {

            // qrcode dari nama pejabat
            $pejabats = Pejabat::where('is_active', 1)->where('is_ttd_laporan_neraca', 1)
                ->orderBy('id', 'asc')->get();

            $listPejabat = [];
            if (!$pejabats->isEmpty()) {
                foreach ($pejabats as $pejabat) {
                    // $qrCode = QrCode::size(100)->generate('Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')');
                    $qrCode = base64_encode(QrCode::format('svg')->size(100)->generate('Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')'));

                    $listPejabat[] = array(
                        'nama' => $pejabat->nama,
                        'jabatan' => $pejabat->jabatan,
                        'qrCode' => $qrCode
                    );
                }
            }
            $pdf = Pdf::loadView('report.generalLedgerPdf', compact(
                'listPejabat',
                'bulan1',
                'bulan2',
                'tahun',
                'id_cabang',
                'namaCabang',
                'namaProyek',
                'listData'
            ));
            return $pdf->download('general_ledger.pdf');
        }
    }
}

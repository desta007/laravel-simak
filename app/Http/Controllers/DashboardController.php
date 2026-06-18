<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\GroupAccount;
use App\Models\KodePerkiraan;
use App\Models\Proyek;
use App\Models\SaldoAkun;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $id_group_user = $user->id_group_user;
        $id_cabang = $user->id_cabang;
        $id_user = $user->id;

        $tahun = Carbon::now()->year;
        $bulan = Carbon::now()->month;

        // Get dropdown data based on role
        if ($id_group_user == 1) {
            // Admin
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();
            $id_proyek = 'all';
        } else if ($id_group_user == 2) {
            // Cabang
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
            $id_proyek = 'all';
        } else {
            // Proyek
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->get();

            $proyek_first = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->first();

            $id_proyek = $proyek_first ? $proyek_first->id : '';
        }

        // Get available years from saldo_akuns
        $tahunList = SaldoAkun::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        if ($tahunList->isEmpty()) {
            $tahunList = collect([$tahun]);
        }

        return view('dashboard', compact(
            'id_group_user',
            'id_cabang',
            'id_proyek',
            'cabangs',
            'proyeks',
            'tahun',
            'bulan',
            'tahunList'
        ));
    }

    public function getData(Request $request)
    {
        $user = auth()->user();
        $id_group_user = $user->id_group_user;

        $tahun = $request->input('tahun', Carbon::now()->year);
        $bulan = $request->input('bulan', Carbon::now()->month);
        $id_cabang = $request->input('id_cabang', '');
        $id_proyek = $request->input('id_proyek', 'all');

        // Enforce role-based access
        if ($id_group_user == 2) {
            $id_cabang = $user->id_cabang;
        } else if ($id_group_user == 3) {
            $id_cabang = $user->id_cabang;
            // Validate proyek belongs to user
            $userProyeks = DB::table('user_proyeks')
                ->where('id_user', $user->id)
                ->pluck('id_proyek')->toArray();
            if ($id_proyek != 'all' && !in_array($id_proyek, $userProyeks)) {
                $id_proyek = !empty($userProyeks) ? $userProyeks[0] : '';
            }
        }

        $summary = $this->getSummary($tahun, $bulan, $id_cabang, $id_proyek);
        $chartBulanan = $this->getChartBulanan($tahun, $id_cabang, $id_proyek);
        $chartKomposisi = $this->getChartKomposisiAset($tahun, $bulan, $id_cabang, $id_proyek);
        $tabelProyek = $this->getTabelProyek($tahun, $bulan, $id_cabang, $id_proyek, $id_group_user);
        $transaksiTerbaru = $this->getTransaksiTerbaru($id_cabang, $id_proyek);

        return response()->json([
            'summary' => $summary,
            'chartBulanan' => $chartBulanan,
            'chartKomposisi' => $chartKomposisi,
            'tabelProyek' => $tabelProyek,
            'transaksiTerbaru' => $transaksiTerbaru,
        ]);
    }

    /**
     * Calculate total saldo for a group of accounts up to given month
     * Following the same logic as ReportController::neracaSearch
     */
    private function hitungSaldoGroup($kodePrefix, $tahun, $bulan, $id_cabang, $id_proyek, $isDebitNormal = true)
    {
        $groupAccounts = GroupAccount::where('kode', 'like', $kodePrefix . '%')
            ->orderBy('kode', 'asc')->get();

        $total = 0;

        foreach ($groupAccounts as $groupAcc) {
            // Saldo awal tahun
            $query = SaldoAkun::with('kodePerkiraan')
                ->where('tahun', $tahun)
                ->where('is_saldo_awal', 1)
                ->whereHas('kodePerkiraan', function ($q) use ($groupAcc, $id_cabang, $id_proyek) {
                    $q->where('kode', 'like', $groupAcc->kode . '%');
                    if ($id_cabang != '')
                        $q->where('id_cabang', $id_cabang);
                    if ($id_proyek != 'all')
                        $q->where('id_proyek', $id_proyek);
                });

            $saldoAwalList = $query->get();
            $jumlah = 0;
            foreach ($saldoAwalList as $sa) {
                if ($isDebitNormal) {
                    $jumlah += $sa->saldo_debet - $sa->saldo_kredit;
                } else {
                    $jumlah += $sa->saldo_kredit - $sa->saldo_debet;
                }
            }

            // Saldo bulanan
            for ($i = 1; $i <= $bulan; $i++) {
                $saldoBulanList = SaldoAkun::with('kodePerkiraan')
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->where('is_saldo_awal', 0)
                    ->whereHas('kodePerkiraan', function ($q) use ($groupAcc, $id_cabang, $id_proyek) {
                        $q->where('kode', 'like', $groupAcc->kode . '%');
                        if ($id_cabang != '')
                            $q->where('id_cabang', $id_cabang);
                        if ($id_proyek != 'all')
                            $q->where('id_proyek', $id_proyek);
                    })->get();

                foreach ($saldoBulanList as $sb) {
                    if ($isDebitNormal) {
                        $jumlah += $sb->saldo_debet - $sb->saldo_kredit;
                    } else {
                        $jumlah += $sb->saldo_kredit - $sb->saldo_debet;
                    }
                }
            }

            $total += $jumlah;
        }

        return $total;
    }

    private function getSummary($tahun, $bulan, $id_cabang, $id_proyek)
    {
        // Aset (kode 1x) - debit normal
        $totalAset = 0;
        foreach (['10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '1A', '1B'] as $prefix) {
            $totalAset += $this->hitungSaldoGroup($prefix, $tahun, $bulan, $id_cabang, $id_proyek, true);
        }

        // Kewajiban (kode 2x) - kredit normal
        $totalKewajiban = 0;
        foreach (['20', '21', '22', '23', '24', '25', '26', '27', '28'] as $prefix) {
            $totalKewajiban += $this->hitungSaldoGroup($prefix, $tahun, $bulan, $id_cabang, $id_proyek, false);
        }

        // Ekuitas (kode 3x) - kredit normal
        $totalEkuitas = 0;
        foreach (['30', '31', '32'] as $prefix) {
            $totalEkuitas += $this->hitungSaldoGroup($prefix, $tahun, $bulan, $id_cabang, $id_proyek, false);
        }

        // Pendapatan (kode 4x) - kredit normal
        $totalPendapatan = 0;
        foreach (['40', '41', '42', '43', '44', '45', '46', '47', '48', '49'] as $prefix) {
            $totalPendapatan += $this->hitungSaldoGroup($prefix, $tahun, $bulan, $id_cabang, $id_proyek, false);
        }

        // Beban (kode 5x, 6x) - debit normal
        $totalBeban = 0;
        foreach (['50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69'] as $prefix) {
            $totalBeban += $this->hitungSaldoGroup($prefix, $tahun, $bulan, $id_cabang, $id_proyek, true);
        }

        // Pendapatan/Beban Lainnya (kode 7x, 8x, 9x)
        $totalPendapatanLain = 0;
        foreach (['70', '71', '72', '73', '74', '75', '76', '77', '78', '79'] as $prefix) {
            $totalPendapatanLain += $this->hitungSaldoGroup($prefix, $tahun, $bulan, $id_cabang, $id_proyek, false);
        }
        $totalBebanLain = 0;
        foreach (['80', '81', '82', '83', '84', '85', '86', '87', '88', '89'] as $prefix) {
            $totalBebanLain += $this->hitungSaldoGroup($prefix, $tahun, $bulan, $id_cabang, $id_proyek, true);
        }

        $labaRugi = $totalPendapatan + $totalPendapatanLain - $totalBeban - $totalBebanLain;

        return [
            'totalAset' => $totalAset,
            'totalKewajiban' => $totalKewajiban,
            'totalEkuitas' => $totalEkuitas,
            'totalPendapatan' => $totalPendapatan + $totalPendapatanLain,
            'totalBeban' => $totalBeban + $totalBebanLain,
            'labaRugi' => $labaRugi,
        ];
    }

    private function getChartBulanan($tahun, $id_cabang, $id_proyek)
    {
        $pendapatanPerBulan = [];
        $bebanPerBulan = [];

        for ($bln = 1; $bln <= 12; $bln++) {
            // Pendapatan bulan ini saja (bukan kumulatif)
            $pendapatan = 0;
            foreach (['40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '70', '71', '72', '73', '74', '75', '76', '77', '78', '79'] as $prefix) {
                $groupAccounts = GroupAccount::where('kode', 'like', $prefix . '%')->get();
                foreach ($groupAccounts as $ga) {
                    $saldoList = SaldoAkun::where('tahun', $tahun)
                        ->where('bulan', $bln)
                        ->where('is_saldo_awal', 0)
                        ->whereHas('kodePerkiraan', function ($q) use ($ga, $id_cabang, $id_proyek) {
                            $q->where('kode', 'like', $ga->kode . '%');
                            if ($id_cabang != '') $q->where('id_cabang', $id_cabang);
                            if ($id_proyek != 'all') $q->where('id_proyek', $id_proyek);
                        })->get();
                    foreach ($saldoList as $s) {
                        $pendapatan += $s->saldo_kredit - $s->saldo_debet;
                    }
                }
            }

            // Beban bulan ini saja
            $beban = 0;
            foreach (['50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '80', '81', '82', '83', '84', '85', '86', '87', '88', '89'] as $prefix) {
                $groupAccounts = GroupAccount::where('kode', 'like', $prefix . '%')->get();
                foreach ($groupAccounts as $ga) {
                    $saldoList = SaldoAkun::where('tahun', $tahun)
                        ->where('bulan', $bln)
                        ->where('is_saldo_awal', 0)
                        ->whereHas('kodePerkiraan', function ($q) use ($ga, $id_cabang, $id_proyek) {
                            $q->where('kode', 'like', $ga->kode . '%');
                            if ($id_cabang != '') $q->where('id_cabang', $id_cabang);
                            if ($id_proyek != 'all') $q->where('id_proyek', $id_proyek);
                        })->get();
                    foreach ($saldoList as $s) {
                        $beban += $s->saldo_debet - $s->saldo_kredit;
                    }
                }
            }

            $pendapatanPerBulan[] = $pendapatan;
            $bebanPerBulan[] = $beban;
        }

        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'pendapatan' => $pendapatanPerBulan,
            'beban' => $bebanPerBulan,
        ];
    }

    private function getChartKomposisiAset($tahun, $bulan, $id_cabang, $id_proyek)
    {
        $labels = [];
        $data = [];

        $kategori = [
            '10' => 'Aset Lancar',
            '11' => 'Piutang',
            '12' => 'Persediaan',
            '17' => 'Investasi Jk. Panjang',
            '18' => 'Aset Tetap',
            '19' => 'Hak Pengelolaan',
            '1A' => 'Aset Tak Berwujud',
            '1B' => 'Aset Lain-lain',
        ];

        foreach ($kategori as $prefix => $label) {
            $nilai = $this->hitungSaldoGroup($prefix, $tahun, $bulan, $id_cabang, $id_proyek, true);
            if ($nilai != 0) {
                $labels[] = $label;
                $data[] = abs($nilai);
            }
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    private function getTabelProyek($tahun, $bulan, $id_cabang, $id_proyek, $id_group_user)
    {
        // Only for Admin and Cabang roles
        if ($id_group_user == 3) {
            return [];
        }

        $query = Proyek::query();
        if ($id_cabang != '') {
            $query->where('id_cabang', $id_cabang);
        }
        if ($id_proyek != 'all') {
            $query->where('id', $id_proyek);
        }
        $proyeks = $query->with('cabang')->get();

        $result = [];
        foreach ($proyeks as $proyek) {
            $cabangId = $proyek->id_cabang;
            $proyekId = $proyek->id;

            // Simplified: calculate per-proyek totals
            $aset = 0;
            foreach (['10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '1A', '1B'] as $prefix) {
                $aset += $this->hitungSaldoGroup($prefix, $tahun, $bulan, $cabangId, $proyekId, true);
            }

            $kewajiban = 0;
            foreach (['20', '21', '22', '23', '24', '25', '26', '27', '28'] as $prefix) {
                $kewajiban += $this->hitungSaldoGroup($prefix, $tahun, $bulan, $cabangId, $proyekId, false);
            }

            $ekuitas = 0;
            foreach (['30', '31', '32'] as $prefix) {
                $ekuitas += $this->hitungSaldoGroup($prefix, $tahun, $bulan, $cabangId, $proyekId, false);
            }

            $pendapatan = 0;
            foreach (['40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '70', '71', '72', '73', '74', '75', '76', '77', '78', '79'] as $prefix) {
                $pendapatan += $this->hitungSaldoGroup($prefix, $tahun, $bulan, $cabangId, $proyekId, false);
            }

            $beban = 0;
            foreach (['50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '80', '81', '82', '83', '84', '85', '86', '87', '88', '89'] as $prefix) {
                $beban += $this->hitungSaldoGroup($prefix, $tahun, $bulan, $cabangId, $proyekId, true);
            }

            $labaRugi = $pendapatan - $beban;

            // Only include proyek yang punya data
            if ($aset != 0 || $kewajiban != 0 || $ekuitas != 0 || $labaRugi != 0) {
                $result[] = [
                    'nama_proyek' => $proyek->nama,
                    'nama_cabang' => $proyek->cabang ? $proyek->cabang->nama : '-',
                    'aset' => $aset,
                    'kewajiban' => $kewajiban,
                    'ekuitas' => $ekuitas,
                    'labaRugi' => $labaRugi,
                ];
            }
        }

        return $result;
    }

    private function getTransaksiTerbaru($id_cabang, $id_proyek)
    {
        $query = Transaksi::with(['cabang', 'proyek', 'kodebukti', 'transaksiDetail'])
            ->orderBy('tgl', 'desc')
            ->orderBy('id', 'desc');

        if ($id_cabang != '') {
            $query->where('id_cabang', $id_cabang);
        }
        if ($id_proyek != 'all') {
            $query->where('id_proyek', $id_proyek);
        }

        $transaksis = $query->limit(10)->get();

        $result = [];
        foreach ($transaksis as $trx) {
            $totalDebet = 0;
            $totalKredit = 0;
            foreach ($trx->transaksiDetail as $detail) {
                if ($detail->jenis == 'D') {
                    $totalDebet += $detail->jumlah;
                } else {
                    $totalKredit += $detail->jumlah;
                }
            }

            $result[] = [
                'tgl' => Carbon::parse($trx->tgl)->format('d/m/Y'),
                'no_bukti' => $trx->no_bukti,
                'keterangan' => $trx->keterangan,
                'debet' => $totalDebet,
                'kredit' => $totalKredit,
            ];
        }

        return $result;
    }
}

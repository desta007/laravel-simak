<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Proyek;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $id_group_user = $user->id_group_user;
        $id_cabang_user = $user->id_cabang;
        $tahun = $request->input('tahun', Carbon::now()->year);
        $filterCabang = $request->input('id_cabang', '');
        $filterProyek = $request->input('id_proyek', 'all');

        // Accessible cabang/proyek based on role
        if ($id_group_user == 1) {
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();
        } elseif ($id_group_user == 2) {
            $cabangs = Cabang::where('id', $id_cabang_user)->get();
            $proyeks = Proyek::where('id_cabang', $id_cabang_user)->get();
            $filterCabang = $id_cabang_user;
        } else {
            $cabangs = Cabang::where('id', $id_cabang_user)->get();
            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $user->id)->get();
            $filterCabang = $id_cabang_user;
        }

        $userProyekIds = null;
        if ($id_group_user == 3) {
            $userProyekIds = DB::table('user_proyeks')->where('id_user', $user->id)->pluck('id_proyek');
        }

        // === STAT CARDS ===

        // 1. Total Proyek
        $proyekQuery = Proyek::query()
            ->when($filterCabang, fn($q) => $q->where('id_cabang', $filterCabang))
            ->when($userProyekIds, fn($q) => $q->whereIn('id', $userProyekIds));
        $totalProyek = $proyekQuery->count();
        $totalCabang = ($id_group_user == 1) ? Cabang::count() : 1;

        // 2. Total Transaksi & Nilai
        $trxSummary = DB::table('transaksis')
            ->join('transaksi_details', 'transaksis.id', '=', 'transaksi_details.id_transaksi')
            ->whereYear('transaksis.tgl', $tahun)
            ->when($filterCabang, fn($q) => $q->where('transaksis.id_cabang', $filterCabang))
            ->when($filterProyek != 'all', fn($q) => $q->where('transaksis.id_proyek', $filterProyek))
            ->when($userProyekIds, fn($q) => $q->whereIn('transaksis.id_proyek', $userProyekIds))
            ->selectRaw("
                COUNT(DISTINCT transaksis.id) as total_transaksi,
                SUM(CASE WHEN transaksi_details.jenis = 'D' THEN transaksi_details.jumlah ELSE 0 END) as total_debet,
                SUM(CASE WHEN transaksi_details.jenis = 'K' THEN transaksi_details.jumlah ELSE 0 END) as total_kredit
            ")
            ->first();

        $totalTransaksi = $trxSummary->total_transaksi ?? 0;
        $totalDebet = $trxSummary->total_debet ?? 0;
        $totalKredit = $trxSummary->total_kredit ?? 0;

        // 3. Pendapatan & Beban (from saldo_akuns)
        $saldoBaseQuery = fn() => DB::table('saldo_akuns')
            ->join('kode_perkiraans', 'saldo_akuns.id_kode_perkiraan', '=', 'kode_perkiraans.id')
            ->where('saldo_akuns.tahun', $tahun)
            ->where('saldo_akuns.is_saldo_awal', 0)
            ->when($filterCabang, fn($q) => $q->where('kode_perkiraans.id_cabang', $filterCabang))
            ->when($filterProyek != 'all', fn($q) => $q->where('kode_perkiraans.id_proyek', $filterProyek))
            ->when($userProyekIds, fn($q) => $q->whereIn('kode_perkiraans.id_proyek', $userProyekIds));

        $pendapatan = $saldoBaseQuery()
            ->where(function ($q) {
                $q->where('kode_perkiraans.kode', 'like', '4%')
                    ->orWhere('kode_perkiraans.kode', 'like', '7%');
            })
            ->selectRaw('COALESCE(SUM(saldo_akuns.saldo_kredit) - SUM(saldo_akuns.saldo_debet), 0) as total')
            ->value('total') ?? 0;

        $beban = $saldoBaseQuery()
            ->where(function ($q) {
                $q->where('kode_perkiraans.kode', 'like', '5%')
                    ->orWhere('kode_perkiraans.kode', 'like', '6%')
                    ->orWhere('kode_perkiraans.kode', 'like', '8%');
            })
            ->selectRaw('COALESCE(SUM(saldo_akuns.saldo_debet) - SUM(saldo_akuns.saldo_kredit), 0) as total')
            ->value('total') ?? 0;

        $labaRugi = $pendapatan - $beban;

        // 4. Cash Position (accounts 1xx = Kas & Bank)
        $cashPosition = $saldoBaseQuery()
            ->where('kode_perkiraans.kode', 'like', '1%')
            ->selectRaw("
                COALESCE(SUM(saldo_akuns.saldo_debet), 0) as cash_in,
                COALESCE(SUM(saldo_akuns.saldo_kredit), 0) as cash_out
            ")
            ->first();

        $cashIn = $cashPosition->cash_in ?? 0;
        $cashOut = $cashPosition->cash_out ?? 0;
        $netCashFlow = $cashIn - $cashOut;

        // === CHARTS ===

        // Chart 1: Nilai Transaksi per Proyek (Top 10)
        $trxPerProyek = DB::table('transaksis')
            ->join('transaksi_details', 'transaksis.id', '=', 'transaksi_details.id_transaksi')
            ->join('proyeks', 'transaksis.id_proyek', '=', 'proyeks.id')
            ->whereYear('transaksis.tgl', $tahun)
            ->when($filterCabang, fn($q) => $q->where('transaksis.id_cabang', $filterCabang))
            ->when($filterProyek != 'all', fn($q) => $q->where('transaksis.id_proyek', $filterProyek))
            ->when($userProyekIds, fn($q) => $q->whereIn('transaksis.id_proyek', $userProyekIds))
            ->selectRaw("
                proyeks.nama as proyek_nama,
                SUM(CASE WHEN transaksi_details.jenis = 'D' THEN transaksi_details.jumlah ELSE 0 END) as total_debet,
                SUM(CASE WHEN transaksi_details.jenis = 'K' THEN transaksi_details.jumlah ELSE 0 END) as total_kredit
            ")
            ->groupBy('proyeks.nama')
            ->orderByRaw("SUM(transaksi_details.jumlah) DESC")
            ->limit(10)
            ->get();

        // Chart 2: Komposisi Proyek per Cabang
        $proyekPerCabang = DB::table('proyeks')
            ->join('cabangs', 'proyeks.id_cabang', '=', 'cabangs.id')
            ->when($filterCabang, fn($q) => $q->where('proyeks.id_cabang', $filterCabang))
            ->when($userProyekIds, fn($q) => $q->whereIn('proyeks.id', $userProyekIds))
            ->selectRaw('cabangs.nama as cabang_nama, COUNT(proyeks.id) as jumlah')
            ->groupBy('cabangs.nama')
            ->orderByDesc('jumlah')
            ->get();

        // Chart 3: Tren Transaksi Bulanan
        $monthlyData = DB::table('transaksis')
            ->join('transaksi_details', 'transaksis.id', '=', 'transaksi_details.id_transaksi')
            ->whereYear('transaksis.tgl', $tahun)
            ->when($filterCabang, fn($q) => $q->where('transaksis.id_cabang', $filterCabang))
            ->when($filterProyek != 'all', fn($q) => $q->where('transaksis.id_proyek', $filterProyek))
            ->when($userProyekIds, fn($q) => $q->whereIn('transaksis.id_proyek', $userProyekIds))
            ->selectRaw("
                MONTH(transaksis.tgl) as bulan,
                SUM(CASE WHEN transaksi_details.jenis = 'D' THEN transaksi_details.jumlah ELSE 0 END) as total_debet,
                SUM(CASE WHEN transaksi_details.jenis = 'K' THEN transaksi_details.jumlah ELSE 0 END) as total_kredit
            ")
            ->groupBy(DB::raw('MONTH(transaksis.tgl)'))
            ->orderBy('bulan')
            ->get();

        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartDebet = array_fill(0, 12, 0);
        $chartKredit = array_fill(0, 12, 0);

        foreach ($monthlyData as $data) {
            $idx = (int) $data->bulan - 1;
            $chartDebet[$idx] = (float) $data->total_debet;
            $chartKredit[$idx] = (float) $data->total_kredit;
        }

        // Chart 4: Debet vs Kredit per Cabang
        $debetKreditPerCabang = DB::table('transaksis')
            ->join('transaksi_details', 'transaksis.id', '=', 'transaksi_details.id_transaksi')
            ->join('cabangs', 'transaksis.id_cabang', '=', 'cabangs.id')
            ->whereYear('transaksis.tgl', $tahun)
            ->when($filterCabang, fn($q) => $q->where('transaksis.id_cabang', $filterCabang))
            ->when($userProyekIds, fn($q) => $q->whereIn('transaksis.id_proyek', $userProyekIds))
            ->selectRaw("
                cabangs.nama as cabang_nama,
                SUM(CASE WHEN transaksi_details.jenis = 'D' THEN transaksi_details.jumlah ELSE 0 END) as total_debet,
                SUM(CASE WHEN transaksi_details.jenis = 'K' THEN transaksi_details.jumlah ELSE 0 END) as total_kredit
            ")
            ->groupBy('cabangs.nama')
            ->get();

        // === TABLE: Daftar Proyek ===
        $daftarProyek = DB::table('proyeks')
            ->join('cabangs', 'proyeks.id_cabang', '=', 'cabangs.id')
            ->leftJoin('transaksis', function ($join) use ($tahun) {
                $join->on('proyeks.id', '=', 'transaksis.id_proyek')
                    ->whereYear('transaksis.tgl', $tahun);
            })
            ->leftJoin('transaksi_details', 'transaksis.id', '=', 'transaksi_details.id_transaksi')
            ->when($filterCabang, fn($q) => $q->where('proyeks.id_cabang', $filterCabang))
            ->when($filterProyek != 'all', fn($q) => $q->where('proyeks.id', $filterProyek))
            ->when($userProyekIds, fn($q) => $q->whereIn('proyeks.id', $userProyekIds))
            ->selectRaw("
                proyeks.id,
                proyeks.nama as proyek_nama,
                proyeks.nomor_wo,
                cabangs.nama as cabang_nama,
                COUNT(DISTINCT transaksis.id) as jml_transaksi,
                COALESCE(SUM(CASE WHEN transaksi_details.jenis = 'D' THEN transaksi_details.jumlah ELSE 0 END), 0) as total_debet,
                COALESCE(SUM(CASE WHEN transaksi_details.jenis = 'K' THEN transaksi_details.jumlah ELSE 0 END), 0) as total_kredit
            ")
            ->groupBy('proyeks.id', 'proyeks.nama', 'proyeks.nomor_wo', 'cabangs.nama')
            ->orderByDesc('total_debet')
            ->get();

        return view('dashboard', compact(
            'totalProyek',
            'totalCabang',
            'totalTransaksi',
            'totalDebet',
            'totalKredit',
            'pendapatan',
            'beban',
            'labaRugi',
            'cashIn',
            'cashOut',
            'netCashFlow',
            'trxPerProyek',
            'proyekPerCabang',
            'chartLabels',
            'chartDebet',
            'chartKredit',
            'debetKreditPerCabang',
            'daftarProyek',
            'cabangs',
            'proyeks',
            'tahun',
            'filterCabang',
            'filterProyek',
            'id_group_user'
        ));
    }
}

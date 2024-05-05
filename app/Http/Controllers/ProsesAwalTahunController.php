<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\KodePerkiraan;
use App\Models\Proyek;
use App\Models\SaldoAkun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ProsesAwalTahunController extends Controller
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

        return view('transaksi.prosesAwalTahun', compact('cabangs', 'proyeks'));
    }

    public function proses(Request $request)
    {

        $request->validate([
            'id_cabang' => 'required',
            'bulan' => ''
        ]);

        $id_cabang = $request->input('id_cabang');
        $id_proyek = $request->input('id_proyek');
        $tahun = $request->input('tahun');

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

            // -----------------------------------------
            // alur:
            // 1. get semua data di tabel kode_perkiraans by cabang dan proyek, inner join ke saldo_akuns

            $tahunPrev = $tahun - 1;
            $listKodePerkiraans = KodePerkiraan::select('kode_perkiraans.id', 'kode_perkiraans.kode')
                ->join('saldo_akuns', 'kode_perkiraans.id', '=', 'saldo_akuns.id_kode_perkiraan')
                ->where('kode_perkiraans.id_cabang', $id_cabang)
                ->where('kode_perkiraans.id_proyek', $id_proyek)
                ->where('saldo_akuns.tahun', $tahunPrev)
                ->where('kode_perkiraans.kode', 'not like', '310%')
                ->groupBy('kode_perkiraans.id')->get();

            // dd($kodePerkiraans->toSql());
            // dd($listKodePerkiraans);

            // 2. di perulangan data kode akun, bikin perulangan bulan.
            foreach ($listKodePerkiraans as $kodePerk) {
                $jumlah = 0;

                // echo substr($kodePerk->kode, 0, 3) . "<br>";
                // ambil saldo awal tahunprev, dan hitung
                $saldoAwal = SaldoAkun::where('id_kode_perkiraan', $kodePerk->id)
                    ->where('tahun', $tahunPrev)
                    ->where('is_saldo_awal', 1)->first();

                if ($saldoAwal != null) {
                    $saldoAwalDebet = $saldoAwal->saldo_debet;
                    $saldoAwalKredit = $saldoAwal->saldo_kredit;

                    if (substr($kodePerk->kode, 0, 3) != '320' && substr($kodePerk->kode, 0, 3) != '900') {
                        if (substr($kodePerk->kode, 0, 1) == '1' || substr($kodePerk->kode, 0, 1) == '5' || substr($kodePerk->kode, 0, 1) == '6' || substr($kodePerk->kode, 0, 1) == '8') {
                            $jumlah += $saldoAwalDebet - $saldoAwalKredit;
                        } else {
                            $jumlah += $saldoAwalKredit - $saldoAwalDebet;
                        }
                    }
                }

                for ($i = 1; $i <= 12; $i++) {
                    // 3. didalam perulangan bulan, get data saldo_akuns by id_kode_perkiraan
                    // ambil saldo di bulan 1 s/d 12 dan hitung akumulasi
                    $saldoTrx = SaldoAkun::where('id_kode_perkiraan', $kodePerk->id)
                        ->where('tahun', $tahunPrev)
                        ->where('bulan', $i)
                        ->where('is_saldo_awal', 0)->first();

                    if ($saldoTrx != null) {
                        $saldoDebet = $saldoTrx->saldo_debet;
                        $saldoKredit = $saldoTrx->saldo_kredit;

                        if (substr($kodePerk->kode, 0, 1) == '1' || substr($kodePerk->kode, 0, 1) == '5' || substr($kodePerk->kode, 0, 1) == '6' || substr($kodePerk->kode, 0, 1) == '8') {
                            $jumlah += $saldoDebet - $saldoKredit;
                        } else {
                            $jumlah += $saldoKredit - $saldoDebet;
                        }
                    }
                }

                // insert data saldo_akuns ke tahun yg dipilih. cek apakah sudah ada data
                $cekSaldoAkun = SaldoAkun::where('id_kode_perkiraan', $kodePerk->id)
                    ->where('tahun', $tahun)
                    ->where('is_saldo_awal', 1)->first();

                if ($cekSaldoAkun == null) {
                    if (substr($kodePerk->kode, 0, 3) != '320' && substr($kodePerk->kode, 0, 3) != '900') {
                        // echo substr($kodePerk->kode, 0, 1) . "<br>";
                        if (substr($kodePerk->kode, 0, 1) == '1' || substr($kodePerk->kode, 0, 1) == '5' || substr($kodePerk->kode, 0, 1) == '6' || substr($kodePerk->kode, 0, 1) == '8') {
                            if ($jumlah >= 0) {
                                SaldoAkun::create([
                                    'id_kode_perkiraan' => $kodePerk->id,
                                    'tahun' => $tahun,
                                    'is_saldo_awal' => 1,
                                    'saldo_debet' => $jumlah,
                                    'saldo_kredit' => 0
                                ]);
                            } else {
                                SaldoAkun::create([
                                    'id_kode_perkiraan' => $kodePerk->id,
                                    'tahun' => $tahun,
                                    'is_saldo_awal' => 1,
                                    'saldo_debet' => 0,
                                    'saldo_kredit' => abs($jumlah)
                                ]);
                            }
                        } else {
                            if ($jumlah >= 0) {
                                SaldoAkun::create([
                                    'id_kode_perkiraan' => $kodePerk->id,
                                    'tahun' => $tahun,
                                    'is_saldo_awal' => 1,
                                    'saldo_debet' => 0,
                                    'saldo_kredit' => $jumlah
                                ]);
                            } else {
                                SaldoAkun::create([
                                    'id_kode_perkiraan' => $kodePerk->id,
                                    'tahun' => $tahun,
                                    'is_saldo_awal' => 1,
                                    'saldo_debet' => abs($jumlah),
                                    'saldo_kredit' => 0
                                ]);
                            }
                        }
                    }
                } else {
                    // echo substr($kodePerk->kode, 0, 1) . "<br>";
                    // update
                    if (substr($kodePerk->kode, 0, 3) != '320' && substr($kodePerk->kode, 0, 3) != '900') {
                        // echo "masuk " . $kodePerk->kode . "<br>";
                        if (substr($kodePerk->kode, 0, 1) == '1' || substr($kodePerk->kode, 0, 1) == '5' || substr($kodePerk->kode, 0, 1) == '6' || substr($kodePerk->kode, 0, 1) == '8') {
                            if ($jumlah >= 0) {
                                $cekSaldoAkun->update([
                                    'saldo_debet' => $jumlah,
                                    'saldo_kredit' => 0
                                ]);
                            } else {
                                $cekSaldoAkun->update([
                                    'saldo_debet' => 0,
                                    'saldo_kredit' => abs($jumlah)
                                ]);
                            }
                        } else {
                            if ($jumlah >= 0) {
                                $cekSaldoAkun->update([
                                    'saldo_debet' => 0,
                                    'saldo_kredit' => $jumlah
                                ]);
                            } else {
                                $cekSaldoAkun->update([
                                    'saldo_debet' => abs($jumlah),
                                    'saldo_kredit' => 0
                                ]);
                            }
                        }
                    }
                }

                // jika kode = 320, maka sekalian insert 310
                if (substr($kodePerk->kode, 0, 3) == '320') {
                    // insert juga ke 310. get id_kode_perkiraan berdasarkan cabang dan proyek utk like 310%
                    $akun310 = KodePerkiraan::where('id_cabang', $id_cabang)
                        ->where('id_proyek', $id_proyek)
                        ->where('kode', 'like', '310%')->first();

                    if ($akun310 != null) {
                        $idAkun310 = $akun310->id;

                        // cek saldo akun apakah sudah ada data 310
                        $cekSaldoAkun = SaldoAkun::where('id_kode_perkiraan', $idAkun310)
                            ->where('tahun', $tahun)
                            ->where('is_saldo_awal', 1)->first();

                        if ($cekSaldoAkun == null) {
                            if ($jumlah >= 0) {
                                SaldoAkun::create([
                                    'id_kode_perkiraan' => $idAkun310,
                                    'tahun' => $tahun,
                                    'is_saldo_awal' => 1,
                                    'saldo_debet' => 0,
                                    'saldo_kredit' => $jumlah
                                ]);
                            } else {
                                SaldoAkun::create([
                                    'id_kode_perkiraan' => $idAkun310,
                                    'tahun' => $tahun,
                                    'is_saldo_awal' => 1,
                                    'saldo_debet' => abs($jumlah),
                                    'saldo_kredit' => 0
                                ]);
                            }
                        } else {
                            if ($jumlah >= 0) {
                                $cekSaldoAkun->update([
                                    'saldo_debet' => 0,
                                    'saldo_kredit' => $jumlah
                                ]);
                            } else {
                                $cekSaldoAkun->update([
                                    'saldo_debet' => abs($jumlah),
                                    'saldo_kredit' => 0
                                ]);
                            }
                        }
                    }
                }
            }

            // DONE TAMBAHAN 310 4:58. tested 26-04-2024 DONE FIXED
            // die();
            // --------------------- END HITUNG--------------------

            // Commit the transaction if all operations are successful
            DB::commit();

            Alert::success('Berhasil', 'Proses awal tahun di cabang ' . $namaCabang . ' ' . $namaProyek . ' tahun ' . $tahun . ' berhasil');
            return redirect()->route('prosesAwalTahun');
        } catch (\Exception $e) {
            DB::rollback();

            Alert::error('Gagal', 'Proses awal tahun gagal, silahkan ulangi kembali');
            return redirect()->route('prosesAwalTahun');
        }
    }
}

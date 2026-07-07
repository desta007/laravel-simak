<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\KodeBukti;
use App\Models\KodePerkiraan;
use App\Models\KunciTransaksi;
use App\Models\Proyek;
use App\Models\KladKasBank;
use App\Models\KladKasBankDetail;
use App\Models\RekeningBank;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ExportKladKasBank;
use Maatwebsite\Excel\Facades\Excel;

class KladKasBankController extends Controller
{
    /**
     * Get cabang, proyek lists based on user role
     */
    private function getCabangProyekByRole()
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;
        $id_cabang = auth()->user()->id_cabang;

        if ($id_group_user == 1) {
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();
            $id_proyek = 'all';
        } elseif ($id_group_user == 2) {
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
            $id_proyek = 'all';
        } else {
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->get();

            $proyek_first = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->first();

            $id_proyek = $proyek_first['id'];
        }

        return compact('id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks');
    }

    /**
     * List klad kas/bank transactions
     */
    public function index()
    {
        session()->forget('totalAmountD');

        $tgl_awal = Carbon::now()->startOfMonth()->toDateString();
        // $tgl_akhir = Carbon::now()->toDateString();
        $tgl_akhir = Carbon::now()->endOfMonth()->toDateString();

        $noBukti = '';
        $jenisKlad = 'all';

        $roleData = $this->getCabangProyekByRole();
        extract($roleData);

        $query = KladKasBank::query()
            ->with(['details.kodePerkiraan', 'kodebukti', 'cabang', 'proyek', 'rekeningBank'])
            ->addSelect([
                'isLock' => KunciTransaksi::query()
                    ->select('status_akses')
                    ->whereColumn('id_cabang', 'klad_kas_banks.id_cabang')
                    ->whereColumn('id_proyek', 'klad_kas_banks.id_proyek')
                    ->whereRaw('bulan = MONTH(klad_kas_banks.tgl)')
                    ->whereRaw('tahun = YEAR(klad_kas_banks.tgl)')
                    ->limit(1)
            ]);

        $query->whereBetween('tgl', [$tgl_awal, $tgl_akhir]);

        if ($jenisKlad != 'all') {
            $query->where('jenis', $jenisKlad);
        }

        if ($id_group_user == 1) {
            $query->orderBy('created_at', 'desc');
        } elseif ($id_group_user == 2) {
            $query->where('id_cabang', $id_cabang)->orderBy('created_at', 'desc');
        } else {
            $query->where('id_cabang', $id_cabang)
                ->where('id_proyek', $id_proyek)
                ->orderBy('created_at', 'desc');
        }

        $results = $query->paginate(25)->appends(request()->query());

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('kladKasBank.kladKasBank', compact(
            'id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks',
            'tgl_awal', 'tgl_akhir', 'noBukti', 'jenisKlad', 'results'
        ));
    }

    /**
     * Search/filter klad transactions
     */
    public function search(Request $request)
    {
        session()->forget('totalAmountD');

        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;

        $id_cabang = $request->input('id_cabang');
        $id_proyek = $request->input('id_proyek');
        $noBukti = $request->input('noBukti');
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');
        $jenisKlad = $request->input('jenisKlad', 'all');

        $query = KladKasBank::query()
            ->with(['details.kodePerkiraan', 'kodebukti', 'cabang', 'proyek', 'rekeningBank'])
            ->addSelect([
                'isLock' => KunciTransaksi::query()
                    ->select('status_akses')
                    ->whereColumn('id_cabang', 'klad_kas_banks.id_cabang')
                    ->whereColumn('id_proyek', 'klad_kas_banks.id_proyek')
                    ->whereRaw('bulan = MONTH(klad_kas_banks.tgl)')
                    ->whereRaw('tahun = YEAR(klad_kas_banks.tgl)')
                    ->limit(1)
            ]);

        $query->whereBetween('tgl', [$tgl_awal, $tgl_akhir]);

        if ($jenisKlad != 'all') {
            $query->where('jenis', $jenisKlad);
        }

        if ($id_group_user == 1) {
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();

            if ($id_cabang != '')
                $query->where('id_cabang', $id_cabang);
            if ($id_proyek != 'all')
                $query->where('id_proyek', $id_proyek);

            $query->where('no_urut_bukti', 'like', '%' . $noBukti . '%');
            $query->orderBy('created_at', 'desc');
        } elseif ($id_group_user == 2) {
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();

            $query->where('id_cabang', $id_cabang);
            if ($id_proyek != 'all')
                $query->where('id_proyek', $id_proyek);

            $query->where('no_urut_bukti', 'like', '%' . $noBukti . '%');
            $query->orderBy('created_at', 'desc');
        } else {
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->get();

            $query->where('id_cabang', $id_cabang)
                ->where('id_proyek', $id_proyek)
                ->where('no_urut_bukti', 'like', '%' . $noBukti . '%')
                ->orderBy('created_at', 'desc');
        }

        $results = $query->paginate(25)->appends([
            'tgl_awal' => $tgl_awal,
            'tgl_akhir' => $tgl_akhir,
            'id_cabang' => $id_cabang,
            'id_proyek' => $id_proyek,
            'noBukti' => $noBukti,
            'jenisKlad' => $jenisKlad,
        ]);

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('kladKasBank.kladKasBank', compact(
            'id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks',
            'tgl_awal', 'tgl_akhir', 'noBukti', 'jenisKlad', 'results'
        ));
    }

    /**
     * Show form for creating new klad entry
     */
    public function create(Request $request)
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_cabang = auth()->user()->id_cabang;

        if ($id_group_user == 1) {
            $cabangs = Cabang::all();
        } else {
            $cabangs = Cabang::where('id', $id_cabang)->get();
        }

        $proyeks = '';
        if ($id_group_user == 2) {
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
        } elseif ($id_group_user == 3) {
            $id_user = auth()->user()->id;
            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)
                ->orderBy('proyeks.created_at', 'desc')->get();
        }

        $rekeningBanks = RekeningBank::where('is_active', true)->orderBy('nama_bank')->get();

        $tgl = Carbon::now()->toDateString();
        session()->forget('totalAmountD');

        return view('kladKasBank.kladKasBankAdd', [
            'cabangs' => $cabangs,
            'proyeks' => $proyeks,
            'rekeningBanks' => $rekeningBanks,
            'id_group_user' => $id_group_user,
            'tgl' => $tgl,
        ]);
    }

    /**
     * Store new klad entry (multi-proyek, jurnal langsung D/K)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_cabang' => 'required',
            'jenis_data' => 'required|in:kas,bank',
            'jenis_transaksi' => 'required|in:pengeluaran,penerimaan',
            'tgl' => 'required',
            'proyeks' => 'required|array|min:1',
        ]);

        $jenisData = $request->input('jenis_data');
        $jenisTransaksi = $request->input('jenis_transaksi');
        $proyeksData = $request->input('proyeks');

        try {
            DB::beginTransaction();

            // Determine kode_bukti & segmen automatically
            $rekeningBank = null;
            $segmen = null;
            if ($jenisData === 'bank') {
                $request->validate(['id_rekening_bank' => 'required']);
                $rekeningBank = RekeningBank::findOrFail($request->input('id_rekening_bank'));
                $kodeBukti = KodeBukti::where('kode', $rekeningBank->kode_bank)->first();
                if (!$kodeBukti) {
                    throw new \Exception('Kode Bukti untuk bank ' . $rekeningBank->kode_bank . ' tidak ditemukan. Silahkan tambahkan di Master Kode Bukti.');
                }
                $segmen = $rekeningBank->segmen_bukti; // OPR / PST
                $idKodeBukti = $kodeBukti->id;
            } else {
                $kodeBukti = KodeBukti::where('kode', 'KAS')->first();
                if (!$kodeBukti) {
                    throw new \Exception('Kode Bukti KAS tidak ditemukan. Silahkan tambahkan di Master Kode Bukti.');
                }
                $idKodeBukti = $kodeBukti->id;
            }

            $tgl = Carbon::parse($request->input('tgl'));

            // Handle file upload once (dipakai bersama semua proyek section)
            $fileName = '';
            if ($request->hasFile('file_dokumen')) {
                $extension = $request->file('file_dokumen')->getClientOriginalExtension();
                $fileName = date("Ymd") . '_' . time() . '.' . $extension;
                $request->file('file_dokumen')->storeAs('klad_kas_banks', $fileName);
            }

            // Lock & hitung no_urut berikutnya (urutan terpisah per tipe voucher)
            $lockedRows = $this->latestNoUrutQuery(
                $request->input('id_cabang'), $jenisData, $jenisTransaksi, $idKodeBukti, $rekeningBank, $tgl
            )->lockForUpdate()->get();
            $latestNoUrutBukti = $lockedRows->max('no_urut_bukti');
            $nextNoUrutBukti = $latestNoUrutBukti ? $latestNoUrutBukti + 1 : 1;

            $createdCount = 0;

            foreach ($proyeksData as $proyekSection) {
                $idProyek = $proyekSection['id_proyek'] ?? 0;
                $rows = $this->parseJournalRows($proyekSection['details'] ?? []);

                if (count($rows['entries']) < 1) continue;

                $this->assertBalanced($rows, 'Proyek section');

                $noBuktiFull = $this->buildNoBukti($nextNoUrutBukti, $kodeBukti->kode, $segmen, $tgl);

                $klad = KladKasBank::create([
                    'id_cabang' => $request->input('id_cabang'),
                    'id_proyek' => $idProyek,
                    'jenis' => $jenisData,
                    'jenis_transaksi' => $jenisTransaksi,
                    'id_rekening_bank' => $jenisData === 'bank' ? $request->input('id_rekening_bank') : null,
                    'id_kode_bukti' => $idKodeBukti,
                    'id_kode_perkiraan_kas_bank' => null,
                    'tgl' => $request->input('tgl'),
                    'no_bukti' => $noBuktiFull,
                    'no_urut_bukti' => $nextNoUrutBukti,
                    'keterangan' => $request->input('keterangan'),
                    'pihak_terkait' => $request->input('pihak_terkait'),
                    'alamat' => $request->input('alamat'),
                    'berupa' => $request->input('berupa'),
                    'catatan' => $request->input('catatan'),
                    'file_dokumen' => $fileName,
                ]);

                $this->saveJournalEntries($klad, $rows['entries']);

                $nextNoUrutBukti++;
                $createdCount++;
            }

            if ($createdCount === 0) {
                throw new \Exception('Tidak ada data jurnal yang valid untuk disimpan');
            }

            DB::commit();
            session()->forget('totalAmountD');

            Alert::success('Berhasil', $createdCount . ' transaksi klad berhasil disimpan');
            return redirect()->route('kladKasBank');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Klad Store Error: ' . $e->getMessage());

            Alert::error('Gagal', $e->getMessage());
            return redirect()->route('addKladKasBank');
        }
    }

    /**
     * Query dasar untuk mencari no_urut_bukti terakhir.
     * Urutan terpisah per (cabang, jenis, jenis_transaksi, kode_bukti, segmen, bulan, tahun).
     */
    private function latestNoUrutQuery($idCabang, $jenisData, $jenisTransaksi, $idKodeBukti, $rekeningBank, Carbon $tgl)
    {
        $query = KladKasBank::where('id_cabang', $idCabang)
            ->where('jenis', $jenisData)
            ->where('jenis_transaksi', $jenisTransaksi)
            ->where('id_kode_bukti', $idKodeBukti)
            ->whereYear('tgl', $tgl->format('Y'))
            ->whereMonth('tgl', $tgl->format('m'));

        // Bank: pisahkan urutan berdasarkan segmen (induk/operasional) via rekening.
        if ($jenisData === 'bank' && $rekeningBank) {
            $segmenRekIds = RekeningBank::where('kode_bank', $rekeningBank->kode_bank)
                ->where('jenis_rekening', $rekeningBank->jenis_rekening)
                ->pluck('id');
            $query->whereIn('id_rekening_bank', $segmenRekIds);
        }

        return $query;
    }

    /**
     * Bangun nomor bukti.
     * Bank: 001/BNI/OPR/mm/yy ; Kas: 001/KAS/mm/yy
     */
    private function buildNoBukti($noUrut, $kodeBuktiKode, $segmen, Carbon $tgl): string
    {
        $no3 = str_pad($noUrut, 3, '0', STR_PAD_LEFT);
        $mm = $tgl->format('m');
        $yy = $tgl->format('y');

        if ($segmen) {
            return $no3 . '/' . $kodeBuktiKode . '/' . $segmen . '/' . $mm . '/' . $yy;
        }
        return $no3 . '/' . $kodeBuktiKode . '/' . $mm . '/' . $yy;
    }

    /**
     * Parse baris jurnal dari input form. Return entries + total D/K.
     */
    private function parseJournalRows($details): array
    {
        $entries = [];
        $totalD = 0;
        $totalK = 0;

        foreach ($details as $detail) {
            $nilai = (float) preg_replace('/[^\d]/', '', (string) ($detail['nilai'] ?? '0'));
            if (empty($detail['id_kode_perkiraan']) || $nilai <= 0) continue;

            $jenis = (($detail['jenis'] ?? 'D') === 'K') ? 'K' : 'D';
            $entries[] = [
                'id_kode_perkiraan' => $detail['id_kode_perkiraan'],
                'jenis' => $jenis,
                'jumlah' => $nilai,
            ];
            $jenis === 'D' ? $totalD += $nilai : $totalK += $nilai;
        }

        return ['entries' => $entries, 'totalD' => $totalD, 'totalK' => $totalK];
    }

    /**
     * Pastikan jurnal seimbang (total Debet == total Kredit) dan minimal 2 baris.
     */
    private function assertBalanced(array $rows, string $label): void
    {
        if (count($rows['entries']) < 2) {
            throw new \Exception($label . ': Minimal 2 baris jurnal (Debet & Kredit) harus diisi.');
        }
        if (round($rows['totalD']) != round($rows['totalK'])) {
            throw new \Exception(
                $label . ': Jurnal tidak seimbang. Debet ' . number_format($rows['totalD']) .
                ' ≠ Kredit ' . number_format($rows['totalK']) . '.'
            );
        }
    }

    /**
     * Simpan baris-baris jurnal.
     */
    private function saveJournalEntries($klad, array $entries): void
    {
        foreach ($entries as $entry) {
            KladKasBankDetail::create([
                'id_klad_kas_bank' => $klad->id,
                'id_kode_perkiraan' => $entry['id_kode_perkiraan'],
                'jenis' => $entry['jenis'],
                'kategori' => null,
                'jumlah' => $entry['jumlah'],
            ]);
        }
    }

    /**
     * Edit klad entry
     */
    public function edit($id)
    {
        $id_group_user = auth()->user()->id_group_user;

        $klad = KladKasBank::with(['details.kodePerkiraan', 'rekeningBank'])->findOrFail($id);
        $id_cabang = $klad->id_cabang;

        if ($id_group_user == 1) {
            $cabangs = Cabang::all();
        } else {
            $cabangs = Cabang::where('id', $id_cabang)->get();
        }

        $proyeks = '';
        if ($id_group_user == 2 || $id_group_user == 1) {
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
        } elseif ($id_group_user == 3) {
            $id_user = auth()->user()->id;
            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)
                ->orderBy('proyeks.created_at', 'desc')->get();
        }

        $rekeningBanks = RekeningBank::where('is_active', true)->orderBy('nama_bank')->get();

        return view('kladKasBank.kladKasBankEdit', [
            'cabangs' => $cabangs,
            'proyeks' => $proyeks,
            'rekeningBanks' => $rekeningBanks,
            'id_group_user' => $id_group_user,
            'klad' => $klad,
        ]);
    }

    /**
     * Update klad entry
     */
    public function update(Request $request, $id)
    {
        $klad = KladKasBank::findOrFail($id);

        $request->validate([
            'jenis_data' => 'required|in:kas,bank',
            'jenis_transaksi' => 'required|in:pengeluaran,penerimaan',
            'tgl' => 'required',
            'proyeks' => 'required|array|min:1',
        ]);

        $jenisData = $request->input('jenis_data');
        $jenisTransaksi = $request->input('jenis_transaksi');
        $proyeksData = $request->input('proyeks');

        $proyekSection = $proyeksData[0] ?? null;
        if (!$proyekSection) {
            Alert::error('Error', 'Data jurnal tidak ditemukan');
            return back()->withInput();
        }

        try {
            DB::beginTransaction();

            $rows = $this->parseJournalRows($proyekSection['details'] ?? []);
            $this->assertBalanced($rows, 'Jurnal');

            // Determine kode_bukti & segmen automatically
            $segmen = null;
            if ($jenisData === 'bank') {
                $request->validate(['id_rekening_bank' => 'required']);
                $rekeningBank = RekeningBank::findOrFail($request->input('id_rekening_bank'));
                $kodeBukti = KodeBukti::where('kode', $rekeningBank->kode_bank)->first();
                if (!$kodeBukti) {
                    throw new \Exception('Kode Bukti untuk bank ' . $rekeningBank->kode_bank . ' tidak ditemukan.');
                }
                $segmen = $rekeningBank->segmen_bukti;
                $idKodeBukti = $kodeBukti->id;
            } else {
                $kodeBukti = KodeBukti::where('kode', 'KAS')->first();
                if (!$kodeBukti) {
                    throw new \Exception('Kode Bukti KAS tidak ditemukan.');
                }
                $idKodeBukti = $kodeBukti->id;
            }

            $tgl = Carbon::parse($request->input('tgl'));

            // Update header
            $klad->tgl = $request->input('tgl');
            $klad->keterangan = $request->input('keterangan');
            $klad->pihak_terkait = $request->input('pihak_terkait');
            $klad->alamat = $request->input('alamat');
            $klad->berupa = $request->input('berupa');
            $klad->catatan = $request->input('catatan');
            $klad->jenis = $jenisData;
            $klad->jenis_transaksi = $jenisTransaksi;
            $klad->id_kode_bukti = $idKodeBukti;
            $klad->id_kode_perkiraan_kas_bank = null;
            $klad->id_rekening_bank = $jenisData === 'bank' ? $request->input('id_rekening_bank') : null;
            $klad->id_proyek = $proyekSection['id_proyek'] ?? $klad->id_proyek;

            // Regenerate no_bukti (no_urut tetap)
            $klad->no_bukti = $this->buildNoBukti($klad->no_urut_bukti, $kodeBukti->kode, $segmen, $tgl);

            if ($request->hasFile('file_dokumen')) {
                if ($klad->file_dokumen != '') {
                    Storage::delete('klad_kas_banks/' . $klad->file_dokumen);
                }
                $extension = $request->file('file_dokumen')->getClientOriginalExtension();
                $fileName = date("Ymd") . '_' . time() . '.' . $extension;
                $request->file('file_dokumen')->storeAs('klad_kas_banks', $fileName);
                $klad->file_dokumen = $fileName;
            }

            $klad->save();

            // Delete old details and save new ones
            KladKasBankDetail::where('id_klad_kas_bank', $id)->delete();
            $this->saveJournalEntries($klad, $rows['entries']);

            DB::commit();

            Alert::success('Berhasil', 'Transaksi klad berhasil diupdate');
            return redirect()->route('kladKasBank');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Klad Update Error: ' . $e->getMessage());

            Alert::error('Gagal', $e->getMessage());
            return redirect()->route('editKladKasBank', $id);
        }
    }

    /**
     * Delete klad entry
     */
    public function destroy($id)
    {
        $klad = KladKasBank::findOrFail($id);

        try {
            DB::beginTransaction();

            if ($klad->file_dokumen != '')
                Storage::delete('klad_kas_banks/' . $klad->file_dokumen);

            KladKasBankDetail::where('id_klad_kas_bank', $id)->delete();
            $klad->delete();

            DB::commit();

            Alert::success('Berhasil', 'Transaksi klad berhasil dihapus');
            return redirect()->route('kladKasBank');
        } catch (\Exception $e) {
            DB::rollback();

            Alert::error('Gagal', 'Transaksi gagal dihapus');
            return redirect()->route('kladKasBank');
        }
    }

    /**
     * Print voucher
     */
    public function printVoucher($id)
    {
        $klad = KladKasBank::with(['details.kodePerkiraan', 'kodebukti', 'cabang', 'proyek', 'rekeningBank'])->findOrFail($id);

        // Jurnal langsung: total Debet & Kredit dari baris jurnal (seimbang).
        $jum_D = $klad->details->where('jenis', 'D')->sum('jumlah');
        $jum_K = $klad->details->where('jenis', 'K')->sum('jumlah');

        return view('kladKasBank.voucherPrint', compact('klad', 'jum_D', 'jum_K'));
    }

    /**
     * Export voucher to PDF
     */
    public function exportVoucherPdf($id)
    {
        $klad = KladKasBank::with(['details.kodePerkiraan', 'kodebukti', 'cabang', 'proyek', 'rekeningBank'])->findOrFail($id);

        // Jurnal langsung: total Debet & Kredit dari baris jurnal (seimbang).
        $jum_D = $klad->details->where('jenis', 'D')->sum('jumlah');
        $jum_K = $klad->details->where('jenis', 'K')->sum('jumlah');

        $pdf = Pdf::loadView('kladKasBank.voucherPdf', compact('klad', 'jum_D', 'jum_K'))
            ->setPaper('a4');

        $tipeVoucher = strtoupper($klad->jenis_transaksi);
        $jenisKlad = strtoupper($klad->jenis);
        $fileName = 'Voucher_' . $tipeVoucher . '_' . $jenisKlad . '_' . $klad->no_urut_bukti . '.pdf';

        return $pdf->stream($fileName);
    }

    /**
     * Show report page
     */
    public function report()
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;
        $jenisKlad = 'all';

        $roleData = $this->getCabangProyekByRole();
        extract($roleData);

        $isView = '';

        return view('kladKasBank.laporanKladKasBank', compact(
            'id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks',
            'bulan', 'tahun', 'jenisKlad', 'isView'
        ));
    }

    /**
     * Search/filter report
     */
    public function reportSearch(Request $request)
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_user = auth()->user()->id;

        $id_cabang = $request->input('id_cabang');
        $id_proyek = $request->input('id_proyek');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $jenisKlad = $request->input('jenisKlad', 'all');

        if ($id_group_user == 1) {
            $cabangs = Cabang::all();
            $proyeks = Proyek::all();
        } elseif ($id_group_user == 2) {
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::where('id_cabang', '=', $id_cabang)->get();
        } else {
            $cabangs = Cabang::where('id', $id_cabang)->get();
            $proyeks = Proyek::select('proyeks.*')
                ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                ->where('user_proyeks.id_user', $id_user)->get();
        }

        $query = KladKasBank::with(['details.kodePerkiraan', 'kodebukti', 'cabang', 'proyek', 'rekeningBank'])
            ->whereYear('tgl', $tahun)
            ->whereMonth('tgl', $bulan);

        if ($jenisKlad != 'all') {
            $query->where('jenis', $jenisKlad);
        }

        if ($id_group_user == 1) {
            if ($id_cabang != '')
                $query->where('id_cabang', $id_cabang);
            if ($id_proyek != 'all')
                $query->where('id_proyek', $id_proyek);
        } elseif ($id_group_user == 2) {
            $query->where('id_cabang', $id_cabang);
            if ($id_proyek != 'all')
                $query->where('id_proyek', $id_proyek);
        } else {
            $query->where('id_cabang', $id_cabang)
                ->where('id_proyek', $id_proyek);
        }

        $query->orderBy('tgl', 'asc')->orderBy('no_urut_bukti', 'asc');
        $results = $query->get();

        $isView = '1';

        return view('kladKasBank.laporanKladKasBank', compact(
            'id_group_user', 'id_cabang', 'id_proyek', 'cabangs', 'proyeks',
            'bulan', 'tahun', 'jenisKlad', 'results', 'isView'
        ));
    }

    /**
     * Export report (Print/PDF/Excel)
     */
    public function reportExport(Request $request)
    {
        set_time_limit(300);

        $id_cabang = $request->input('id_cabang2');
        $id_proyek = $request->input('id_proyek2');
        $bulan = $request->input('bulan2');
        $tahun = $request->input('tahun2');
        $jenisKlad = $request->input('jenisKlad2', 'all');

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

        $query = KladKasBank::with(['details.kodePerkiraan', 'kodebukti', 'cabang', 'proyek'])
            ->whereYear('tgl', $tahun)
            ->whereMonth('tgl', $bulan);

        if ($jenisKlad != 'all') {
            $query->where('jenis', $jenisKlad);
        }

        if ($id_cabang != '')
            $query->where('id_cabang', $id_cabang);
        if ($id_proyek != 'all')
            $query->where('id_proyek', $id_proyek);

        $query->orderBy('tgl', 'asc')->orderBy('no_urut_bukti', 'asc');
        $results = $query->get();

        $namaBulan = date('F', mktime(0, 0, 0, $bulan, 1));
        $jenisLabel = $jenisKlad == 'kas' ? 'Kas' : ($jenisKlad == 'bank' ? 'Bank' : 'Kas & Bank');

        if ($print != '') {
            return view('kladKasBank.laporanKladKasBankPrint', compact(
                'namaCabang', 'namaProyek', 'bulan', 'tahun', 'namaBulan',
                'jenisKlad', 'jenisLabel', 'results', 'id_cabang'
            ));
        }

        if ($pdf != '') {
            $pdfDoc = Pdf::loadView('kladKasBank.laporanKladKasBankPdf', compact(
                'namaCabang', 'namaProyek', 'bulan', 'tahun', 'namaBulan',
                'jenisKlad', 'jenisLabel', 'results', 'id_cabang'
            ))->setPaper('a4', 'landscape');

            $namaFile = 'Laporan_Klad_' . $jenisLabel . '_' . $namaBulan . '_' . $tahun . '.pdf';
            return $pdfDoc->stream($namaFile);
        }

        if ($excel != '') {
            $dataExcel = [];
            $dataExcel[] = ['id_cabang' => $id_cabang, '', '', '', 'Laporan Klad ' . $jenisLabel, '', '', ''];
            $dataExcel[] = ['', '', '', '', $namaCabang . ' / ' . $namaProyek, '', '', ''];
            $dataExcel[] = ['', '', '', '', 'Periode: ' . $namaBulan . ' ' . $tahun, '', '', ''];
            $dataExcel[] = ['', '', '', '', '', '', '', ''];

            $dataExcel[] = ['No', 'Tanggal', 'No Bukti', 'Jenis', 'Tipe', 'Keterangan', 'Debet', 'Kredit'];

            $totalDebet = 0;
            $totalKredit = 0;
            $no = 1;

            foreach ($results as $klad) {
                $jenisT = ucfirst($klad->jenis);
                $tipeV = ucfirst($klad->jenis_transaksi);

                $jum_D = 0;
                $jum_K = 0;
                foreach ($klad->details as $detail) {
                    $detail->jenis == 'D' ? ($jum_D += $detail->jumlah) : ($jum_K += $detail->jumlah);
                }

                $totalDebet += $jum_D;
                $totalKredit += $jum_K;

                $dataExcel[] = [
                    $no++,
                    Carbon::parse($klad->tgl)->format('d/m/Y'),
                    $klad->no_bukti,
                    $jenisT,
                    $tipeV,
                    $klad->keterangan,
                    $jum_D,
                    $jum_K,
                ];
            }

            $dataExcel[] = ['', '', '', '', '', 'Total', $totalDebet, $totalKredit];

            $namaFile = 'Laporan_Klad_' . $jenisLabel . '_' . $namaBulan . '_' . $tahun . '.xlsx';
            return Excel::download(new ExportKladKasBank($dataExcel), $namaFile);
        }
    }
}

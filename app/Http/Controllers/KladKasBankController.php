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
        $tgl_akhir = Carbon::now()->toDateString();
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
     * Store new klad entry (multi-proyek)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_cabang' => 'required',
            'jenis_data' => 'required|in:kas,bank',
            'jenis_transaksi' => 'required|in:pengeluaran,penerimaan',
            'id_kode_perkiraan_kas_bank' => 'required',
            'tgl' => 'required',
            'proyeks' => 'required|array|min:1',
        ]);

        $jenisData = $request->input('jenis_data');
        $jenisTransaksi = $request->input('jenis_transaksi');
        $idKodePerkiraanKasBank = $request->input('id_kode_perkiraan_kas_bank');
        $proyeksData = $request->input('proyeks');
        $isPengeluaran = ($jenisTransaksi === 'pengeluaran');

        try {
            DB::beginTransaction();

            // Determine kode_bukti automatically
            if ($jenisData === 'bank') {
                $request->validate(['id_rekening_bank' => 'required']);
                $rekeningBank = RekeningBank::findOrFail($request->input('id_rekening_bank'));
                $kodeBukti = KodeBukti::where('kode', $rekeningBank->kode_bank)->first();
                if (!$kodeBukti) {
                    throw new \Exception('Kode Bukti untuk bank ' . $rekeningBank->kode_bank . ' tidak ditemukan. Silahkan tambahkan di Master Kode Bukti.');
                }
                $idKodeBukti = $kodeBukti->id;
            } else {
                $kodeBukti = KodeBukti::where('kode', 'KAS')->first();
                if (!$kodeBukti) {
                    throw new \Exception('Kode Bukti KAS tidak ditemukan. Silahkan tambahkan di Master Kode Bukti.');
                }
                $idKodeBukti = $kodeBukti->id;
            }

            $tgl = Carbon::parse($request->input('tgl'));
            $month = $tgl->format('m');
            $year = $tgl->format('Y');

            // Handle file upload once
            $fileName = '';
            if ($request->hasFile('file_dokumen')) {
                $extension = $request->file('file_dokumen')->getClientOriginalExtension();
                $fileName = date("Ymd") . '_' . time() . '.' . $extension;
                $request->file('file_dokumen')->storeAs('klad_kas_banks', $fileName);
            }

            // Lock for no_urut_bukti generation
            $lockedRows = KladKasBank::where('id_cabang', $request->input('id_cabang'))
                ->where('id_kode_bukti', $idKodeBukti)
                ->whereYear('tgl', $year)
                ->whereMonth('tgl', $month)
                ->lockForUpdate()
                ->get();

            $latestNoUrutBukti = $lockedRows->max('no_urut_bukti');
            $nextNoUrutBukti = $latestNoUrutBukti ? $latestNoUrutBukti + 1 : 1;

            $createdCount = 0;

            foreach ($proyeksData as $proyekSection) {
                $idProyek = $proyekSection['id_proyek'] ?? 0;
                $details = $proyekSection['details'] ?? [];

                if (empty($details)) continue;

                $formattedNoUrutBukti = str_pad($nextNoUrutBukti, 4, '0', STR_PAD_LEFT);
                $noBuktiFull = $formattedNoUrutBukti . '/' . $kodeBukti->kode . '/' . $month . '/' . $year;

                $klad = KladKasBank::create([
                    'id_cabang' => $request->input('id_cabang'),
                    'id_proyek' => $idProyek,
                    'jenis' => $jenisData,
                    'jenis_transaksi' => $jenisTransaksi,
                    'id_rekening_bank' => $jenisData === 'bank' ? $request->input('id_rekening_bank') : null,
                    'id_kode_bukti' => $idKodeBukti,
                    'id_kode_perkiraan_kas_bank' => $idKodePerkiraanKasBank,
                    'tgl' => $request->input('tgl'),
                    'no_bukti' => $noBuktiFull,
                    'no_urut_bukti' => $nextNoUrutBukti,
                    'keterangan' => $request->input('keterangan'),
                    'pihak_terkait' => $request->input('pihak_terkait'),
                    'file_dokumen' => $fileName,
                ]);

                // Save detail entries with categories
                $this->saveDetailEntries($klad, $isPengeluaran, $details, $proyekSection, $idKodePerkiraanKasBank);

                $nextNoUrutBukti++;
                $createdCount++;
            }

            if ($createdCount === 0) {
                throw new \Exception('Tidak ada data proyek yang valid untuk disimpan');
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
     * Save detail entries with categories
     */
    private function saveDetailEntries($klad, $isPengeluaran, $details, $proyekSection, $idKodePerkiraanKasBank)
    {
        $detailJenis = $isPengeluaran ? 'D' : 'K';
        $kasBankJenis = $isPengeluaran ? 'K' : 'D';
        $ppnJenis = $detailJenis;
        $biayaLainJenis = $detailJenis;
        $potonganJenis = $isPengeluaran ? 'K' : 'D';

        $dpp = 0;

        // 1. Detail biaya/pendapatan items
        foreach ($details as $detail) {
            $nilai = (float)str_replace([',', '.'], ['', ''], $detail['nilai'] ?? 0);
            if ($nilai <= 0) continue;
            KladKasBankDetail::create([
                'id_klad_kas_bank' => $klad->id,
                'id_kode_perkiraan' => $detail['id_kode_perkiraan'],
                'jenis' => $detailJenis,
                'kategori' => 'detail',
                'jumlah' => $nilai,
            ]);
            $dpp += $nilai;
        }

        $subtotal = $dpp;

        // 2. PPN
        $ppnNilai = (float)str_replace([',', '.'], ['', ''], $proyekSection['ppn_nilai'] ?? 0);
        if ($ppnNilai > 0 && !empty($proyekSection['ppn_id_kode_perkiraan'])) {
            KladKasBankDetail::create([
                'id_klad_kas_bank' => $klad->id,
                'id_kode_perkiraan' => $proyekSection['ppn_id_kode_perkiraan'],
                'jenis' => $ppnJenis,
                'kategori' => 'ppn',
                'jumlah' => $ppnNilai,
            ]);
            $subtotal += $ppnNilai;
        }

        // 3. Biaya Lain
        $biayaLainNilai = (float)str_replace([',', '.'], ['', ''], $proyekSection['biaya_lain_nilai'] ?? 0);
        if ($biayaLainNilai > 0 && !empty($proyekSection['biaya_lain_id_kode_perkiraan'])) {
            KladKasBankDetail::create([
                'id_klad_kas_bank' => $klad->id,
                'id_kode_perkiraan' => $proyekSection['biaya_lain_id_kode_perkiraan'],
                'jenis' => $biayaLainJenis,
                'kategori' => 'biaya_lain',
                'jumlah' => $biayaLainNilai,
            ]);
            $subtotal += $biayaLainNilai;
        }

        // 4. PPh (potongan)
        $pphNilai = (float)str_replace([',', '.'], ['', ''], $proyekSection['pph_nilai'] ?? 0);
        if ($pphNilai > 0 && !empty($proyekSection['pph_id_kode_perkiraan'])) {
            KladKasBankDetail::create([
                'id_klad_kas_bank' => $klad->id,
                'id_kode_perkiraan' => $proyekSection['pph_id_kode_perkiraan'],
                'jenis' => $potonganJenis,
                'kategori' => 'pph',
                'jumlah' => $pphNilai,
            ]);
            $subtotal -= $pphNilai;
        }

        // 5. Potongan Uang Muka
        $potUmNilai = (float)str_replace([',', '.'], ['', ''], $proyekSection['pot_um_nilai'] ?? 0);
        if ($potUmNilai > 0 && !empty($proyekSection['pot_um_id_kode_perkiraan'])) {
            KladKasBankDetail::create([
                'id_klad_kas_bank' => $klad->id,
                'id_kode_perkiraan' => $proyekSection['pot_um_id_kode_perkiraan'],
                'jenis' => $potonganJenis,
                'kategori' => 'pot_um',
                'jumlah' => $potUmNilai,
            ]);
            $subtotal -= $potUmNilai;
        }

        // 6. Potongan Retensi
        $potRetensiNilai = (float)str_replace([',', '.'], ['', ''], $proyekSection['pot_retensi_nilai'] ?? 0);
        if ($potRetensiNilai > 0 && !empty($proyekSection['pot_retensi_id_kode_perkiraan'])) {
            KladKasBankDetail::create([
                'id_klad_kas_bank' => $klad->id,
                'id_kode_perkiraan' => $proyekSection['pot_retensi_id_kode_perkiraan'],
                'jenis' => $potonganJenis,
                'kategori' => 'pot_retensi',
                'jumlah' => $potRetensiNilai,
            ]);
            $subtotal -= $potRetensiNilai;
        }

        // 7. Potongan Lain
        $potLainNilai = (float)str_replace([',', '.'], ['', ''], $proyekSection['pot_lain_nilai'] ?? 0);
        if ($potLainNilai > 0 && !empty($proyekSection['pot_lain_id_kode_perkiraan'])) {
            KladKasBankDetail::create([
                'id_klad_kas_bank' => $klad->id,
                'id_kode_perkiraan' => $proyekSection['pot_lain_id_kode_perkiraan'],
                'jenis' => $potonganJenis,
                'kategori' => 'pot_lain',
                'jumlah' => $potLainNilai,
            ]);
            $subtotal -= $potLainNilai;
        }

        // 8. Kas/Bank entry (net amount = subtotal)
        if ($subtotal > 0) {
            KladKasBankDetail::create([
                'id_klad_kas_bank' => $klad->id,
                'id_kode_perkiraan' => $idKodePerkiraanKasBank,
                'jenis' => $kasBankJenis,
                'kategori' => 'kas_bank',
                'jumlah' => $subtotal,
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

        // Parse details by category
        $businessData = [
            'jenis_transaksi' => $klad->jenis_transaksi,
            'jenis_data' => $klad->jenis,
            'kas_bank_detail' => $klad->details->where('kategori', 'kas_bank')->first(),
            'ppn' => $klad->details->where('kategori', 'ppn')->first(),
            'pph' => $klad->details->where('kategori', 'pph')->first(),
            'pot_um' => $klad->details->where('kategori', 'pot_um')->first(),
            'pot_retensi' => $klad->details->where('kategori', 'pot_retensi')->first(),
            'pot_lain' => $klad->details->where('kategori', 'pot_lain')->first(),
            'biaya_lain' => $klad->details->where('kategori', 'biaya_lain')->first(),
            'detail_items' => $klad->details->where('kategori', 'detail')->values(),
        ];

        $rekeningBanks = RekeningBank::where('is_active', true)->orderBy('nama_bank')->get();

        return view('kladKasBank.kladKasBankEdit', [
            'cabangs' => $cabangs,
            'proyeks' => $proyeks,
            'rekeningBanks' => $rekeningBanks,
            'id_group_user' => $id_group_user,
            'klad' => $klad,
            'businessData' => $businessData,
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
            'id_kode_perkiraan_kas_bank' => 'required',
            'tgl' => 'required',
            'proyeks' => 'required|array|min:1',
        ]);

        $jenisData = $request->input('jenis_data');
        $jenisTransaksi = $request->input('jenis_transaksi');
        $idKodePerkiraanKasBank = $request->input('id_kode_perkiraan_kas_bank');
        $proyeksData = $request->input('proyeks');
        $isPengeluaran = ($jenisTransaksi === 'pengeluaran');

        $proyekSection = $proyeksData[0] ?? null;
        if (!$proyekSection) {
            Alert::error('Error', 'Data proyek tidak ditemukan');
            return back()->withInput();
        }

        $details = $proyekSection['details'] ?? [];
        if (empty($details)) {
            Alert::error('Error', 'Detail biaya harus diisi');
            return back()->withInput();
        }

        try {
            DB::beginTransaction();

            // Determine kode_bukti automatically
            if ($jenisData === 'bank') {
                $request->validate(['id_rekening_bank' => 'required']);
                $rekeningBank = RekeningBank::findOrFail($request->input('id_rekening_bank'));
                $kodeBukti = KodeBukti::where('kode', $rekeningBank->kode_bank)->first();
                if (!$kodeBukti) {
                    throw new \Exception('Kode Bukti untuk bank ' . $rekeningBank->kode_bank . ' tidak ditemukan.');
                }
                $idKodeBukti = $kodeBukti->id;
            } else {
                $kodeBukti = KodeBukti::where('kode', 'KAS')->first();
                if (!$kodeBukti) {
                    throw new \Exception('Kode Bukti KAS tidak ditemukan.');
                }
                $idKodeBukti = $kodeBukti->id;
            }

            $month = Carbon::parse($request->input('tgl'))->format('m');
            $year = Carbon::parse($request->input('tgl'))->year;

            // Update header
            $klad->tgl = $request->input('tgl');
            $klad->keterangan = $request->input('keterangan');
            $klad->pihak_terkait = $request->input('pihak_terkait');
            $klad->jenis = $jenisData;
            $klad->jenis_transaksi = $jenisTransaksi;
            $klad->id_kode_bukti = $idKodeBukti;
            $klad->id_kode_perkiraan_kas_bank = $idKodePerkiraanKasBank;
            $klad->id_rekening_bank = $jenisData === 'bank' ? $request->input('id_rekening_bank') : null;
            $klad->id_proyek = $proyekSection['id_proyek'] ?? $klad->id_proyek;

            // Regenerate no_bukti
            $klad->no_bukti = str_pad($klad->no_urut_bukti, 4, '0', STR_PAD_LEFT) . '/' . $kodeBukti->kode . '/' . $month . '/' . $year;

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
            $this->saveDetailEntries($klad, $isPengeluaran, $details, $proyekSection, $idKodePerkiraanKasBank);

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

        // Pengeluaran: Debet=0, Kredit=total. Penerimaan: Debet=total, Kredit=0
        $totalNominal = $klad->details->where('kategori', '!=', 'kas_bank')->sum('jumlah');
        $jum_D = $klad->jenis_transaksi == 'penerimaan' ? $totalNominal : 0;
        $jum_K = $klad->jenis_transaksi == 'pengeluaran' ? $totalNominal : 0;

        return view('kladKasBank.voucherPrint', compact('klad', 'jum_D', 'jum_K'));
    }

    /**
     * Export voucher to PDF
     */
    public function exportVoucherPdf($id)
    {
        $klad = KladKasBank::with(['details.kodePerkiraan', 'kodebukti', 'cabang', 'proyek', 'rekeningBank'])->findOrFail($id);

        // Pengeluaran: Debet=0, Kredit=total. Penerimaan: Debet=total, Kredit=0
        $totalNominal = $klad->details->where('kategori', '!=', 'kas_bank')->sum('jumlah');
        $jum_D = $klad->jenis_transaksi == 'penerimaan' ? $totalNominal : 0;
        $jum_K = $klad->jenis_transaksi == 'pengeluaran' ? $totalNominal : 0;

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

<?php

namespace App\Http\Controllers;

use App\Models\Pejabat;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PejabatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pejabats = Pejabat::orderBy('created_at', 'desc')->get();

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('transaksi.pejabat', compact('pejabats'));
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
            'nama' => 'required',
            'jabatan' => 'required',
            'is_active' => 'required',
            'is_ttd_laporan_neraca' => 'required',
            'is_ttd_laporan_labarugi' => 'required'
        ]);

        $pejabat = Pejabat::create([
            'nama' => $request['nama'],
            'jabatan' => $request['jabatan'],
            'is_active' => $request['is_active'],
            'is_ttd_laporan_neraca' => $request['is_ttd_laporan_neraca'],
            'is_ttd_laporan_labarugi' => $request['is_ttd_laporan_labarugi'],
        ]);

        // $qrCodePath = 'qrcodes/' . $pejabat->id . '.png';
        // $fullPath = storage_path('app/public/' . $qrCodePath);

        // // Cek apakah folder qrcodes sudah ada, jika belum buat folder tersebut
        // if (!file_exists(dirname($fullPath))) {
        //     mkdir(dirname($fullPath), 0755, true);
        // }

        // $content = 'Disahkan oleh: ' . $pejabat->nama . ' (' . $pejabat->jabatan . ')';

        // // $qrCode = QrCode::size(100)->generate('test penandatangan');
        // QrCode::format('png')->size(200)->generate($content);

        // $pejabat->update(['qr_code_path' => $qrCodePath]);

        Alert::success('Berhasil', 'Data Pejabat berhasil disimpan');
        return redirect()->route('pejabat.index');
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
        $pejabat = Pejabat::findOrFail($id);

        return view('transaksi.pejabatedit', compact('pejabat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $pejabat = Pejabat::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'is_active' => 'required',
            'is_ttd_laporan_neraca' => 'required',
            'is_ttd_laporan_labarugi' => 'required'
        ]);

        $pejabat->nama = $request->nama;
        $pejabat->jabatan = $request->jabatan;
        $pejabat->is_active = $request->is_active;
        $pejabat->is_ttd_laporan_neraca = $request->is_ttd_laporan_neraca;
        $pejabat->is_ttd_laporan_labarugi = $request->is_ttd_laporan_labarugi;

        $pejabat->save();

        Alert::success('Berhasil', 'Data pejabat berhasil diupdate');
        return redirect()->route('pejabat.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pejabat = Pejabat::findOrFail($id);

        $pejabat->delete();
        Alert::success('Berhasil', 'Data pejabat berhasil dihapus');
        return redirect()->route('pejabat.index');
    }

    public function addModal()
    {
        return view('modal.addPejabat', [
            'title' => 'Tambah Data Pejabat'
        ]);
    }
}

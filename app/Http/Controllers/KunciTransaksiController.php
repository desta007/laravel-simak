<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\KunciTransaksi;
use App\Models\Proyek;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KunciTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kunciTransaksis = KunciTransaksi::orderBy('id_cabang')->orderBy('id_proyek')->orderBy('tahun')->orderBy('bulan')->get();

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('transaksi.kunciTransaksi', compact('kunciTransaksis'));
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
            'id_cabang' => 'required',
            'id_proyek' => '',
            'bulan' => 'required',
            'tahun' => 'required',
            'status_akses' => 'required'
        ]);

        try {
            KunciTransaksi::create($validatedData);
            Alert::success('Berhasil', 'Data Kunci Transaksi berhasil disimpan');
            return redirect()->route('kunciTransaksi.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data Kunci Transaksi gagal disimpan, silahkan periksa kembali inputan anda');
            return redirect()->route('kunciTransaksi.index');
        }
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
        $kunciTransaksi = KunciTransaksi::findOrFail($id);
        $cabangs = Cabang::all();

        $proyeks = Proyek::where('id_cabang', '=', $kunciTransaksi->id_cabang)->get();

        return view('transaksi.kunciTransaksiedit', compact('kunciTransaksi', 'cabangs', 'proyeks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kunciTransaksi = KunciTransaksi::findOrFail($id);

        $kunciTransaksi->bulan = $request->bulan;
        $kunciTransaksi->tahun = $request->tahun;
        $kunciTransaksi->status_akses = $request->status_akses;
        $kunciTransaksi->save();

        Alert::success('Berhasil', 'Data Kunci Transaksi berhasil diupdate');
        return redirect()->route('kunciTransaksi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kunciTransaksi = KunciTransaksi::findOrFail($id);

        $kunciTransaksi->delete();
        Alert::success('Berhasil', 'Data penguncian transaksi berhasil dihapus');
        return redirect()->route('kunciTransaksi.index');
    }

    public function addModal()
    {
        // $proyeks = Proyek::all();
        $cabangs = Cabang::all();

        return view('modal.addKunciTransaksi', [
            'title' => 'Tambah Data Penguncian Transaksi',
            'cabangs' => $cabangs
        ]);
    }
}

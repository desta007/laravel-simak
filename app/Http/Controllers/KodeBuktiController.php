<?php

namespace App\Http\Controllers;

use App\Models\KodeBukti;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KodeBuktiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kodeBuktis = KodeBukti::orderBy('created_at', 'desc')->get();

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('master.kodeBukti', compact('kodeBuktis'));
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
            'kode' => 'required|string',
            'nama' => 'required|string',
            'keterangan' => '',
        ]);

        // $data = $request->all();
        // Cabang::create($data);
        try {
            KodeBukti::create($validatedData);
            Alert::success('Berhasil', 'Kode Bukti berhasil disimpan');
            return redirect()->route('kodeBukti.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Kode Bukti gagal disimpan, silahkan periksa kembali inputan anda');
            return redirect()->route('kodeBukti.index');
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
        $kodeBukti = KodeBukti::findOrFail($id);
        return view('master.kodeBuktiedit', compact('kodeBukti'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kodeBukti = KodeBukti::findOrFail($id);

        $validatedData = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'keterangan' => '',
        ]);

        $kodeBukti->update($validatedData);

        Alert::success('Berhasil', 'Kode Bukti berhasil diupdate');
        return redirect()->route('kodeBukti.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kodeBukti = KodeBukti::findOrFail($id);
        $kodeBukti->delete();
        Alert::success('Berhasil', 'Kode Bukti berhasil dihapus');
        return redirect()->route('kodeBukti.index');
    }

    public function addModal()
    {
        return view('modal.addKodeBukti', [
            'title' => 'Tambah Data Kode Bukti'
        ]);
    }
}

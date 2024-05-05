<?php

namespace App\Http\Controllers;

use App\Models\CatatanMutu;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class CatatanMutuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catatanMutus = CatatanMutu::orderBy('created_at', 'desc')->get();

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('transaksi.catatanMutu', compact('catatanMutus'));
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
            'no_dokumen' => 'required',
            'nama_dokumen' => 'required',
            'file_dokumen' => 'required|mimes:png,jpg,jpeg,pdf|max:10000',
            'id_proyek' => 'required'
        ]);

        $extension = $request->file('file_dokumen')->getClientOriginalExtension();

        $fileName = 'CatMutu_' . date("Ymd") . '_' . time() . '.' . $extension;
        $request->file('file_dokumen')->storeAs('transaksis', $fileName);

        CatatanMutu::create([
            'no_dokumen' => $request['no_dokumen'],
            'nama_dokumen' => $request['nama_dokumen'],
            'tipe_dokumen' => $request['tipe_dokumen'],
            'id_proyek' => $request['id_proyek'],
            'file_dokumen' => $fileName
        ]);

        Alert::success('Berhasil', 'Catatan Mutu berhasil disimpan');
        return redirect()->route('catatanMutu.index');
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
        $catatanMutu = CatatanMutu::findOrFail($id);
        $proyeks = Proyek::all();

        return view('transaksi.catatanMutuedit', compact('catatanMutu', 'proyeks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $catatanMutu = CatatanMutu::findOrFail($id);

        $request->validate([
            'no_dokumen' => 'required',
            'nama_dokumen' => 'required',
            'id_proyek' => 'required'
        ]);

        $catatanMutu->no_dokumen = $request->no_dokumen;
        $catatanMutu->nama_dokumen = $request->nama_dokumen;
        $catatanMutu->id_proyek = $request->id_proyek;

        if ($request->file_dokumen != '') {
            $oldDok = $catatanMutu->file_dokumen;
            if ($oldDok != '') {
                Storage::delete('transaksis/' . $oldDok);
            }

            $extension = $request->file('file_dokumen')->getClientOriginalExtension();

            $fileName = 'CatMutu_' . date("Ymd") . '_' . time() . '.' . $extension;
            $request->file('file_dokumen')->storeAs('transaksis', $fileName);

            $catatanMutu->file_dokumen = $fileName;
        }

        $catatanMutu->save();

        Alert::success('Berhasil', 'Catatan Mutu berhasil diupdate');
        return redirect()->route('catatanMutu.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $catatanMutu = CatatanMutu::findOrFail($id);

        if ($catatanMutu->file_dokumen != '')
            Storage::delete('transaksis/' . $catatanMutu->file_dokumen);

        $catatanMutu->delete();
        Alert::success('Berhasil', 'Catatan Mutu berhasil dihapus');
        return redirect()->route('catatanMutu.index');
    }

    public function addModal()
    {
        $proyeks = Proyek::all();

        return view('modal.addCatatanMutu', [
            'title' => 'Tambah Data Catatan Mutu',
            'proyeks' => $proyeks
        ]);
    }
}

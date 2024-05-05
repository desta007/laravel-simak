<?php

namespace App\Http\Controllers;

use App\Models\PedomanMutu;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PedomanMutuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedomanMutus = PedomanMutu::orderBy('created_at', 'desc')->get();

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('transaksi.pedomanMutu', compact('pedomanMutus'));
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
            'tipe_dokumen' => 'required'
        ]);

        $extension = $request->file('file_dokumen')->getClientOriginalExtension();

        $fileName = 'PedMutu_' . date("Ymd") . '_' . time() . '.' . $extension;
        $request->file('file_dokumen')->storeAs('transaksis', $fileName);

        $id_proyek = 0;
        if ($request->tipe_dokumen == 'Proyek')
            $id_proyek = $request['id_proyek'];

        PedomanMutu::create([
            'no_dokumen' => $request['no_dokumen'],
            'nama_dokumen' => $request['nama_dokumen'],
            'tipe_dokumen' => $request['tipe_dokumen'],
            'id_proyek' => $id_proyek,
            'file_dokumen' => $fileName
        ]);

        Alert::success('Berhasil', 'Pedoman Mutu berhasil disimpan');
        return redirect()->route('pedomanMutu.index');
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
        $pedomanMutu = PedomanMutu::findOrFail($id);
        $proyeks = Proyek::all();

        return view('transaksi.pedomanMutuedit', compact('pedomanMutu', 'proyeks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pedomanMutu = PedomanMutu::findOrFail($id);

        $request->validate([
            'no_dokumen' => 'required',
            'nama_dokumen' => 'required',
            'tipe_dokumen' => 'required'
        ]);

        $pedomanMutu->no_dokumen = $request->no_dokumen;
        $pedomanMutu->nama_dokumen = $request->nama_dokumen;
        $pedomanMutu->tipe_dokumen = $request->tipe_dokumen;

        $id_proyek = 0;
        if ($request->tipe_dokumen == 'Proyek')
            $id_proyek = $request->id_proyek;

        $pedomanMutu->id_proyek = $id_proyek;

        if ($request->file_dokumen != '') {
            $oldDok = $pedomanMutu->file_dokumen;
            if ($oldDok != '') {
                Storage::delete('transaksis/' . $oldDok);
            }

            $extension = $request->file('file_dokumen')->getClientOriginalExtension();

            $fileName = 'PedMutu_' . date("Ymd") . '_' . time() . '.' . $extension;
            $request->file('file_dokumen')->storeAs('transaksis', $fileName);

            $pedomanMutu->file_dokumen = $fileName;
        }

        $pedomanMutu->save();

        Alert::success('Berhasil', 'Pedoman Mutu berhasil diupdate');
        return redirect()->route('pedomanMutu.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pedomanMutu = PedomanMutu::findOrFail($id);

        if ($pedomanMutu->file_dokumen != '')
            Storage::delete('transaksis/' . $pedomanMutu->file_dokumen);

        $pedomanMutu->delete();
        Alert::success('Berhasil', 'Pedoman Mutu berhasil dihapus');
        return redirect()->route('pedomanMutu.index');
    }

    public function addModal()
    {
        $proyeks = Proyek::all();

        return view('modal.addPedomanMutu', [
            'title' => 'Tambah Data Pedoman Mutu',
            'proyeks' => $proyeks
        ]);
    }
}

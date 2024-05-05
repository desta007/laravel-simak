<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CabangController extends Controller
{
    public function index(Request $request)
    {
        //$searchTerm = $request->input('name');

        $cabangs = Cabang::orderBy('created_at', 'desc')->get();
        // $cabangs = Cabang::where('nama', 'like', '%' . $request->input('name') . '%')
        //     ->orderBy('created_at', 'desc')->get();
        //$products->sortByDesc('created_at');

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('master.cabang', compact('cabangs')); // 'searchTerm'
    }

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
            Cabang::create($validatedData);
            Alert::success('Berhasil', 'Cabang berhasil disimpan');
            return redirect()->route('cabang.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Cabang gagal disimpan, silahkan periksa kembali inputan anda');
            return redirect()->route('cabang.index');
        }
    }

    public function edit($id)
    {
        $cabang = Cabang::findOrFail($id);
        return view('master.cabangedit', compact('cabang'));
    }

    public function update(Request $request, $id)
    {
        //$data = $request->all();

        $cabang = Cabang::findOrFail($id);

        $validatedData = $request->validate([
            'kode' => 'required|string',
            'nama' => 'required|string',
            'keterangan' => '',
        ]);

        $cabang->update($validatedData);

        Alert::success('Berhasil', 'Cabang berhasil diupdate');
        return redirect()->route('cabang.index');

        //return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
        $cabang = Cabang::findOrFail($id);
        $cabang->delete();
        Alert::success('Berhasil', 'Cabang berhasil dihapus');
        return redirect()->route('cabang.index');
    }

    public function addModal()
    {
        return view('modal.addCabang', [
            'title' => 'Tambah Data Cabang'
        ]);
    }
}

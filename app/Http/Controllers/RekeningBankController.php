<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\RekeningBank;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RekeningBankController extends Controller
{
    public function index()
    {
        $id_group_user = auth()->user()->id_group_user;
        $id_cabang = auth()->user()->id_cabang;

        if ($id_group_user == 1) {
            $rekeningBanks = RekeningBank::with('cabang')->orderBy('created_at', 'desc')->get();
            $cabangs = Cabang::all();
        } else {
            $rekeningBanks = RekeningBank::with('cabang')
                ->where('id_cabang', $id_cabang)
                ->orderBy('created_at', 'desc')->get();
            $cabangs = Cabang::where('id', $id_cabang)->get();
        }

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('rekeningBank.index', compact('rekeningBanks', 'cabangs', 'id_group_user'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_cabang' => 'required',
            'nama_bank' => 'required|string',
            'kode_bank' => 'required|string',
            'jenis_rekening' => 'required|in:induk,operasional',
            'nomor_rekening' => 'required|string',
            'nama_rekening' => 'required|string',
            'cabang_bank' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $validatedData['is_active'] = true;
            RekeningBank::create($validatedData);
            Alert::success('Berhasil', 'Rekening Bank berhasil disimpan');
            return redirect()->route('rekeningBank.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Rekening Bank gagal disimpan');
            return redirect()->route('rekeningBank.index');
        }
    }

    public function edit($id)
    {
        $rekeningBank = RekeningBank::findOrFail($id);

        $id_group_user = auth()->user()->id_group_user;
        if ($id_group_user == 1) {
            $cabangs = Cabang::all();
        } else {
            $cabangs = Cabang::where('id', auth()->user()->id_cabang)->get();
        }

        return view('rekeningBank.edit', compact('rekeningBank', 'cabangs'));
    }

    public function update(Request $request, $id)
    {
        $rekeningBank = RekeningBank::findOrFail($id);

        $validatedData = $request->validate([
            'id_cabang' => 'required',
            'nama_bank' => 'required|string',
            'kode_bank' => 'required|string',
            'jenis_rekening' => 'required|in:induk,operasional',
            'nomor_rekening' => 'required|string',
            'nama_rekening' => 'required|string',
            'cabang_bank' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'is_active' => 'nullable',
        ]);

        $validatedData['is_active'] = $request->has('is_active') ? true : false;

        $rekeningBank->update($validatedData);

        Alert::success('Berhasil', 'Rekening Bank berhasil diupdate');
        return redirect()->route('rekeningBank.index');
    }

    public function destroy($id)
    {
        $rekeningBank = RekeningBank::findOrFail($id);
        $rekeningBank->delete();
        Alert::success('Berhasil', 'Rekening Bank berhasil dihapus');
        return redirect()->route('rekeningBank.index');
    }

    public function addModal()
    {
        $id_group_user = auth()->user()->id_group_user;
        if ($id_group_user == 1) {
            $cabangs = Cabang::all();
        } else {
            $cabangs = Cabang::where('id', auth()->user()->id_cabang)->get();
        }

        return view('modal.addRekeningBank', [
            'title' => 'Tambah Rekening Bank',
            'cabangs' => $cabangs,
        ]);
    }
}

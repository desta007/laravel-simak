<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Proyek;
use App\Models\UserProyek;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id_group_user = auth()->user()->id_group_user;

        if ($id_group_user == 1) {
            //$proyeks = Proyek::where('nama', 'like', '%' . $request->input('name') . '%')
            $proyeks = Proyek::orderBy('created_at', 'desc')->get();
        } else {
            if ($id_group_user == 2) {
                $id_cabang = auth()->user()->id_cabang;
                $proyeks = Proyek::where('id_cabang', '=', $id_cabang)
                    ->orderBy('created_at', 'desc')->get();
            } else if ($id_group_user == 3) {
                $id_user = auth()->user()->id;

                $proyeks = Proyek::select('proyeks.*')
                    ->join('user_proyeks', 'proyeks.id', '=', 'user_proyeks.id_proyek')
                    ->where('user_proyeks.id_user', $id_user)
                    ->orderBy('proyeks.created_at', 'desc')->get();
            }
        }

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('master.proyek', compact('proyeks'));
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
            'nama' => 'required',
            'nomor_wo' => 'required',
            'keterangan' => '',
        ]);

        try {
            Proyek::create($validatedData);
            Alert::success('Berhasil', 'Proyek berhasil disimpan');
            return redirect()->route('proyek.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Proyek gagal disimpan, silahkan periksa kembali inputan anda');
            return redirect()->route('proyek.index');
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
    public function edit(string $id)
    {
        $proyek = Proyek::findOrFail($id);
        $cabangs = Cabang::all();
        return view('master.proyekedit', compact('proyek', 'cabangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $proyek = Proyek::findOrFail($id);

        $validatedData = $request->validate([
            'id_cabang' => 'required',
            'nama' => 'required',
            'nomor_wo' => 'required',
            'keterangan' => '',
        ]);

        $proyek->update($validatedData);

        Alert::success('Berhasil', 'Proyek berhasil diupdate');
        return redirect()->route('proyek.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proyek = Proyek::findOrFail($id);
        $proyek->delete();
        Alert::success('Berhasil', 'Proyek berhasil dihapus');
        return redirect()->route('proyek.index');
    }

    public function addModal()
    {
        $cabangs = Cabang::all();
        return view('modal.addProyek', [
            'title' => 'Tambah Data Proyek',
            'cabangs' => $cabangs
        ]);
    }
}

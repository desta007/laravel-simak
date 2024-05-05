<?php

namespace App\Http\Controllers;

use App\Models\GroupAccount;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GroupAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupAccounts = GroupAccount::orderBy('created_at', 'desc')->get();

        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('master.groupAccount', compact('groupAccounts'));
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
            'jenis' => 'required',
        ]);

        try {
            GroupAccount::create($validatedData);
            Alert::success('Berhasil', 'Group Account berhasil disimpan');
            return redirect()->route('groupAccount.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Group Account gagal disimpan, silahkan periksa kembali inputan anda');
            return redirect()->route('groupAccount.index');
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
        $groupAccount = GroupAccount::findOrFail($id);
        return view('master.groupAccountedit', compact('groupAccount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $groupAccount = GroupAccount::findOrFail($id);

        $validatedData = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'jenis' => 'required',
        ]);

        $groupAccount->update($validatedData);

        Alert::success('Berhasil', 'Group Account berhasil diupdate');
        return redirect()->route('groupAccount.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $groupAccount = GroupAccount::findOrFail($id);
        $groupAccount->delete();
        Alert::success('Berhasil', 'Group Account berhasil dihapus');
        return redirect()->route('groupAccount.index');
    }

    public function addModal()
    {
        return view('modal.addGroupAccount', [
            'title' => 'Tambah Data Group Account'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\GroupUser;
use App\Models\Proyek;
use App\Models\User;
use App\Models\UserProyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // cara biasa ga pake server side datatable
    public function index()
    {
        //$users = User::orderBy('created_at', 'desc')->get();
        DB::statement("SET SQL_MODE=''");
        $users = User::select('users.*')
            ->selectRaw('IF(COUNT(user_proyeks.id_proyek) > 0, true, false) as has_proyek')
            ->leftJoin('user_proyeks', 'users.id', '=', 'user_proyeks.id_user')
            ->groupBy('users.id')
            ->orderBy('users.created_at', 'desc')->get();


        // $users = User::select('users.*')
        //             ->selectRaw('IF(COUNT(user_proyeks.id_proyek) > 0, true, false) as has_proyek')
        //             ->leftJoin('user_proyeks', 'users.id', '=', 'user_proyeks.user_id')
        //             ->groupBy('users.id')
        //             ->get();


        // User::select('users.*')
        //                 ->leftJoin('user_proyeks', 'users.id', '=', 'user_proyeks.user_id')
        //                 ->where('users.id', $userId)
        //                 ->distinct()
        //                 ->pluck('user_proyeks.id_proyek')
        //                 ->toArray();


        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('master.user', compact('users'));
    }

    // pake yajra. ditunda dulu. nanti dipikirin
    /*public function index()
    {
        $users = User::select('users.*')
            ->selectRaw('IF(COUNT(user_proyeks.id_proyek) > 0, true, false) as has_proyek')
            ->leftJoin('user_proyeks', 'users.id', '=', 'user_proyeks.id_user')
            ->groupBy('users.id')
            ->orderBy('users.created_at', 'desc')->get();

        return DataTables::of($users)
            ->addIndexColumn()

            ->addColumn('cabang', function ($user) {
                return $user->name . ' (' . $user->groupuser->nama . ')';
            })

            ->addColumn('has_proyek', function ($user) {
                if ($user->has_proyek) {
                    return '<button type="button" class="btn btn-sm btn-warning"
                    onclick="openDetailProyek(' . $user->id . ')">Detail</button>';
                } else
                    return '-';
            })

            ->addColumn('foto', function ($user) {
                if ($user->photo) {
                    $imageUrl = asset('storage/users/' . $user->photo);
                    $image = '<img src="' . $imageUrl . '" alt=""
                            width="100px" height="100px">';
                } else {
                    $imageUrl = asset('adminlte/images/user.png');
                    $image = '<img src="' . $imageUrl . '" alt=""
                            width="100px" height="100px">';
                }
                return $image;
            })

            ->addColumn('actions', function ($user) {
                $editUrl = route('user.edit', $user->id);
                $deleteUrl = route('user.destroy', $user->id);

                return '<div class="d-flex justify-content-center">
                <a href="' . $editUrl . '" class="btn-sm btn-info btn">Edit</a>
                &nbsp;
                <a href="' . $deleteUrl . '" class="btn btn-sm btn-danger" data-confirm-delete="true">Delete</a>
            </div>';
            })

            ->rawColumns(['cabang', 'has_proyek', 'foto', 'action'])
            ->make(true);


        $title = 'Delete Data!';
        $text = "Apakah anda yakin akan menghapus data?";
        confirmDelete($title, $text);

        return view('master.user_yajra');
    } */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cabangs = Cabang::all();
        $proyeks = Proyek::all();
        $groupusers = GroupUser::all();

        return view('master.useradd', [
            'title' => 'Tambah Data User',
            'cabangs' => $cabangs,
            'proyeks' => $proyeks,
            'groupusers' => $groupusers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'id_cabang' => '',
            // 'id_proyek' => '',
            'id_group_user' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => 'required',
            'phone' => 'required',
            // 'alamat' => '',
            'photo' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        if ($request['id_cabang'] == '' && ($request['id_group_user'] == 2 || $request['id_group_user'] == 3)) {
            Alert::error('Input Error', 'Cabang harus dipilih untuk group user cabang/proyek');
            return redirect()->route('user.create');
        }

        $list_proyek = $request['id_proyek'];
        if (!is_array($list_proyek) && $request['id_group_user'] == 3) {
            Alert::error('Input Error', 'Proyek harus dipilih untuk group user proyek');
            return redirect()->route('user.create');
        }

        try {
            //$request['password'] = Hash::make($request['password']);
            $extension = $request->file('photo')->getClientOriginalExtension();

            $fileName = date("Ymd") . '_' . time() . '.' . $extension;
            $request->file('photo')->storeAs('users', $fileName);

            //User::create($validatedData);
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'id_group_user' => $request['id_group_user'],
                'id_cabang' => $request['id_cabang'],
                'phone' => $request['phone'],
                'alamat' => $request['alamat'],
                'photo' => $fileName,
            ]);

            // save list proyek ke tabel user_proyeks
            $id_user = $user->id;

            // pindah keatas
            //$list_proyek = $request['id_proyek'];

            if (is_array($list_proyek) && $request['id_group_user'] == 3) {
                foreach ($list_proyek as $proyek) {
                    UserProyek::create([
                        'id_user' => $id_user,
                        'id_proyek' => $proyek
                    ]);
                }
            }

            // ga jadi dipake. ini kalo pake foreign key
            //$user->proyek()->sync($request['id_proyek']);

            Alert::success('Berhasil', 'User berhasil disimpan');
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'User gagal disimpan, silahkan periksa kembali inputan anda');
            return redirect()->route('user.index');
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
        $cabangs = Cabang::all();
        $groupusers = GroupUser::all();
        $userproyeks = UserProyek::where('id_user', '=', $id)->pluck('id_proyek');
        $user = User::findOrFail($id);

        $proyeks = Proyek::where('id_cabang', '=', $user->id_cabang)->get();

        return view('master.useredit', compact('user', 'cabangs', 'proyeks', 'groupusers', 'userproyeks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'id_group_user' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'phone' => 'required',
            //'photo' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        if ($request['id_cabang'] == '' && ($request['id_group_user'] == 2 || $request['id_group_user'] == 3)) {
            Alert::error('Input Error', 'Cabang harus dipilih untuk group user cabang/proyek');
            return redirect()->route('user.edit', $id);
        }

        $list_proyek = $request['id_proyek'];
        if (!is_array($list_proyek) && $request['id_group_user'] == 3) {
            Alert::error('Input Error', 'Proyek harus dipilih untuk group user proyek');
            return redirect()->route('user.edit', $id);
        }

        $user->id_group_user = $request->id_group_user;
        $user->id_cabang = $request->id_cabang;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->alamat = $request->alamat;

        if ($request->photo != '') {
            $oldPhoto = $user->photo;
            if ($oldPhoto != '') {
                Storage::delete('users/' . $oldPhoto);
            }

            $extension = $request->file('photo')->getClientOriginalExtension();

            $fileName = date("Ymd") . '_' . time() . '.' . $extension;
            $request->file('photo')->storeAs('users', $fileName);

            $user->photo = $fileName;
        }

        $user->save();

        // save list proyek ke tabel user_proyeks
        UserProyek::where('id_user', $id)->delete();
        $list_proyek = $request->id_proyek;

        if (is_array($list_proyek) && $request->id_group_user == 3) {
            foreach ($list_proyek as $proyek) {
                UserProyek::create([
                    'id_user' => $id,
                    'id_proyek' => $proyek
                ]);
            }
        }

        Alert::success('Berhasil', 'User berhasil diupdate');
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->photo != '')
            Storage::delete('users/' . $user->photo);

        UserProyek::where('id_user', $id)->delete();
        $user->delete();
        Alert::success('Berhasil', 'User berhasil dihapus');
        return redirect()->route('user.index');
    }

    public function viewModalProyek(Request $request)
    {
        $id_user = $request->query('id');

        $userProyeks = User::select('users.name', 'users.email', 'proyeks.nama', 'proyeks.nomor_wo')
            ->join('user_proyeks', 'users.id', '=', 'user_proyeks.id_user')
            ->join('proyeks', 'user_proyeks.id_proyek', '=', 'proyeks.id')
            ->where('users.id', '=', $id_user)
            ->get();
        //->orderBy('users.created_at', 'desc')->get();
        return view('modal.viewProyekByUser', [
            'title' => 'Detail Proyek',
            'userProyeks' => $userProyeks
        ]);
    }

    public function listCabang(Request $request)
    {
        $id_group_user = $request->input('id_group_user');

        $values = [];
        if ($id_group_user != 1) {
            $listCabangs = Cabang::all();
            foreach ($listCabangs as $option) {
                $values[$option->id] = $option->nama;
            }
        }

        return $values;
    }

    public function viewModalResetPwd(Request $request)
    {
        $id_user = $request->query('id');

        $user = User::findOrFail($id_user);
        return view('modal.viewResetPwd', [
            'title' => 'Reset Password',
            'user' => $user
        ]);
    }

    public function updatePass(Request $request)
    {
        $user = User::findOrFail($request['id_user']);
        $pass = Hash::make($request['password']);

        $user->password = $pass;
        $user->save();

        Alert::success('Berhasil', 'Password berhasil diupdate');
        return redirect()->route('user.index');
    }
}

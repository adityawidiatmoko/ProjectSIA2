<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=\App\User::All(); // ambil semua data table user
        return view('admin.user', ['user'=>$user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $save_user=new \App\User;
        $save_user->name=$request->get('username');
        $save_user->email=$request->get('email');
        $save_user->password=bcrypt('password');
        // memberi hak akses role
        if ($request->get('roles')=='ADMIN') {
            $save_user->assignRole('admin');
        } else {
            $save_user->assignRole('user');
        }
        $save_user->save();
        Alert::success('Tersimpan', 'Data berhasil disimpan'); // alert
        return redirect()->route('user.index');// kembali ke url user
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id); // ambil data user berdasarkan id
        $roles = Role::pluck('name')->all(); // ambil semua data name role
        $userRole = $user->roles->pluck('name')->all(); //ambil data nama role user tsb
        return view('admin.editUser', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id); // ambil data berdasarkan id
        DB::table('model_has_roles')->where('model_id', $id)->delete(); // hapus role user tsb
        $user->assignRole($request->input('role')); // memberi role terbaru
        Alert::success('Update', 'Data Berhasil di update'); //alert
        return redirect()->route('user.index'); // kembali ke url user
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hapus=\App\user::findOrFail($id);
        $hapus->delete(); // hapus data user berdarkan id
        $hapus->removeRole('admin', 'user');
        Alert::success('Terhapus', 'Data berhasil dihapus'); // alert
        return redirect()->route('user.index'); // kembali ke url user
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $akun=\App\Akun::All(); // ambil semua data table akun
        return view('admin.akun.akun', ['akun'=>$akun]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.akun.input');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //untuk menyimpan data
        $tambah_akun=new \App\Akun;
        $tambah_akun->no_akun = $request->addnoakun;
        $tambah_akun->nm_akun = $request->addnmakun;
        $tambah_akun->save(); // method
        Alert::success('Pesan ', 'Data berhasil disimpan'); //anak dari alert //success atau gagal disebut polymorpy
        return redirect('/akun'); // prosedur-> kembali ke url /akun
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
        $akun=\App\Akun::Find($id); // ambil data akun berdasarkan paramater id
        return view('admin.akun.edit', compact('akun'));
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
        $update_akun = \App\akun::findOrFail($id); // ambil data akun berdasarkan paramater id
        $update_akun->no_akun=$request->addnoakun;
        $update_akun->nm_akun=$request->addnmakun;
        $update_akun->save();
        Alert::success('Update', 'Data Berhasil di update'); // Alert
        return redirect()->route('akun.index'); // kembali ke url akun
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_akun)
    {
        $akun=\App\Akun::findOrFail($no_akun); // ambil data berdasarkan id
        $akun->delete();
        Alert::success('Pesan ', 'Data berhasil dihapus'); // Alert
        return redirect()->route('akun.index'); // kembali ke url akun
    }
}

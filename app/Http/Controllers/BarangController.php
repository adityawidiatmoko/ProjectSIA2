<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang=\App\Barang::All();
        return view('admin.barang.barang', ['barang'=>$barang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.barang.input');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tambah_barang=new \App\Barang;
        $tambah_barang->kd_brg = $request->addkdbrg;
        $tambah_barang->nm_brg = $request->addnmbrg;
        $tambah_barang->harga = $request->addharga;
        $tambah_barang->stok = $request->addstok;
        $tambah_barang->save(); // simpan data ke table barang
        Alert::success('Pesan ', 'Data berhasil disimpan'); //alert
        return redirect('/barang'); //kembali ke url barang index
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
        $barang=\App\Barang::Find($id); // ambil data berdasarkan id
        return view('admin.barang.editBarang', compact('barang'));
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
        $data = array(
            'nm_brg'      => $request->addnmbrg,
            'harga'       => $request->addharga,
            'stok'        => $request->addstok
        );
        \App\Barang::where('kd_brg', $id)->update($data); // update data bersarkan kode barang
        Alert::success('Pesan ', 'Data berhasil diupdate'); // alert
        return redirect('/barang'); // kembali ke url barang
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kd_brg)
    {
        $barang=\App\Barang::findOrFail($kd_brg);
        $barang->delete(); // hapus data berdasarkan kd barang
        Alert::success('Pesan ', 'Data berhasil dihapus'); //alert
        return redirect()->route('barang.index'); // kembali ke url barang
    }
}

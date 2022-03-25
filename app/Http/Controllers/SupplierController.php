<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier=\App\Supplier::All(); // ambil semua data supplier
        return view('admin.supplier.supplier', ['supplier'=>$supplier]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supplier.input');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //simpan data ke table suppluer
        $tambah_supplier=new \App\Supplier;
        $tambah_supplier->kd_supp = $request->addkdsupp;
        $tambah_supplier->nm_supp = $request->addnmsupp;
        $tambah_supplier->alamat = $request->addalmsupp;
        $tambah_supplier->telepon = $request->addtlpsupp;
        $tambah_supplier->save();
        Alert::success('Pesan ', 'Data berhasil disimpan'); // alert
        return redirect('/supplier'); // kembali ke url supplier
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
        $supplier=\App\Supplier::Find($id); // ambil data berdasarkan id
        return view('admin.supplier.editsupplier', compact('supplier'));
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
        $data = array( // data Array
            'nm_supp'      => $request->addnmsupp,
            'alamat'       => $request->addalmsupp,
            'telepon'        => $request->addtlpsupp
        );
        \App\Supplier::where('kd_supp', $id)->update($data); // simpan data berdasarkan kode suplier
        Alert::success('Pesan ', 'Data berhasil diupdate'); // alert
        return redirect('/supplier'); // kembali ke url supplier
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kd_supp)
    {
        $supplier=\App\Supplier::findOrFail($kd_supp); // hapus data berdasarkan id
        $supplier->delete();
        Alert::success('Pesan ', 'Data berhasil dihapus'); // alert
        return redirect()->route('supplier.index');// kembali ke url supplier
    }
}

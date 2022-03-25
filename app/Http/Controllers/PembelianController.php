<?php

namespace App\Http\Controllers;

use App\Pembelian;
use App\Pemesanan;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pesan=\App\Pemesanan::All();
        //perintah SQL untuk menghilangkan data pembelian ketika sudah di beli
        $pesan = DB::select('SELECT * FROM pemesanan where not exists (select * from
        pembelian where pemesanan.no_pesan=pembelian.no_pesan)');
        return view('pembelian.pembelian', ['pemesanan'=>$pesan]);
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
        //
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
        $AWAL = 'FKT';
        $bulanRomawi = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX"
        ,"X", "XI","XII");
        $noUrutAkhir = \App\Pembelian::max('no_beli');
        $no = 1;
        $format=sprintf("%03s", abs((int)$noUrutAkhir + 1)). '/' . $AWAL .'/' . $bulanRomawi[date('n')] .'/' . date('Y');
        $AWALJurnal = 'JRU';
        $bulanRomawij = array("", "I","II","III", "IV", "V","VI","VII","VIII","IX
        ","X", "XI","XII");
        $noUrutAkhirj = \App\Jurnal::max('no_jurnal');
        $noj = 1;
        $formatj=sprintf("%03s", abs((int)$noUrutAkhirj + 1)). '/' . $AWALJurnal
        .'/' . $bulanRomawij[date('n')] .'/' . date('Y');
        $decrypted = Crypt::decryptString($id);
        $detail = DB::table('tampil_pemesanan')->where('no_pesan', $decrypted)->get();
        $pemesanan = DB::table('pemesanan')->where('no_pesan', $decrypted)->get();
        $akunkas = DB::table('setting')->where('nama_transaksi', 'Kas')->get();
        $akunpembelian = DB::table('setting')->where('nama_transaksi', 'Pembelian')->get();
        return view('pembelian.beli', ['detail'=>$detail,'format'=>$format,'no_pesan'=>$decrypted,'pemesanan'=>$pemesanan,'formatj'=>$formatj,'kas'=>$akunkas,'pembelian'=>$akunpembelian]);
    }

    public function pdf($id)
    {
        $decrypted = Crypt::decryptString($id);
        $detail = DB::table('tampil_pemesanan')->where('no_pesan', $decrypted)->get();
        $supplier = DB::table('supplier')->get();
        $pemesanan = DB::table('pemesanan')->where('no_pesan', $decrypted)->get();
        $pdf = PDF::loadView('laporan.faktur', ['detail'=>$detail,'order'=>$pemesanan,'supp'=>$supplier,'noorder'=>$decrypted]);
        return $pdf->stream();
    }
        
    public function simpan(Request $request)
    {
        if (Pembelian::where('no_pesan', $request->no_pesan)->exists()) { // jika no_pesan sudah ada di table pembelian
            Alert::warning('Pesan ', 'Pembelian Telah dilakukan ');
            return redirect('pembelian');
        } else {// jika no_pesan belum ada di table pembelian
            //Simpan ke table pembelian
            $tambah_pembelian=new \App\Pembelian;
            $tambah_pembelian->no_beli = $request->no_faktur;
            $tambah_pembelian->tgl_beli = $request->tgl;
            $tambah_pembelian->no_faktur = $request->no_faktur;
            $tambah_pembelian->total_beli = $request->total;
            $tambah_pembelian->no_pesan = $request->no_pesan;
            $tambah_pembelian->save();
            //SIMPAN DATA KE TABEL DETAIL PEMBELIAN
            $kdbrg = $request->kd_brg;
            $qtybeli = $request->qty_beli;
            $subbeli = $request->sub_beli;
            foreach ($kdbrg as $key => $no) {
                $data[] = [
                    'no_beli' => $request->no_faktur,
                    'kd_brg' => $kdbrg[$key],
                    'qty_beli' => $qtybeli[$key],
                    'sub_beli' => $subbeli[$key]
                ];
                \App\DetailPembelian::insert($data);
            }
            //SIMPAN ke table jurnal bagian debet
            $tambah_jurnaldebet=new \App\Jurnal;
            $tambah_jurnaldebet->no_jurnal = $request->no_jurnal;
            $tambah_jurnaldebet->keterangan = 'Pembelian Barang ';
            $tambah_jurnaldebet->tgl_jurnal = $request->tgl;
            $tambah_jurnaldebet->no_akun = $request->pembelian;
            $tambah_jurnaldebet->debet = $request->total;
            $tambah_jurnaldebet->kredit = '0';
            $tambah_jurnaldebet->save();
            //SIMPAN ke table jurnal bagian kredit
            $tambah_jurnalkredit=new \App\Jurnal;
            $tambah_jurnalkredit->no_jurnal = $request->no_jurnal;
            $tambah_jurnalkredit->keterangan = 'Kas';
            $tambah_jurnalkredit->tgl_jurnal = $request->tgl;
            $tambah_jurnalkredit->no_akun = $request->akun;
            $tambah_jurnalkredit->debet ='0';
            $tambah_jurnalkredit->kredit = $request->total;
            $tambah_jurnalkredit->save();
            Alert::success('Pesan ', 'Data berhasil disimpan');
            return redirect('/pembelian');
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_pesan)
    {
        $decrypted = Crypt::decryptString($no_pesan);
        $pem=Pemesanan::findOrFail($decrypted);
        $pem->delete();
        Alert::success('Pesan ', 'Data berhasil dihapus');
        return redirect('/pembelian');
    }
}

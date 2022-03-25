<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.laporan');
    }
    public function show(Request $request)
    {
        $periode=$request->get('periode');
        if ($periode == 'All') { // jika laporan yg dipilih semua
            $bb = \App\Laporan::All();
            $akun=\App\Akun::All();
            $pdf = PDF::loadview('laporan.cetak', ['laporan'=>$bb,'akun' => $akun])->setPaper('A4', 'landscape');
            return $pdf->stream();
        } elseif ($periode == 'periode') { // jika laporan yg dipilih berdasarkan tanggal
            $tglawal=$request->get('tglawal');
            $tglakhir=$request->get('tglakhir');
            $akun=\App\Akun::All();
            $bb=DB::table('jurnal')
            ->whereBetween('tgl_jurnal', [$tglawal,$tglakhir])
            ->orderby('tgl_jurnal', 'ASC')
            ->get();
            $pdf = PDF::loadview('laporan.cetak', ['laporan'=>$bb,'akun' => $akun])->setPaper('A4', 'landscape');
            return $pdf->stream();
        }
    }
}

<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;

class PrintPDFController extends Controller
{
    public function cetak_slip_gaji($id){
        // return view('admin.print.template_print');
        $filename = 'SLIP GAJI.pdf';
        $pdf      = PDF::setOptions(['isHtml5ParserEnabled' => false, 'isRemoteEnabled' => true])
        ->setPaper('a6', 'portrait')->loadview('admin.print.print_gaji');
        return $pdf->stream();
    }
}

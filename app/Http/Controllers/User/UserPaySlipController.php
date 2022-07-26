<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\PayrollParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class UserPaySlipController extends Controller
{
    public function cetak_slipgaji_payroll($id)
    {
        $data       = Payroll::findOrFail($id);
        $dataParent = PayrollParent::where('id', $data->id_payroll)->first();

        $path       = public_path('backend-assets/images/logo-sw-dark.png');
        $type       = pathinfo($path, PATHINFO_EXTENSION);
        $data_image = file_get_contents($path);
        $pic        = 'data:image/' . $type . ';base64,' . base64_encode($data_image);
        $filename   = 'SLIP GAJI.pdf';
        $pdf        = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                    ->setPaper('a5', 'landscape')
                    ->loadView('user.payslip.pdf.pdf_slipgaji', ['logo' => $pic, 'data' => $data, 'bulan' => $dataParent->pay_bulan, 'tahun' => $dataParent->pay_tahun]);
        return $pdf->stream($filename);
    }

    public function riwayat(Request $request)
    {
        $hari           = $request->hari;
        $temp           = explode("-", $hari);
        $tahun          = $temp[0];
        $bulan          = $temp[1];
        $id             = Auth::user()->id;
        $gaji           = Payroll::leftJoin('payroll_parents', 'payrolls.id_payroll', '=', 'payroll_parents.id')
                        ->where('payrolls.id_user', $id)
                        ->where('payroll_parents.pay_tahun', $tahun)
                        ->where('payroll_parents.pay_bulan', $bulan)
                        ->first();
        return view('user.payslip.data.view_data_riwayat', [
            'id'    => Auth::user(),
            'gaji'  => $gaji,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun  = date("Y");
        $bulan  = date("m");
        $id     = Auth::user()->id;
        $gaji   = DB::table('payrolls')
                    ->join('payroll_parents', 'payrolls.id_payroll', '=', 'payroll_parents.id')
                    ->where('payrolls.id_user', $id)
                    ->where('payroll_parents.pay_tahun', $tahun)
                    ->where('payroll_parents.pay_bulan', $bulan)
                    ->first();
        return view('user.payslip.index', [
            'id'      => Auth::user(),
            'gaji'  => $gaji,
        ]);
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
        //
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
    public function destroy($id)
    {
        //
    }
}

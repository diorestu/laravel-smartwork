<?php

namespace App\Http\Controllers;

use App\Models\CabangConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabangConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function storeConfigAbsensi(Request $request)
    {
        // dd($request->all());
        if ($request->is_radius || $request->is_radius == 'on') {
            $is_radius = true;
            $rad_max   = $request->radius_max;
        }else{
            $is_radius = false;
            $rad_max   = 0;
        }

        if ($request->has('is_photo_enabled')) {
            $isPhoto = true;
        }else{
            $isPhoto = false;
        }

        if ($request->has('is_using_shift')) {
            $isShift = true;
        }else{
            $isShift = false;
        }

        try {
            CabangConfig::updateOrCreate(
                ['id_admin'   => Auth::user()->id, 'id_cabang'  => $request->id_cabang],
                ['is_radius'  => $is_radius, 'is_photo_enabled' => $isPhoto, 'is_using_shift' => $isShift, 'radius_max' => $rad_max]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->back();
    }
    public function storeConfigPayroll(Request $request)
    {
        try {
            CabangConfig::updateOrCreate(
                ['id_admin'   => Auth::user()->id, 'id_cabang'  => $request->id_cabang],
                ['bank_type' => $request->bank_type, 'tgl_tutup' => $request->date_closed]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->back();
    }
    public function storeConfigKomponen(Request $request)
    {
        // dd($request->komponen);
        $komponen = $request->input('komponen');
        if ($komponen == '') {
            $datakomponen =  '';
        }else{
            $datakomponen = implode(',', $komponen);
        }
        // dd($komponen);
        try {
            CabangConfig::updateOrCreate(
                ['id_admin'   => Auth::user()->id, 'id_cabang'  => $request->id_cabang],
                ['komponen_gaji' => $datakomponen,]
            );
        } catch (\Throwable $th) {
            throw $th;
        }
        return redirect()->back();
    }
    public function storeConfigPph21(Request $request)
    {
        try {
            CabangConfig::updateOrCreate(
                ['id_admin'   => Auth::user()->id, 'id_cabang'  => $request->id_cabang],
                ['pph21' => $request->m_pajak]
            );
        } catch (\Throwable $th) {
            throw $th;
        }

        // dd($data);
        return redirect()->back();
    }
    
}

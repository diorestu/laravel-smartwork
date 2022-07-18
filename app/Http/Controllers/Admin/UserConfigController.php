<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\CabangConfig;
use App\Models\MethodPajak;
use Illuminate\Support\Facades\Auth;

class UserConfigController extends Controller
{
    public function uploadLogo(Request $request)
    {
        $folderPath     = storage_path('app/public/logo/');
        $image_parts    = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type     = $image_type_aux[1];
        $image_base64   = base64_decode($image_parts[1]);
        $imageName      = uniqid() . '.png';
        $imageFullPath  = $folderPath . $imageName;
        file_put_contents($imageFullPath, $image_base64);
        $id                         = $request->id;
        $data                       = UserConfig::findOrFail($id);
        $data->company_logo         = $imageName;
        $berhasil                   = $data->save();
        if ($berhasil) {
            return '<img src="' . asset("storage/logo/$imageName") . '" class="d-block w-100" />';
        } else {
            return "gagal";
        }
    }

    public function index()
    {
        $id_admin   = Auth::user()->id;
        $data       = UserConfig::where("id_admin", $id_admin)->first();
        $datacabang = Cabang::where("id_admin", $id_admin)->get();
        // dd($data);
        return view('admin.config', ['data' => $data, 'data_cabang' => $datacabang]);
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
     * @param  \App\Models\UserConfig  $userConfig
     * @return \Illuminate\Http\Response
     */
    public function show(Request $r, $cabang)
    {
        $id_admin = Auth::user()->id;
        $data     = Cabang::where('id', $cabang)->where('id_admin', $id_admin)->first();
        $detail   = CabangConfig::where('id_cabang', $cabang)->where('id_admin', $id_admin)->first();
        // dd($detail);
        return view('admin.config_cabang', ['data'=> $data, 'detail' => $detail]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserConfig  $userConfig
     * @return \Illuminate\Http\Response
     */
    public function edit(UserConfig $userConfig)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserConfig  $userConfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input                  = $request->all();
        $data                   = UserConfig::where('id_admin', $id)->first();
        $data->company_name     = $input['company_name'];
        $data->company_address  = $input['company_address'];
        $data->company_email    = $input['company_email'];
        $data->company_phone    = $input['company_phone'];
        $data->company_bidang   = $input['company_bidang'];
        $berhasilSimpan         = $data->save();
        if ($berhasilSimpan) { echo "ok"; } else { echo "gagal"; }
    }

    public function updateMPajak(Request $request, $id) {
        $bulan = date('m');
        $tahun = date('Y');
        // $cek   = MethodPajak::
    }

    public function updateLayout(Request $request, $id) {
        $mode               = $request->mode;
        $data               = UserConfig::where('id_admin', $id)->first();
        $data->layout_mode  = $mode;
        $berhasilSimpan     = $data->save();
        if ($berhasilSimpan) {
            echo "ok";
        }
        // echo $mode;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserConfig  $userConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserConfig $userConfig)
    {
        //
    }
}

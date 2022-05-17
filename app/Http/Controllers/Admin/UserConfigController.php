<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Illuminate\Support\Facades\Auth;

class UserConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_admin   = Auth::user()->id;
        $data       = UserConfig::where("id_admin", $id_admin)->first();
        $datacabang = Cabang::where("id_admin", $id_admin)->get();
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
    public function show(Request $r, $userConfig)
    {
        return view('admin.config_cabang');
        // $input = $r->all();
        // $result = UserConfig::findOrFail($userConfig);
        // $result->layout_mode = $input['layout_mode'];
        // $result->nomor_surat = $input['nomor_surat'];
        // $result->save();
        // dd($result);
        // try {
        //     return redirect()->route('admin.home')->with('success', 'Berhasil Hapus Data');
        // } catch (\Throwable $th) {
        //     return redirect()->route('admin.home')->with('error', $th);
        // }
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

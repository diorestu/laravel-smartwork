<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\UserConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $data = User::find(Auth::user()->id);
        return view('admin.config', compact('data'));
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
        $data = UserConfig::where('id_admin', $id)->first();
        $input = $request->all();
        $data->is_first = $input['is_first'];
        $data->save();
        return redirect()->route('admin.home');
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

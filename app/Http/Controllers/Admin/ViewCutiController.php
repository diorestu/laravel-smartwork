<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ViewCutiController extends Controller
{
    public function accept($id){
        $result = Cuti::where('id_cuti', $id)->first();
        // dd($result);
        $result->cuti_status = 'DITERIMA';
        $result->save();
        try {
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Gagal! '. $th);
        }
    }

    public function decline($id){
        $result = Cuti::where('id_cuti', $id)->first();
        $result->cuti_status = 'DITOLAK';
        try {
            $result->save();
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Gagal! ' . $th);
        }
    }

    public function riwayat()
    {
        $id = Auth::user()->id;
        $user = User::where('id_admin', $id)->where('roles', 'user')->pluck('id')->toArray();
        $data = Cuti::whereIn('id_user', $user)->get();
        return view('admin.cuti.riwayat', [
            'data' => $data,
        ]);
    }

    public function index()
    {
        $id = Auth::user()->id;
        $user = User::where('id_admin', $id)->where('roles', 'user')->pluck('id')->toArray();
        $data = Cuti::whereIn('id_user', $user)->where('cuti_status', 'PENDING')->get();
        // dd($data);
        return view('admin.cuti.index', [
            'data' => $data,
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

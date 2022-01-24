<?php

namespace App\Http\Controllers;

use App\Models\UserShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function get_jadwal(Request $r){
        $id = Auth::user()->id;
        $input = $r->all();

        if($input['bulan']){
            $data = UserShift::select('users.nama', 'user_shifts.*', 'shifts.nama_shift')
                ->join('shifts', 'user_shifts.id_user_shift', '=', 'shifts.id')
                ->join('users', 'users.id', '=', 'user_shifts.id_user')
                ->where('users.id_admin', $id)
                ->whereMonth('tanggal_shift', $input['bulan'])->get();
            // dd($data);
            return view('admin.jadwal.hasil', ['data' => $data]);
        }else{
            // return view('admin.jadwal.index');
        }
    }

    public function index()
    {
        $id = Auth::user()->id;
        $data = UserShift::select('users.nama', 'user_shifts.*', 'shifts.nama_shift')
        ->join('shifts','user_shifts.id_user_shift', '=', 'shifts.id')
        ->join('users', 'users.id', '=', 'user_shifts.id_user')
        ->where('users.id_admin', $id)->get();
        // dd($data);
        return view('admin.jadwal.index', ['data' => $data]);
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
        $input = $request->all();
        dd($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserShift  $userShift
     * @return \Illuminate\Http\Response
     */
    public function show(UserShift $userShift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserShift  $userShift
     * @return \Illuminate\Http\Response
     */
    public function edit(UserShift $userShift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserShift  $userShift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserShift $userShift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserShift  $userShift
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserShift $userShift)
    {
        //
    }
}

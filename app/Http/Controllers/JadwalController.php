<?php

namespace App\Http\Controllers;

use App\Models\UserShift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function get_jadwal(Request $r){
        $input      = $r->all();
        $cabang     = $input['id_cabang'];
        $tahun      = $input['tahun'];
        $bulan      = $input['bulan'];
        return redirect()->route('jadwal.lihat', ['cb' => $cabang, 'bl' => $bulan, 'th' => $tahun]);
        // dd($d);
    }

    public function lihat_jadwal($cabang, $bulan, $tahun) {
        $id         = Auth::user()->id;
        if ($cabang != "all") {
            $data       = UserShift::select('users.nama', 'user_shifts.*', 'shifts.*', 'cabangs.cabang_nama')
                                    ->join('shifts',        'user_shifts.id_user_shift',    '=', 'shifts.id')
                                    ->join('users',         'users.id',                     '=', 'user_shifts.id_user')
                                    ->join('cabangs',       'cabangs.id',                   '=', 'users.id_cabang')
                                    ->where('users.id_admin', $id)
                                    ->where('users.id_cabang', $cabang)
                                    ->whereMonth('tanggal_shift', $bulan)
                                    ->whereYear('tanggal_shift', $tahun);
        }
        else {
            $data       = UserShift::select('users.nama', 'user_shifts.*', 'shifts.*', 'cabangs.cabang_nama')
                                    ->join('shifts',        'user_shifts.id_user_shift',    '=', 'shifts.id')
                                    ->join('users',         'users.id',                     '=', 'user_shifts.id_user')
                                    ->join('cabangs',       'cabangs.id',                   '=', 'users.id_cabang')
                                    ->where('users.id_admin', $id)
                                    ->whereMonth('tanggal_shift', $bulan)
                                    ->whereYear('tanggal_shift', $tahun);
        }
        return view('admin.jadwal.hasil', ['data' => $data->get(), 'cb' => $cabang, 'tahun' => $tahun, 'bulan' => $bulan]);
    }

    public function atur_jadwal($user, $bulan, $tahun) {
        $id         = Auth::user()->id;
        $data       = UserShift::select('users.nama', 'user_shifts.*', 'shifts.*', 'cabangs.cabang_nama')
                                    ->join('shifts',        'user_shifts.id_user_shift',    '=', 'shifts.id')
                                    ->join('users',         'users.id',                     '=', 'user_shifts.id_user')
                                    ->join('cabangs',       'cabangs.id',                   '=', 'users.id_cabang')
                                    ->where('users.id_admin', $id)
                                    ->where('id_user',      $user)
                                    ->whereMonth('tanggal_shift', $bulan)
                                    ->whereYear('tanggal_shift', $tahun)->get();

        $nama       = User::where('id', $user)->pluck('nama')->first();
        // dd($nama);
        // dd($data);
        return view('admin.jadwal.atur', ['data' => $data, 'user' => $user, 'nama' => $nama, 'tahun' => $tahun, 'bulan' => $bulan]);
    }

    public function impor() {
        //
    }

    public function simpan_jadwal($user, $shift, $tanggal)
    {
        $tambah_baru                        = new UserShift;
        $tambah_baru->id_user               = $user;
        $tambah_baru->id_user_shift         = $shift;
        $tambah_baru->tanggal_shift         = $tanggal;
        $tambah_baru->status_shift          = "active";
        $berhasilSimpan                     = $tambah_baru->save();
        if ($berhasilSimpan) {
            return "ok";
        } else {
            return "gagal";
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
        $input                              = $request->all();
        // $tambah_baru                        = new UserShift;
        // $tambah_baru->id_user               = $input['id_user'];
        // $tambah_baru->id_user_shift         = $input['id_user_shift'];
        // $tambah_baru->tanggal_shift         = $input['tanggal_shift'];
        // $tambah_baru->status_shift          = "active";
        return response()->json([
            'success' => $input,
        ]);
        // return response()->json();
        // dd($input);
        // $berhasilSimpan                     = $tambah_baru->save();
        // // dd($input);
        // if ($berhasilSimpan) {
        //     return "ok";
        // } else {
        //     return "gagal";
        // }

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
    public function destroy($id)
    {
        try {
            UserShift::findOrFail($id)->delete();
            return "ok";
        } catch (\Throwable $th) {
            return $th;
        }
    }
}

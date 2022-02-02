<?php

namespace App\Http\Controllers\User;

use App\Models\Cuti;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MobileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $i = Auth::user()->id;
        $id = User::with('cabang')->find($i);
        // dd($id);
        return view('user.profile', [
            'id' => $id,
        ]);
    }

    public function changePassword()
    {
        $i = Auth::user()->id;
        $id = User::with('cabang')->find($i);
        // dd($id);
        return view('user.ubah-pass', [
            'id' => $id,
        ]);
    }
    public function saveProfile(Request $r)
    {
        dd($r->all());
        $i = Auth::user()->id;

    }
    public function index()
    {
        $id = Auth::user()->id;
        // $absen = Absensi::where('id_user', $id)->orderBy('jam_hadir', 'DESC');
        // if($absen->pluck('id')->toArray() == []){
        //     $absen = 'Nihil';
        // }
        // // dd($absen->get());
        // $cuti = Cuti::where('id_user', $id)->where('cuti_status', 'DITERIMA')->sum('cuti_total');

        return view('user.home', [
            'id' => Auth::user(),
            // 'absen' => $absen->orderBy('jam_hadir','DESC')->first(),
            // 'cuti' => $cuti,
        ]);
    }
}

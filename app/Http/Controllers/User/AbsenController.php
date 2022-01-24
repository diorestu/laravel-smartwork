<?php

namespace App\Http\Controllers\User;

use App\Models\Cuti;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $absen = Absensi::whereDate('jam_hadir', date('Y-m-d'))->where('id_user', $id)->first();
        $absenLast = Absensi::where('id_user', $id)->orderBy('jam_hadir', 'DESC')->first();

        $riwayat = Absensi::where('id_user', $id)->orderBy('jam_hadir', 'DESC')->take(5)->get();
        $cuti = Cuti::where('id_user', $id)->sum('cuti_total');
        return view('user.absen.index',[
            'absen' => $absen,
            'riwayat' => $riwayat,
            'cuti' => $cuti,
            'terbaru' => $absenLast,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id=Auth::user()->id;
        $dataAbsen = Absensi::where('id_user', $id)->whereDate('jam_hadir', date('Y-m-d'))->first();
        if (!$dataAbsen || $dataAbsen == null) {
            return view('user.absen.hadir');
        }else{
            return redirect()->route('absen.index')->withErrors('Anda Sudah Absen Hari Ini');
        }
        // dd($dataAbsen);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $hadir = $r->all();
        $hadir['hadir'] = date("Y-m-d H:i:s");
        $response = Absensi::create([
            'id_user' => Auth::user()->id,
            'jam_hadir' => $hadir['hadir'],
            'lat_hadir' => $hadir['lat_hadir'],
            'long_hadir' => $hadir['long_hadir'],
            'ket_hadir' => $hadir['deskripsi'],
        ]);
        // dd($response);
        return redirect()->route('absen.index');
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
        $data = Absensi::findOrFail($id);
        // dd($data);
        return view('user.absen.pulang', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $absen           = $r->all();
        $absen['pulang'] = Carbon::parse(date("Y-m-d H:i:s"));
        $data            = Absensi::find($id);

        // Hitung Total Jam
        $mulai = Carbon::parse($data->jam_hadir);
        $selesai = $absen['pulang'];
        $jam_kerja = $selesai->diffInMinutes($mulai);
        $jk = round($jam_kerja / 60, 2);
        if($jk > 8){
            $jl = $jk - 8 ;
        }else{
            $jl = 0;
        }
        dd(round($jam_kerja/60, 2));
        // Ubah Data Absensi
        $data->jam_pulang  = $absen['pulang'];
        $data->lat_pulang  = $absen['lat_pulang'];
        $data->long_pulang = $absen['long_pulang'];
        $data->ket_pulang  = $absen['deskripsi'];
        $data->jam_kerja  = $jk;
        $data->jam_lembur  = $jl;
        $data->save();
        // dd($response);
        return redirect()->route('absen.index');
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

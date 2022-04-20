<?php

namespace App\Http\Controllers\User;

use App\Models\Cuti;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserShift;
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
        // Set Tanggal Hari Ini dan Kemarin
        $today     = Carbon::now();
        $yesterday = Carbon::yesterday();

        // Set Absensi Apakah Sudah Hadir;
        $in        = false;
        $out       = false;
        // Set Data User;
        $id        = Auth::user()->id;
        // Cek Shift
        $shift = UserShift::where('id_user', $id)->whereDate('tanggal_shift', $today)->first();
        // Cek Absensi Terakhir
        $absenHariIni = Absensi::where('id_user', $id)->whereDate('jam_hadir', $today)->first();
        $absenKemarin = Absensi::where('id_user', $id)->whereDate('jam_hadir', $yesterday)->whereNull('jam_pulang')->first();
        // dd($absenKemarin);
        $absen = '';
        // Set Riwayat Absensi
        $riwayat      = Absensi::where('id_user', $id)->orderBy('jam_hadir', 'DESC')->take(5)->get();
        // Set Utility
        $title        = null;
        $d            = false;
        if(!$shift){
            if ($absenKemarin) {
                $shift = UserShift::where('id_user', $id)->whereDate('tanggal_shift', $yesterday)->first();
                $absen = $absenKemarin;
                $in    = true;
                if ($absen->jam_pulang) {
                    $out = true;
                }
            }

            $title = 'Absen Tidak Tersedia';
            $d= true;
        }elseif ($shift->shift->ket_shift == 'Libur' || $shift->shift->hadir_shift == null) {
            $title = 'Tidak Ada Shift';
            $d = true;
        }else{
            if ($absenHariIni) {
                $shift = UserShift::where('id_user', $id)->whereDate('tanggal_shift', $today)->first();
                $absen = $absenHariIni;
                $in    = true;
                if ($absen->jam_pulang) {
                    $out = true;
                }
            } elseif ($absenKemarin) {
                $shift = UserShift::where('id_user', $id)->whereDate('tanggal_shift', $yesterday)->first();
                $absen = $absenKemarin;
                $in    = true;
                if ($absen->jam_pulang) {
                    $out = true;
                }
            } else {
            }
        }

        // dd($in);
        return view('user.absen.index',[
            'absen'      => $absen,
            'riwayat'    => $riwayat,
            'shift'      => $shift,
            'id'         => Auth::user(),
            'd'          => $d,
            'title'      => $title,
            'in'         => $in,
            'out'        => $out,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id=Auth::user();
        // dd($id->config->tipe_akun);
        $dataAbsen = Absensi::where('id_user', $id->id)->whereDate('jam_hadir', date('Y-m-d'))->first();
        if (!$dataAbsen || $dataAbsen == null) {
            return view('user.absen.hadir', [
                'id' => $id,
                'status' => $id->config->tipe_akun,
            ]);
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
        // dd($hadir);
        $hadir['hadir'] = date("Y-m-d H:i:s");
        $response = Absensi::create([
            'id_user'    => Auth::user()->id,
            'jam_hadir'  => $hadir['hadir'],
            'lat_hadir'  => $hadir['lat_hadir'],
            'long_hadir' => $hadir['long_hadir'],
            'ket_hadir'  => '',
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
        $data = Absensi::find($id);
        return view('user.absen.detail', [
            'data' => $data
        ]);
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
        $absen           = $r->all(); //Get Input
        $absen['pulang'] = Carbon::parse(date("Y-m-d H:i:s")); //Set Jam Pulang
        $data            = Absensi::find($id); //Set Data Absensi
        $tl              = 50; //Waktu Toleransi terhitung lembur

        // Hitung Total Jam
        $mulai = Carbon::parse($data->jam_hadir);
        $selesai = $absen['pulang'];
        $jam_kerja = $selesai->diffInMinutes($mulai) / 60; //Selisih Menit
        $overtime_kerja = $selesai->diffInMinutes($mulai) % 60; //Sisa menit dari jam kerja
        $jk = round($jam_kerja / 60, 2); //Get Nilai Lembur dalam desimal 2 angka dibelakang koma
        // dd($overtime_kerja);
        if($jk > 8){
            $jl = $jk - 8 ;
        }else{
            $jl = 0;
        }
        // dd(round($jam_kerja/60, 2));
        // Ubah Data Absensi
        $data->jam_pulang  = $absen['pulang'];
        $data->lat_pulang  = $absen['lat_pulang'];
        $data->long_pulang = $absen['long_pulang'];
        $data->ket_pulang  = $absen['deskripsi'];
        $data->jam_kerja  = $jam_kerja;
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

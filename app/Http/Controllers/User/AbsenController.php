<?php

namespace App\Http\Controllers\User;

use App\Models\Cuti;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\CabangConfig;
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
        $today      = Carbon::now();
        $yesterday  = Carbon::yesterday();
        // Set Absensi Apakah Sudah Hadir;
        $in         = false;
        $out        = false;
        $id         = Auth::user()->id;
        // Cek Shift
        $shift      = UserShift::where('id_user', $id)->whereDate('tanggal_shift', $today)->first();
        // Cek Absensi Terakhir
        $absenHariIni = Absensi::where('id_user', $id)->whereDate('jam_hadir', $today)->first();
        $absenKemarin = Absensi::where('id_user', $id)->whereDate('jam_hadir', $yesterday)->whereNull('jam_pulang')->first();
        // dd($absenKemarin);
        $absen      = '';
        // Set Riwayat Absensi
        $tahun      = date("Y");
        $bulan      = date("m");
        $riwayat    = Absensi::where('id_user', $id)
                                ->whereYear('jam_hadir', '=', $tahun)
                                ->whereMonth('jam_hadir', '=', $bulan)
                                ->orderBy('jam_hadir', 'DESC')->take(31)->get();
        // Set Utility
        $title      = null;
        $d          = false;
        if(!$shift){
            if ($absenKemarin) {
                $shift = UserShift::where('id_user', $id)->whereDate('tanggal_shift', $yesterday)->first();
                $absen = $absenKemarin;
                $in    = true;
                if ($absen->jam_pulang) {
                    $out = true;
                }
            }
            $title  = 'Absen Tidak Tersedia';
            $d      = true;
        }elseif ($shift->shift->ket_shift == 'Libur' || $shift->shift->hadir_shift == null) {
            $title  = 'Tidak Ada Shift';
            $d      = true;
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
                // do nothing
            }
        }
        // dd($rwt_shift);
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
        $today          = Carbon::now();
        $id             = Auth::user();
        $shift          = UserShift::where('id_user', $id->id)->whereDate('tanggal_shift', $today)->first();
        $dataAbsen      = Absensi::where('id_user', $id->id)->whereDate('jam_hadir', date('Y-m-d'))->first();
        $id_admin       = Auth::user()->id_admin;
        $id_cabang      = Auth::user()->id_cabang;
        $cc             = CabangConfig::where('id_admin', $id_admin)->where('id_cabang', $id_cabang)->first();
        $is_radius      = $cc->is_radius;
        $radius         = $cc->radius_max;
        $is_use_shift   = $cc->is_using_shift;
        $is_photo_enabled = $cc->is_photo_enabled;
        $cab            = Cabang::findOrFail($id_cabang)->first();
        $lat            = $cab->cabang_lat;
        $long           = $cab->cabang_long;
        if (!$dataAbsen || $dataAbsen == null) {
            return view('user.absen.hadir', [
                'id'            => $id,
                'shift'         => $shift,
                'is_radius'     => $is_radius,
                'radius'        => $radius,
                'is_use_shift'  => $is_use_shift,
                'is_photo_enabled'  => $is_photo_enabled,
                'cabang_lat'    => $lat,
                'cabang_long'   => $long,
                'status'        => $id->config->tipe_akun,
            ]);
        }else{
            return redirect()->route('absen.index')->withErrors('Anda telah absen hari ini');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $hadir      = $r->all();
        $id         = Auth::user();
        $today      = Carbon::now();
        $shift      = UserShift::where('id_user', $id->id)->whereDate('tanggal_shift', $today)->first();
        if (!$shift || $shift == null) {
            $u_shift = 0; }
        else {
            $u_shift = $shift->id_shift; }
        $hadir['hadir'] = date("Y-m-d H:i:s");
        $response = Absensi::create([
            'id_user'       => Auth::user()->id,
            'usershift_id'  => $u_shift,
            'jam_hadir'     => $hadir['hadir'],
            'lat_hadir'     => $hadir['lat_hadir'],
            'long_hadir'    => $hadir['long_hadir'],
            'ket_hadir'     => '',
        ]);
        try {
            $response->save();
            return redirect()->route('absen.index')->with('success', 'Berhasil catat kehadiran');
        } catch (\Illuminate\Database\QueryException $th) {
            return redirect()->route('absen.index')->with('error', 'Gagal catat kehadiran');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data           = Absensi::findOrFail($id);
        $shift          = UserShift::where('id_shift', $data->usershift_id)->first();
        return view('user.absen.detail', [
            'data'          => $data,
            'shift'         => $shift,
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
        $id_admin       = Auth::user()->id_admin;
        $id_cabang      = Auth::user()->id_cabang;
        $data           = Absensi::findOrFail($id);
        $tanggalAbsen   = Carbon::parse($data->jam_hadir);
        $now            = Carbon::now();
        $selisih        = $now->diffInHours($tanggalAbsen);
        $shift          = UserShift::where('id_shift', $data->usershift_id)->first();
        $cc             = CabangConfig::where('id_admin', $id_admin)->where('id_cabang', $id_cabang)->first();
        $is_radius      = $cc->is_radius;
        $radius         = $cc->radius_max;
        $is_use_shift   = $cc->is_using_shift;
        $cab            = Cabang::findOrFail($id_cabang)->first();
        $lat            = $cab->cabang_lat;
        $long           = $cab->cabang_long;
        // dd($shift);
        if ($selisih > 24) {
            return view('user.absen.lupa-pulang', [
                'data'          => $data,
                'shift'         => $shift,
                'is_radius'     => $is_radius,
                'radius'        => $radius,
                'is_use_shift'  => $is_use_shift,
                'cabang_lat'    => $lat,
                'cabang_long'   => $long,
            ]);
        }else{
            return view('user.absen.pulang', [
                'data'          => $data,
                'shift'         => $shift,
                'is_radius'     => $is_radius,
                'radius'        => $radius,
                'is_use_shift'  => $is_use_shift,
                'cabang_lat'    => $lat,
                'cabang_long'   => $long,
            ]);
        }
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
        $mulai          = Carbon::parse($data->jam_hadir);
        $selesai        = $absen['pulang'];
        $jam_kerja      = $selesai->diffInMinutes($mulai) / 60; //Selisih Menit
        $overtime_kerja = $selesai->diffInMinutes($mulai) % 60; //Sisa menit dari jam kerja
        $jk             = round($jam_kerja / 60, 2); //Get Nilai Lembur dalam desimal 2 angka dibelakang koma
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
        try {
            $data->save();
            return redirect()->route('absen.index')->with('success', 'Berhasil catat kepulangan');
        } catch (\Illuminate\Database\QueryException $th) {
            return redirect()->route('absen.index')->with('error', 'Gagal catat kepulangan');
        }
    }

    public function viewRiwayat()
    {
        $tahun      = date("Y");
        $bulan      = date("m");
        $id         = Auth::user()->id;
        $data       = Absensi::where('id_user', $id)
                    ->whereYear('jam_hadir', '=', $tahun)
                    ->whereMonth('jam_hadir', '=', $bulan)
                    ->orderBy('jam_hadir', 'DESC')->get();
        return view('user.absen.view-all', ['riwayat' => $data]);
    }
    public function postRiwayat(Request $request)
    {
        $hari       = $request->hari;
        $temp       = explode("-", $hari);
        $tahun      = $temp[0];
        $bulan      = $temp[1];
        $id         = Auth::user()->id;
        $data       = Absensi::where('id_user', $id)
                    ->whereYear('jam_hadir', '=', $tahun)
                    ->whereMonth('jam_hadir', '=', $bulan)
                    ->orderBy('jam_hadir', 'DESC')->get();
        return view('user.absen.data.view_data_riwayat', ['riwayat' => $data]);
    }
}

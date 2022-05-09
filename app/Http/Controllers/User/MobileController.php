<?php

namespace App\Http\Controllers\User;

use App\Models\Cuti;
use App\Models\User;
use App\Models\Absensi;
use App\Models\Payroll;
use App\Models\UserShift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class   MobileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $i = Auth::user();
        return view('user.index_profile', [
            'id' => $i,
        ]);
    }
    public function data_profile()
    {
        $i = Auth::user();
        return view('user.profile', [
            'id' => $i,
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
    public function postchangePassword(Request $r)
    {
        $i              = $r->all();
        $data           = User::find(Auth::user()->id);
        $data->password = Hash::make($i['password']);
        $data->save();
        return redirect()->route('user.profil');
    }
    public function saveProfile(Request $r)
    {
        // dd($r->all());
        $i            = $r->all();
        $data         = User::find(Auth::user()->id);
        $data->nama   = $i['nama'];
        $data->email  = $i['email'];
        $data->phone  = $i['phone'];
        $data->no_rek = $i['no_rek'];
        $data->alamat = $i['alamat'];
        $data->save();
        return redirect()->route('user.profil');
    }
    public function index()
    {
        $id        = Auth::user()->id;
        $shift     = UserShift::where('id_user', $id)->whereDate('tanggal_shift', date('Y-m-d'))->first();
        $absen     = Absensi::whereDate('jam_hadir', date('Y-m-d'))->where('id_user', $id)->first();
        $absenLast = Absensi::where('id_user', $id)->orderBy('jam_hadir', 'DESC')->first();
        $riwayat   = Absensi::where('id_user', $id)->orderBy('jam_hadir', 'DESC')->take(5)->get();
        $cuti      = Cuti::leftJoin('cuti_jenis', function ($join) {
                        $join->on('cutis.id_cuti_jenis', '=', 'cuti_jenis.id');
                    })->where('cutis.id_user', $id)->where('cutis.cuti_status', 'DITERIMA')->sum('cuti_total');
        $sakit      = Cuti::leftJoin('cuti_jenis', function ($join) {
                        $join->on('cutis.id_cuti_jenis', '=', 'cuti_jenis.id');
                    })->where('cutis.id_user', $id)->where('cuti_jenis.cuti_nama_jenis','LIKE', '%' . 'Sakit' . '%')->where('cutis.cuti_status', 'DITERIMA')->sum('cuti_total');
        $title     = null;
        $d         = false;
        if (!$shift) {
            $title = 'Absen Tidak Tersedia';
            $d = true;
        } elseif ($shift->shift->ket_shift == 'Libur' || $shift->shift->hadir_shift == null) {
            $title = 'Tidak Ada Shift';
            $d = true;
        }

        // dd($cuti);
        return view('user.home', [
            'absen'   => $absen,
            'riwayat' => $riwayat,
            'cuti'    => $cuti,
            'sakit'   => $sakit,
            'terbaru' => $absenLast,
            'shift'   => $shift,
            'id'      => Auth::user(),
            'd'       => $d,
            'title'   => $title
        ]);
    }

    public function gaji()
    {
        $id = Auth::user()->id;
        $gaji = Payroll::where('id_user', $id)->orderBy('id_payroll', 'DESC')->get();
        return view('user.gaji', [
            'id'      => Auth::user(),
            'gaji'  => $gaji,
        ]);
    }
    public function jadwal()
    {
        $id = Auth::user()->id;
        $jadwal = UserShift::where('id_user', $id)->whereMonth('tanggal_shift', date('m'))->orderBy('tanggal_shift', 'ASC')->get();
        // dd($jadwal);
        return view('user.jadwal', [
            'id'      => Auth::user(),
            'jadwal'  => $jadwal,
        ]);
    }

    public function getShift(){
        $admin = Auth::user()->id_admin;
        $shift = Shift::where('id_admin', $admin)->get();
        return view('user.absen.pilih-shift', [
            'shift' => $shift,
        ]);
    }

    public function postShift(Request $r){
        $input                  = $r->all();
        $input['id_user']       = Auth::user()->id;
        $input['id_user_shift'] = $r->shift;
        $input['tanggal_shift'] = Carbon::now()->format('Y-m-d');
        $input['status_shift']  = 'active';
        try {
            UserShift::create($input);
            return redirect()->route('absen.index')->with('success', 'Berhasil Menambahkan Shift!');
        } catch (\Illuminate\Database\QueryException $th) {
            return redirect()->route('absen.index')->with('error', $th->getMessage());
        }
    }
}

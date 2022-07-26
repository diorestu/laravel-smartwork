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
use App\Models\UserAsuransi;
use App\Models\UserConfig;
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
    //account pertama
    public function profile()
    {
        $i = Auth::user();
        return view('user.index_profile', [
            'id' => $i,
        ]);
    }
    // profil
    public function data_profile()
    {
        $i = Auth::user();
        return view('user.profile', [
            'id' => $i,
        ]);
    }
    public function editProfile()
    {
        $i = Auth::user();
        return view('user.update_profile', [
            'id' => $i,
        ]);
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


    public function changePassword()
    {
        $i  = Auth::user()->id;
        $id = User::with('cabang')->find($i);
        return view('user.ubah-pass', [
            'id' => $id,
        ]);
    }
    public function postchangePassword(Request $r)
    {
        $i              = $r->all();
        $data           = User::find(Auth::user()->id);
        $data->password = Hash::make($i['password']);
        try {
            $data->save();
            return redirect()->route('user.profil')->with('success', 'Berhasil update kata sandi');
        } catch (\Illuminate\Database\QueryException $th) {
            return redirect()->route('user.profil')->with('error', 'Gagal update kata sandi');
        }
    }
    public function infoPegawai()
    {
        $i          = Auth::user();
        $id_admin   = Auth::user()->id_admin;
        $company    = UserConfig::where('id_admin', $id_admin)->first();
        return view('user.info_pegawai', [
            'id' => $i,
            'company' => $company,
        ]);
    }
    public function infoPayroll()
    {
        $i          = Auth::user();
        $id_user    = Auth::user()->id;
        $asuransi   = UserAsuransi::where('id_user', $id_user)->first();
        return view('user.info_payroll', [
            'id' => $i,
            'asuransi' => $asuransi,
        ]);
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

    public function jadwal()
    {
        $id     = Auth::user()->id;
        $jadwal = UserShift::where('id_user', $id)
                ->whereYear('tanggal_shift', date('Y'))
                ->whereMonth('tanggal_shift', date('m'))
                ->orderBy('tanggal_shift', 'ASC')->get();
        return view('user.jadwal.index', [
            'id'      => Auth::user(),
            'jadwal'  => $jadwal,
        ]);
    }
    public function jadwal_riwayat(Request $request)
    {
        $hari       = $request->hari;
        $temp       = explode("-", $hari);
        $tahun      = $temp[0];
        $bulan      = $temp[1];
        $id         = Auth::user()->id;
        $jadwal     = UserShift::where('id_user', $id)
                    ->whereYear('tanggal_shift', $tahun)
                    ->whereMonth('tanggal_shift', $bulan)
                    ->orderBy('tanggal_shift', 'ASC')->get();
        return view('user.jadwal.data.view_data_riwayat', [
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

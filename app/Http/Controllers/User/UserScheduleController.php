<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LogShiftUser;
use App\Models\Shift;
use App\Models\UserShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserScheduleController extends Controller
{
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
        $pengajuan  = LogShiftUser::where('id_user', $id)
                    ->whereYear('tgl_shift', $tahun)
                    ->whereMonth('tgl_shift', $bulan)
                    ->orderBy('tgl_shift', 'ASC')->get();
        return view('user.jadwal.data.view_data_riwayat', [
            'id'        => Auth::user(),
            'jadwal'    => $jadwal,
            'pengajuan' => $pengajuan,
        ]);
    }

    public function jadwalCek(Request $request)
    {
        $id         = Auth::user()->id;
        $hari       = $request->hari;
        $jadwal     = UserShift::where('id_user', $id)
                    ->where('tanggal_shift', $hari)
                    ->orderBy('tanggal_shift', 'DESC')->first();
        if ($jadwal != null) {
            $jadwal_tanggal = $jadwal->shift->ket_shift;
            $jadwal_hadir   = TampilJamMenit($jadwal->shift->hadir_shift);
            $jadwal_pulang  = TampilJamMenit($jadwal->shift->pulang_shift);
        } else {
            $jadwal_tanggal = "-";
            $jadwal_hadir   = "-";
            $jadwal_pulang  = "-";
        }
        return '
        <div class="d-flex">
            <div class="col-4 px-1">
                <span class="text-muted">Shift</span>
                <br>
                <span id="old_shift">'. $jadwal_tanggal. '</span>
            </div>
            <div class="col-4 px-1">
                <span class="text-muted">Schedule In</span>
                <br>
                <span id="old_in">' . $jadwal_hadir . '</span>
            </div>
            <div class="col-4 px-1">
                <span class="text-muted">Schedule Out</span>
                <br>
                <span id="old_out">' . $jadwal_pulang . '</span>
            </div>
        </div>';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id         = Auth::user()->id;
        $jadwal     = UserShift::where('id_user', $id)
                    ->whereYear('tanggal_shift', date('Y'))
                    ->whereMonth('tanggal_shift', date('m'))
                    ->orderBy('tanggal_shift', 'ASC')->get();

        $pengajuan  = LogShiftUser::where('id_user', $id)
                    ->whereYear('tgl_shift', date('Y'))
                    ->whereMonth('tgl_shift', date('m'))
                    ->orderBy('tgl_shift', 'ASC')->get();

        return view('user.jadwal.index', [
            'id'      => Auth::user(),
            'jadwal'  => $jadwal,
            'pengajuan' => $pengajuan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_admin   = Auth::user()->id_admin;
        $shift      = Shift::where('id_admin', $id_admin)->get();
        return view('user.jadwal.create', [
            'shift' => $shift,
            'id'    => Auth::user(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input      = $request->all();
        $id         = Auth::user();
        $hari       = $input['tgl_shift'];
        $jadwal     = UserShift::where('id_user', $id->id)
                    ->where('tanggal_shift', $hari)
                    ->orderBy('tanggal_shift', 'DESC')->first();
        if ($jadwal != null) {
            $id_jadwal_lama = $jadwal->shift->id;
        } else {
            $id_jadwal_lama = 0;
        }
        $response   = LogShiftUser::create([
            'id_user'       => $id->id,
            'tgl_shift'     => $input['tgl_shift'],
            'id_shift_lama' => $id_jadwal_lama,
            'id_shift_baru' => $input['id_shift_baru'],
            'keterangan'    => $input['keterangan'],
            'status'        => 'menunggu',
        ]);
        try {
            $response->save();
            return redirect()->route('schedule.index')->with('success', 'Berhasil mengajukan perubahan shift');
        } catch (\Illuminate\Database\QueryException $th) {
            return redirect()->route('schedule.index')->with('error', 'Gagal mengajukan perubahan shift');
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
        $data   = LogShiftUser::where('id', $id)->first();
        return view('user.jadwal.detail', [
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            LogShiftUser::findOrFail($id)->delete();
            return redirect()->route('schedule.index')->with('success', 'Berhasil membatalkan pengajuan');
        } catch (\Throwable $th) {
            return redirect()->route('schedule.index')->with('error', 'Gagal membatalkan pengajuan');
        }
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    //
    public function lap_absensi() {
        return view("admin.laporan.absensi");
    }

    public function detail_absensi() {
        return view("admin.laporan.detail_absensi");
    }

    public function show_data_absensi(Request $request) {
        $input      = $request->all();
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
        $id         = Auth::user()->id;

        $user       = User::where('id_admin', $id)->where('roles', 'user')->pluck('id')->toArray();
        $data       = Lembur::whereIn('id_user', $user)
                            ->whereBetween('lembur_awal', [$tawal, $takhir])
                            ->where('lembur_status', 'PENGAJUAN')->get();

        $request->session()->put('lembur_pengajuan', $date);
        return view("admin.lembur.data.show_data_pengajuan", ['data' => $data]);
    }
}

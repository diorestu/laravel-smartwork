<?php

namespace App\Http\Controllers;
use App\Exports\CutiExport;
use Illuminate\Http\Request;
use App\Exports\LemburExport;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    //
    public function lap_absensi() {
        return view("admin.laporan.absensi");
    }

    public function lap_cuti() {
        return view("admin.laporan.cuti");
    }
    public function ekspor_cuti(Request $r) {
        return (new CutiExport($r->waktu))->download('export_report_cuti.xlsx');
    }
    public function lap_lembur() {
        return view("admin.laporan.lembur");
    }
    public function ekspor_lembur(Request $r) {
        return (new LemburExport($r->waktu))->download('export_lembur.xlsx');
    }
    public function lap_bpjs() {
        return view("admin.laporan.bpjs");
    }
    public function ekspor_bpjs(Request $r) {
        return 'success';
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

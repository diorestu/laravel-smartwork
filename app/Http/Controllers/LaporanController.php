<?php

namespace App\Http\Controllers;
use App\Exports\CutiExport;
use Illuminate\Http\Request;
use App\Exports\LemburExport;
use App\Models\Cuti;
use App\Models\Payroll;
use App\Models\PayrollParent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    //
    public function lap_absensi() {
        return view("admin.laporan.absensi");
    }

    public function detail_absensi()
    {
        return view("admin.laporan.detail_absensi");
    }

    public function show_data_absensi(Request $request)
    {
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

    // LAPORAN CUTI CONTROLLER
    public function lap_cuti() {
        return view("admin.laporan.cuti");
    }

    public function showDataCuti(Request $request)
    {
        $input      = $request->all();
        $cabang     = $input['id_cabang'];
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
        // $request->session()->put('cuti_pengajuan', $date);

        return view('admin.laporan.data.data_cuti', [
            'cabang' => $cabang,
            'tawal' => $tawal,
            'takhir' => $takhir
        ]);
    }

    public function ekspor_cuti(Request $r) {
        // return (new CutiExport($r->waktu))->download('export_report_cuti.xlsx');
        $input      = $r->all();
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
        $id         = Auth::user()->id;

        $user       = User::where('id_admin', $id)->where('roles', 'user')->pluck('id')->toArray();
        $data       = Lembur::whereIn('id_user', $user)
        ->whereBetween('lembur_awal', [$tawal, $takhir])
        ->where('lembur_status', 'PENGAJUAN')->get();

        $r->session()->put('lembur_pengajuan', $date);
    }

    // LAPORAN LEMBUR CONTROLLER
    public function lap_lembur() {
        return view("admin.laporan.lembur");
    }

    public function showDataLembur(Request $request)
    {
        $input      = $request->all();
        $cabang     = $input['id_cabang'];
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));

        return view('admin.laporan.data.data_lembur', [
            'cabang' => $cabang,
            'tawal' => $tawal,
            'takhir' => $takhir
        ]);
    }

    public function ekspor_lembur(Request $r) {
        return (new LemburExport($r->waktu))->download('export_lembur.xlsx');
    }

    // LAPORAN BPJS CONTROLLER
    public function lap_bpjs() {
        return view("admin.laporan.bpjs");
    }

    public function showDataBpjs(Request $request) {
        $input      = $request->all();
        $cabang     = $input['id_cabang'];
        $tahun      = $input['tahun'];
        $bulan      = $input['bulan'];
        $id         = Auth::user()->id;

        $payroll    = PayrollParent::where('pay_bulan', $bulan)->where('pay_tahun', $tahun)->pluck('id')->toArray();
        $data       = Payroll::with('user')->whereIn('id_payroll', $payroll)->get();
        // $request->session()->put('cuti_pengajuan', $date);
        return view('admin.laporan.data.data_bpjs', [
            'data' => $data,
        ]);
    }

    public function ekspor_bpjs(Request $r) {
        return 'success';
    }
}

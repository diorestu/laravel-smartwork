<?php

namespace App\Http\Controllers;
use App\Exports\LaporanBpjsExport;
use App\Exports\LaporanCutiExport;
use App\Exports\LaporanLemburExport;
use App\Exports\LaporanPajakExport;
use Illuminate\Http\Request;
use App\Exports\LemburExport;
use App\Models\Absensi;
use App\Models\Payroll;
use App\Models\PayrollParent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    //
    public function lap_absensi() {
        return view("admin.laporan.absensi");
    }

    public function show_data_absensi(Request $request)
    {
        $input      = $request->all();
        $cabang_id  = $input['id_cabang'];
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
        $id         = Auth::user()->id;

        $data       = Absensi::select(['absensis.id', 'absensis.id_user', 'absensis.jam_hadir', 'absensis.jam_pulang', 'absensis.jam_kerja', 'cabangs.cabang_nama'])
                    ->leftJoin('users',         'users.id',             '=', 'absensis.id_user')
                    ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                    ->whereBetween('absensis.jam_hadir',                 [$tawal, $takhir])
                    ->where('users.id_cabang', $cabang_id)
                    ->groupBy('absensis.id_user')->get();

        return view('admin.laporan.data.data_absensi', [
            'data' => $data,
            'awal' => $tawal,
            'akhir' => $takhir,
        ]);
    }

    public function detail_absensi($user, $periode_awal, $periode_akhir)
    {
        $data_user = User::where("id", $user)->first();

        return view("admin.laporan.detail_absensi", [
            'data_user' => $data_user,
        ]);
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
            'tawal'  => $tawal,
            'takhir' => $takhir
        ]);
    }

    public function ekspor_lapCuti($user, $awal, $akhir)
    {
        return (new LaporanCutiExport($user, $awal, $akhir))->download('Laporan Cuti Pegawai ' . tanggalIndo3($awal) . ' sd ' . tanggalIndo3($akhir) . '.xlsx');
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

    public function ekspor_lapLembur($user, $awal, $akhir)
    {
        return (new LaporanLemburExport($user, $awal, $akhir))->download('Laporan Lembur Pegawai ' . tanggalIndo3($awal) . ' sd ' . tanggalIndo3($akhir) . '.xlsx');
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
            'data'      => $data,
            'cabang'    => $cabang,
            'bulan'     => $bulan,
            'tahun'     => $tahun,
        ]);
    }

    public function ekspor_lapBpjs($tipe, $cabang, $bulan, $tahun) {
        return (new LaporanBpjsExport($tipe, $cabang, $bulan, $tahun))->download('Laporan Iuran BPJS '.$tipe.'.xlsx');
    }

    // LAPORAN PAJAK PPH 21
    public function lap_pph21()
    {
        return view("admin.laporan.pajak");
    }

    public function showDataPph21(Request $request)
    {
        $input      = $request->all();
        $cabang     = $input['id_cabang'];
        $tahun      = $input['tahun'];
        $bulan      = $input['bulan'];
        $id         = Auth::user()->id;

        $payroll    = PayrollParent::where('pay_bulan', $bulan)->where('pay_tahun', $tahun)->pluck('id')->toArray();
        $data       = Payroll::with('user')->whereIn('id_payroll', $payroll)->get();
        // $request->session()->put('cuti_pengajuan', $date);
        return view('admin.laporan.data.data_pajak', [
            'data' => $data,
            'cabang'    => $cabang,
            'bulan'     => $bulan,
            'tahun'     => $tahun,
        ]);
    }

    public function ekspor_lapPajak($cabang, $bulan, $tahun)
    {
        $periode = BulanTahun($tahun.'-'.$bulan.'-01');
        return (new LaporanPajakExport($cabang, $bulan, $tahun))->download('Laporan Pajak PPh21 Pegawai '. $periode .'.xlsx');
    }
}

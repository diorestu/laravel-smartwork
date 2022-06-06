<?php

namespace App\Http\Controllers;
use App\Exports\LaporanBpjsExport;
use App\Exports\LaporanCutiExport;
use App\Exports\LaporanLemburExport;
use App\Exports\LaporanPajakExport;
use Illuminate\Http\Request;
use App\Exports\LemburExport;
use App\Models\Absensi;
use App\Models\Cuti;
use App\Models\CutiJenis;
use App\Models\Lembur;
use App\Models\Payroll;
use App\Models\PayrollParent;
use App\Models\User;
use App\Models\UserShift;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $data_user      = User::where("id", $user)->first();
        // hari kerja
        $hari_kerja     = UserShift::leftJoin('shifts', 'user_shifts.id_user_shift', '=', 'shifts.id')
                                ->where('shifts.nama_shift', '!=', "L")
                                ->where('id_user', $user)
                                ->whereBetween('tanggal_shift', [$periode_awal, $periode_akhir])->count();
        // bukan hari kerja
        $bukan_hari_kerja  = UserShift::leftJoin('shifts', 'user_shifts.id_user_shift', '=', 'shifts.id')
                                ->where('shifts.nama_shift', '=', "L")
                                ->where('id_user', $user)
                                ->whereBetween('tanggal_shift', [$periode_awal, $periode_akhir])->count();
        // tepat waktu dan terlambat
        $tepat_waktu    = 0;
        $terlambat      = 0;
        $data_tw        = Absensi::whereBetween('jam_hadir', [$periode_awal, $periode_akhir])->where('id_user', $user)->get();
        foreach ($data_tw as $d) {
            $jam_hadir = $d->jam_hadir;
            $tgl_absen = TampilTanggal($d->jam_hadir);
            $cek_shift = UserShift::leftJoin('shifts', 'user_shifts.id_user_shift', '=', 'shifts.id')
            ->where('user_shifts.tanggal_shift', '=', $tgl_absen)->first();
            $jam_shift = $cek_shift->hadir_shift;
            $waktu_shift = $tgl_absen . " " . $jam_shift;

            if ($cek_shift->nama_shift != "L") {
                $jamawal        = Carbon::parse($waktu_shift);
                $jamakhir       = Carbon::parse($jam_hadir);
                $totalDuration  = $jamawal->diffInMinutes($jamakhir, false);
                if ($totalDuration <= 0) {
                    $tepat_waktu++;
                }
                else {
                    $terlambat++;
                }
            }
        }
        // mangkir
        $mangkir = 0;
        $data   = UserShift::leftJoin('shifts', 'user_shifts.id_user_shift', '=', 'shifts.id')
                            ->where('user_shifts.id_user', '=', $user)
                            ->where('shifts.nama_shift', '!=', "L")
                            ->whereBetween('user_shifts.tanggal_shift', [$periode_awal, $periode_akhir])->get();
        foreach ($data as $d) {
            $tgl        = $d->tanggal_shift;
            $cekAbsen   = Absensi::where("id_user", $user)->whereDate('jam_hadir', $tgl)->where('id_user', $user)->count();
            if ($cekAbsen <= 0) {
                $mangkir++;
            }
        }
        // cuti
        $data_cuti       = Cuti::where('id_user', '=', $user)->where('cuti_status', 'DITERIMA')->whereBetween('cuti_awal', [$periode_awal, $periode_akhir])->count();
        // lembur
        $lembur_absen    = Absensi::select(DB::raw('SUM(jam_lembur) as jam_la'))->where('id_user', $user)->whereBetween('jam_pulang', [$periode_awal, $periode_akhir])->whereNotNull('jam_lembur')->first();
        $lembur_pegajuan = Lembur::select(DB::raw('SUM(jam_lembur) as jam_lp'))->where('id_user', $user)->where('lembur_status', 'DITERIMA')->whereBetween('lembur_awal', [$periode_awal, $periode_akhir])->first();
        $total_lembur    = $lembur_absen->jam_la + $lembur_pegajuan->jam_lp;
        // sakit
        $id_admin        = Auth::user()->id;
        $cuti_sakit      = CutiJenis::where('id_admin', $id_admin)->where('cuti_nama_jenis', 'Sakit')->first();
        $sakit           = Cuti::where('id_user', '=', $user)->where('cuti_status', 'DITERIMA')->where('id_cuti_jenis', $cuti_sakit->id)->whereBetween('cuti_awal', [$periode_awal, $periode_akhir])->count();

        return view("admin.laporan.detail_absensi", [
            'data_user'     => $data_user,
            'awal'          => $periode_awal,
            'akhir'         => $periode_akhir,
            'hari_kerja'    => $hari_kerja,
            'bukan_hari_kerja' => $bukan_hari_kerja,
            'tepat_waktu'   => $tepat_waktu,
            'terlambat'     => $terlambat,
            'mangkir'       => $mangkir,
            'cuti'          => $data_cuti,
            'lembur'        => $total_lembur,
            'sakit'         => $sakit,
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

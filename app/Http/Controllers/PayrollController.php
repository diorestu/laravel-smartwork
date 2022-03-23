<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Cabang;
use App\Models\Payroll;
use App\Models\PayrollParent;
use App\Models\UserAsuransi;
use App\Models\UserTunjangan;
use App\Models\UserSalary;
use App\Models\UserPotongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;

class PayrollController extends Controller
{
    public function get_payroll(Request $r) {
        $input      = $r->all();
        $tahun      = $input['tahun'];
        $bulan      = $input['bulan'];
        return redirect()->route('payroll.riwayat', ['bl' => $bulan, 'th' => $tahun]);
    }

    public function lihat_payroll($bulan, $tahun) {
        $data       = PayrollParent::where('pay_bulan', $bulan)
                                    ->where('pay_tahun', $tahun);
        return view('admin.payroll.riwayat', ['data' => $data->get(), 'tahun' => $tahun, 'bulan' => $bulan]);
    }

    public function slipgaji_payroll($id)
    {
        $data       = Payroll::findOrFail($id);
        $dataParent = PayrollParent::where('id', $data->id_payroll)->first();
        // dd($dataParent);
        return view('admin.payroll.slipgaji', [
            'data'  => $data,
            'bulan' => $dataParent->pay_bulan,
            'tahun' => $dataParent->pay_tahun
        ]);
    }

    public function cetak_slipgaji_payroll($id)
    {
        $data       = Payroll::findOrFail($id);
        $dataParent = PayrollParent::where('id', $data->id_payroll)->first();

        $path = public_path('backend-assets/images/logo-sw-dark.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data_image = file_get_contents($path);
        $pic = 'data:image/'. $type . ';base64,'. base64_encode($data_image);

        // dd($pic);

        // return view('admin.payroll.pdf.pdf_slipgaji', [
        //     'data'  => $data,
        //     'bulan' => $dataParent->pay_bulan,
        //     'tahun' => $dataParent->pay_tahun,
        //     'logo' => $pic
        // ]);

        $filename   = 'SLIP GAJI.pdf';
        $pdf        = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
                            ->setPaper('a5', 'landscape')
                            ->loadView('admin.payroll.pdf.pdf_slipgaji', ['logo' => $pic, 'data' => $data, 'bulan' => $dataParent->pay_bulan, 'tahun' => $dataParent->pay_tahun]);
        return $pdf->stream($filename);


        // $pdf = PDF::loadview('admin.payroll.pdf.pdf_slipgaji', ['data' => $data, 'bulan' => $dataParent->pay_bulan, 'tahun' => $dataParent->pay_tahun]);
        // return $pdf->stream();
        // return $pdf->download('slip-gaji-pegawai-pdf');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.payroll.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id     = Auth::user()->id;
        $data   = Cabang::where('id_admin', $id)->get();
        return view('admin.payroll.create', [
            'data' => $data,
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
        $post       = $request->all();
        $kode       = $post['pay_code'];
        $cabang_id  = $post['id_cabang'];
        $tahun      = $post['tahun'];
        $bulan      = $post['bulan'];
        $remark     = $post['pay_description'];
        $pegawai    = User::select(['id as id_user'])->where('id_cabang', $cabang_id)->get();
        $gajiUmr    = Cabang::select(['cabang_umk'])->where('id', $cabang_id)->first();

        $tambah_baru                        = new PayrollParent;
        $tambah_baru->id_admin              = Auth::user()->id;
        $tambah_baru->pay_code              = $kode;
        $tambah_baru->pay_bulan             = $bulan;
        $tambah_baru->pay_tahun             = $tahun;
        $tambah_baru->pay_desc              = $remark;
        $tambah_baru->payroll_status        = "PENDING";
        $berhasilTambah                     = $tambah_baru->save();

        if ($berhasilTambah) {
            $id_payroll = $tambah_baru->id;
            foreach ($pegawai as $i) {
                $gaji       = UserSalary::where('id_user', $i->id_user)->first();
                $tunjangan  = UserTunjangan::where('id_user', $i->id_user)->first();

                $asuransi   = UserAsuransi::where('id_user', $i->id_user)->first();
                $potongan   = UserPotongan::where('pot_bulan', $bulan)
                ->where('pot_tahun', $tahun)
                ->where('id_user', $i->id_user)->get();
                // gp + tj
                $gaji_pokok = $gaji->gaji_pokok;
                $total_tj   = $tunjangan->tj_jabatan + $tunjangan->tj_sertifikasi + $tunjangan->tj_statusKawin + $tunjangan->tj_masaKerja + $tunjangan->tj_makan + $tunjangan->tj_transport + $tunjangan->tj_kosmetik + $tunjangan->tj_lain;

                // potongan
                $total_pot  = 0;
                // bpjs nakes
                if ($asuransi->status_nakes == 'n') {
                    $bpjs_kes_u = 0;
                } else {
                    $bpjs_kes_u = ($asuransi->pot_nakes / 100) * $gaji_pokok;
                }
                // bpjs naker
                if ($asuransi->status_naker == 'n') {
                    $bpjs_ker_u = 0;
                } else {
                    $bpjs_ker_u = ($asuransi->pot_naker / 100) * $gaji_pokok;
                }
                // potongan lain
                foreach ($potongan as $pot) {
                    $total_pot += $pot->pot_nilai;
                }
                $total_potongan = $total_pot + $bpjs_kes_u + $bpjs_ker_u;

                Payroll::create([
                    'id_payroll'      => $id_payroll,
                    'id_user'         => $i->id_user,
                    'pay_pokok'       => $gaji_pokok,
                    'bpjs_tk_u'       => $bpjs_ker_u,
                    'bpjs_tk_p'       => 0.0624 * $gaji_pokok,
                    'bpjs_kes_u'      => $bpjs_kes_u,
                    'bpjs_kes_p'      => 0.04 * $gaji_pokok,
                    'tj_jabatan'      => $tunjangan->tj_jabatan,
                    'tj_sertifikasi'  => $tunjangan->tj_sertifikasi,
                    'tj_transport'    => $tunjangan->tj_transport,
                    'tj_kosmetik'     => $tunjangan->tj_kosmetik,
                    'tj_makan'        => $tunjangan->tj_makan,
                    'tj_masaKerja'    => $tunjangan->tj_masaKerja,
                    'tj_statusKawin'  => $tunjangan->tj_statusKawin,
                    'tj_bonus'        => $tunjangan->tj_lain,
                    'pt_absen'        => 0,
                    'pt_kasbon'       => $total_pot,
                    'pt_lainnya'      => 0,
                    'total_pot'       => $total_potongan,
                    'total_tj'        => $total_tj ?? 0,
                    'bruto'           => $total_tj + $gaji_pokok,
                    'netto'           => ($total_tj + $gaji_pokok) - $total_potongan,
                ]);
            }
        } else {
            return redirect()->back()->with('error', "Gagal membuat penggajian baru");
        }

        return redirect()->route('payroll.edit', $id_payroll)->with('success', 'Proses Penggajian Berhasil!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $data = Payroll::leftJoin('users', 'users.id','=', 'payrolls.id_user',)->where('pay_code', $code)->get();
        // dd($data);
        if($data == []){
            $bulan = $data[0]->pay_bulan;
            $a = date("F", mktime(0, 0, 0, $bulan, 1));
            return view('admin.payroll.detail', [
                'data' => $data,
                'a' => $a,
            ]);
        }else{
            abort('404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dataParent = PayrollParent::findOrFail($id);
        $data       = Payroll::where('id_payroll', $id)->get();
        return view('admin.payroll.edit', [
            'dataParent' => $dataParent,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payroll $payroll)
    {
        //
    }
}

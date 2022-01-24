<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Cabang;
use App\Models\Payroll;
use App\Models\UserSalary;
use App\Models\UserPotongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Payroll::select(['pay_code','pay_description', DB::raw('sum(netto) as total')])->groupBy('pay_code', 'pay_description')->get();
        return view('admin.payroll.index', [
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::user()->id;
        $data = Cabang::where('id_admin', $id)->get();
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
        $post = $request->all();
        $pegawai = User::select(['users.id as id_user'])
        ->join('cabangs', 'users.id_cabang', '=', 'cabangs.id')
        ->where('users.id_cabang', $post['id_cabang'])->get();
        foreach ($pegawai as $i) {
            $ds = UserSalary::select(['users.id', 'users.nama','users.bpjs_kes', 'user_salaries.*', 'user_tunjangans.*'])
                        ->leftJoin('users', 'users.id', '=', 'user_salaries.id_user')
                        ->leftJoin('user_tunjangans', 'users.id', '=', 'user_tunjangans.id_user')
                        ->where('users.id', $i->id_user)->first();
            $dp = UserPotongan::select(['users.id', 'user_potongans.*'])->leftJoin('users', 'users.id', '=', 'user_potongans.id_user')
                        ->where('user_potongans.pot_bulan', $post['pay_bulan'])
                        ->where('user_potongans.pot_tahun', $post['pay_tahun'])
                        ->where('users.id', $i->id_user)->get();
            $total_tj = $ds->tj_jabatan + $ds->tj_makan + $ds->tj_transport + $ds->tj_sertifikasi + $ds->tj_lain;
            $total_pot  = 0;
            if ($ds->bpjs_kes == 'n') {
                $bpjs_kes_u = 0;
            }else{
                $bpjs_kes_u = 0.01 * $ds->gaji_pokok;
            }
            foreach ($dp as $i) {
                $total_pot += $i->pot_nilai;
            }
            $total_potongan = $total_pot + (0.01 * $ds->gaji_pokok) + (0.03 * $ds->gaji_pokok);


            Payroll::create([
                'pay_code'        => $post['pay_code'],
                'pay_bulan'       => $post['pay_bulan'],
                'pay_tahun'       => $post['pay_tahun'],
                'pay_pokok'       => $ds->gaji_pokok,
                'pay_description' => $post['pay_description'],
                'id_user'         => $i->id_user,
                'bpjs_tk_u'       => 0.03 * $ds->gaji_pokok,
                'bpjs_tk_p'       => 0.0624 * $ds->gaji_pokok,
                'bpjs_kes_u'      => $bpjs_kes_u,
                'bpjs_kes_p'      => 0.04 * $ds->gaji_pokok,
                'total_pot'       => $total_potongan,
                'total_tj'        => $total_tj ?? 0,
                'bruto'           => $total_tj + $ds->gaji_pokok,
                'netto'           => ($total_tj + $ds->gaji_pokok) - $total_potongan,
            ]);
        }

        return redirect()->route('payroll.index')->with('success', 'Proses Penggajian Berhasil!');
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
    public function edit(Payroll $payroll)
    {
        //
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

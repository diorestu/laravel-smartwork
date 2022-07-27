<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cuti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CabangCuti;
use App\Models\CutiJenis;
use Illuminate\Support\Facades\Auth;

class CutiController extends Controller
{
    public function riwayat(Request $request)
    {
        $tahun          = $request->hari;
        $id_user        = Auth::user()->id;
        $id_cabang      = Auth::user()->id_cabang;
        $cuti           = Cuti::where('id_user', $id_user)
                        ->whereYear('cuti_awal', $tahun)
                        ->orderBy('cuti_awal', 'DESC')->get();

        $cutiambil      = Cuti::where('id_user', $id_user)
                        ->whereYear('cuti_awal', $tahun)
                        ->where('cuti_status', 'DITERIMA')->get();
        $jumcuti        = $cutiambil->sum('cuti_total');

        $jatah          = CabangCuti::where('id_cabang', $id_cabang)->where('tahun_periode', $tahun)->first();
        if ($jatah != null) {
            $jc             = $jatah->jatah_cuti;
            $sisacuti       = $jc - $jumcuti;
        } else {
            $jc             = 0;
            $sisacuti       = $jumcuti;
        }

        return view('user.cuti.data.view_data_riwayat', [
            'id'        => Auth::user(),
            'data'      => $cuti,
            'jc'        => $jc . " Hari",
            'jumcuti'   => $jumcuti . " Hari",
            'sisacuti'  => $sisacuti . " Hari",
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun          = date("Y");
        $id             = Auth::user()->id;
        $id_cabang      = Auth::user()->id_cabang;
        $data           = Cuti::where('id_user', $id)
                        ->whereYear('cuti_awal', $tahun)
                        ->latest()->take(6)->get();

        $jatah          = CabangCuti::where('id_cabang', $id_cabang)->where('tahun_periode', $tahun)->first();
        $jc             = $jatah->jatah_cuti;
        $cutiambil      = Cuti::where('id_user', $id)
                        ->whereYear('cuti_awal', $tahun)
                        ->where('cuti_status', 'DITERIMA')
                        ->get();
        $jumcuti        = $cutiambil->sum('cuti_total');
        $sisacuti       = $jc-$jumcuti;

        return view('user.cuti.index', [
            'data'      => $data,
            'jatah'     => $jatah,
            'jc'        => $jc,
            'jumcuti'   => $jumcuti,
            'sisacuti'  => $sisacuti,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis = CutiJenis::where('id_admin', Auth::user()->id_admin)->get();
        return view('user.cuti.input', [
            'jenis' => $jenis
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
        $r                  = $request->all();
        $id                 = Auth::user()->id;
        $mulai              = Carbon::parse($r['cuti_awal']);
        $total_hari         = $r['cuti_total'];
        $r['id_user']       = $id;
        $r['cuti_status']   = 'PENGAJUAN';
        $r['cuti_akhir']    = $mulai->addDays($total_hari-1);
        try {
            Cuti::create($r);
            return redirect()->route('leave.index')->with('success', 'Berhasil mengajukan cuti');
        } catch (\Illuminate\Database\QueryException $e) {
            // abort(500, $e->getMessage());
            return redirect()->route('leave.index')->with('error', 'Gagal mengajukan cuti');
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
        $data   = Cuti::where('id_cuti', $id)->first();
        return view('user.cuti.detail', [
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
            Cuti::findOrFail($id)->delete();
            return redirect()->route('leave.index')->with('success', 'Berhasil membatalkan cuti');
        } catch (\Throwable $th) {
            return redirect()->route('leave.index')->with('error', 'Gagal membatalkan cuti');
        }
    }
}

<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cuti;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CutiJenis;
use Illuminate\Support\Facades\Auth;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id     = Auth::user()->id;
        $data   = Cuti::where('id_user', $id)->latest()->take(6)->get();
        return view('user.cuti.index', [
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
        $r  = $request->all();
        $id = Auth::user()->id;
        // hitung total hari
        $mulai   = Carbon::parse($r['cuti_awal']);
        $selesai = Carbon::parse($r['cuti_akhir']);
        $diff    = $selesai->diffInDays($mulai);
        // Prepare Data Cuti
        $r['id_user'] = $id;
        $r['cuti_status'] = 'PENGAJUAN';
        $r['cuti_total'] = $diff + 1;
        try {
            Cuti::create($r);
            return redirect()->route('leave.index');
        } catch (\Illuminate\Database\QueryException $e) {
            abort(500, $e->getMessage());
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

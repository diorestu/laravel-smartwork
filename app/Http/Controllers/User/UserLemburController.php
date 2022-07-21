<?php

namespace App\Http\Controllers\User;

use App\Models\Lembur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class UserLemburController extends Controller
{
    public function riwayat(Request $request)
    {
        $hari           = $request->hari;
        $temp           = explode("-", $hari);
        $tahun          = $temp[0];
        $bulan          = $temp[1];
        $id             = Auth::user()->id;
        $data           = Lembur::where('id_user', $id)
                        ->whereYear('lembur_awal', $tahun)
                        ->whereMonth('lembur_awal', $bulan)
                        ->get();
        $data_absen     = Absensi::where('id_user', $id)
                        ->whereYear('jam_pulang', $tahun)
                        ->whereMonth('jam_pulang', $bulan)
                        ->where('jam_lembur', '!=', 0)
                        ->get();
        return view('user.lembur.data.view_data_riwayat', [
            'id'    => Auth::user(),
            'data'  => $data,
            'data_absen' => $data_absen,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bulan          = date("m");
        $tahun          = date("Y");
        $id             = Auth::user()->id;
        $data           = Lembur::where('id_user', $id)
                        ->whereYear('lembur_awal', $tahun)
                        ->whereMonth('lembur_awal', $bulan)
                        ->get();
        $data_absen     = Absensi::where('id_user', $id)
                        ->whereYear('jam_pulang', $tahun)
                        ->whereMonth('jam_pulang', $bulan)
                        ->where('jam_lembur', '!=', 0)
                        ->get();

        return view('user.lembur.index', [
            'id'    => Auth::user(),
            'data'  => $data,
            'data_absen' => $data_absen,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.lembur.input');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input                  = $request->all();
        $menit                  = selisihJam($request->lembur_awal, $request->lembur_akhir);
        $input['id_user']       = Auth::user()->id;
        $input['jam_kerja']     = $menit/60;
        $input['jam_lembur']    = ($menit/60);
        // $input['jam_lembur']    = ($menit/60)-9;
        $input['lembur_status'] = 'PENGAJUAN';
        try {
            Lembur::create($input);
            return redirect()->route('overtime.index')->with('success', 'Berhasil mengajukan lembur');
        } catch (\Illuminate\Database\QueryException $th) {
            return redirect()->route('overtime.index')->with('error', 'Gagal mengajukan lembur');
            // abort(500, throw $th);
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
        $data   = Lembur::where('id', $id)->first();
        return view('user.lembur.detail', [
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
        try {
            Lembur::findOrFail($id)->delete();
            return redirect()->route('overtime.index')->with('success', 'Berhasil membatalkan lembur');
        } catch (\Throwable $th) {
            return redirect()->route('overtime.index')->with('error', 'Gagal membatalkan lembur');
        }
    }
}

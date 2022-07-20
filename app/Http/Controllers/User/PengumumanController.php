<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_admin       = Auth::user()->id_admin;
        $id_divisi      = Auth::user()->id_divisi;
        $pengumuman     = Pengumuman::where('id_admin', $id_admin)
                        ->where('id_divisi', $id_divisi)
                        ->orWhere('id_divisi', '0')
                        ->whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', date('m'))
                        ->orderBy('created_at', 'DESC')->get();

        return view('user.pengumuman.index', [
            'id'      => Auth::user(),
            'data'  => $pengumuman,
        ]);
    }
    public function riwayat(Request $request)
    {
        $hari           = $request->hari;
        $temp           = explode("-", $hari);
        $tahun          = $temp[0];
        $bulan          = $temp[1];
        $id_admin       = Auth::user()->id_admin;
        $id_divisi      = Auth::user()->id_divisi;
        $pengumuman     = Pengumuman::where('id_admin', $id_admin)
                        ->where('id_divisi', $id_divisi)
                        ->orWhere('id_divisi', '0')
                        ->whereYear('created_at', $tahun)
                        ->whereMonth('created_at', $bulan)
                        ->orderBy('created_at', 'DESC')->get();
        return view('user.pengumuman.data.view_data_riwayat', [
            'id'      => Auth::user(),
            'data'  => $pengumuman,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Pengumuman::find($id);
        return view('user.pengumuman.detail', ['data' => $data]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewAbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id     = Auth::user()->id;
        $date   = ("2021-12-27");
        $data   = Absensi::select(['absensis.id', 'cabang_nama', 'absensis.id_user', 'jam_hadir', 'jam_pulang', 'nama_shift', 'ket_shift', 'hadir_shift', 'pulang_shift', 'jam_kerja',])
                        ->join('users',         'users.id',             '=', 'absensis.id_user')
                        ->join('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                        ->join('user_shifts',   'user_shifts.id_user',  '=', 'users.id')
                        ->join('shifts',        'shifts.id',            '=', 'user_shifts.id_user_shift')
                        ->where('user_shifts.tanggal_shift',            '=', $date)
                        ->whereDate('absensis.jam_hadir',               '=', $date)
                        ->where('users.id_admin', $id)->get();
        return view('admin.absensi.index',
            ['data' => $data]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.absensi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idAdmin                    = Auth::user()->id;
        $input                      = $request->all();
        $tambah_baru                = new Absensi;
        $id_user                    = $input['id_user'];
        $waktu_hadir                = $input['tgl_hadir'] . " " . $input['jam_hadir'];
        if ($input['tgl_pulang']    == "") {
            $waktu_pulang           = null;
        } else {
            $waktu_pulang           = $input['tgl_pulang'] . " " . $input['jam_pulang'];
        }
        $tambah_baru->jam_hadir     = $waktu_hadir;
        $tambah_baru->jam_pulang    = $waktu_pulang;
        $tambah_baru->ket_hadir     = $input['ket_hadir'];
        $tambah_baru->ket_pulang    = $input['ket_pulang'];
        $cekJudul                   = Absensi::whereDate('jam_hadir', '=', $waktu_hadir)->where('id_user', '=', $id_user)->first();
        if ($cekJudul != null) {
            return redirect()->route('absensi.create')->with('error', 'Absen hadir sudah terinput');
        } else {
            $berhasilTambah         = $tambah_baru->save();
            if ($berhasilTambah) {
                return redirect()->route('absensi.edit', $tambah_baru->id)->with('success', 'Proses tambah data absensi pegawai berhasil');
            } else {
                return redirect()->route('absensi.index')->with('error', 'Gagal menambahkan data absensi');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data   = Absensi::select(['absensis.id',
                                    'cabang_nama',
                                    'absensis.id_user',
                                    'jam_hadir',
                                    'jam_pulang',
                                    'nama_shift',
                                    'ket_shift',
                                    'hadir_shift',
                                    'pulang_shift',
                                    'jam_kerja',
                                    'ket_hadir',
                                    'ket_pulang',
                                    'lat_hadir',
                                    'long_hadir',
                                    'lat_pulang',
                                    'long_pulang',
                                    ])
                                    ->join('users',         'users.id',             '=', 'absensis.id_user')
                                    ->join('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                                    ->join('user_shifts',   'user_shifts.id_user',  '=', 'users.id')
                                    ->join('shifts',        'shifts.id',            '=', 'user_shifts.id_user_shift')
                                    ->where('absensis.id',                          '=', $id)->first();
        // dd($data);
        if ($data != null) {
            return view('admin.absensi.detail', ['data' => $data]);
        }
        else {
            return redirect()->route('absensi.index')->with('error', 'Tidak mendapatkan id absensi');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data           = Absensi::findOrFail($id);
        return view(
            'admin.absensi.edit',
            ['data' => $data]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id_admin                   = Auth::user()->id;
        $input                      = $request->all();
        $data                       = Absensi::findOrFail($id);
        $id_user                    = $data->id_user;
        $waktu_hadir                = $input['tgl_hadir']." ".$input['jam_hadir'];
        if ($input['tgl_pulang'] == "") { $waktu_pulang = null; }
        else {
        $waktu_pulang               = $input['tgl_pulang']." ".$input['jam_pulang']; }
        $data->jam_hadir            = $waktu_hadir;
        $data->jam_pulang           = $waktu_pulang;
        $data->ket_hadir            = $input['ket_hadir'];
        $data->ket_pulang           = $input['ket_pulang'];
        // dd($waktu_pulang);
        $cekJudul                   = Absensi::whereDate('jam_hadir', '=', $waktu_hadir)->where('id_user', '=', $id_user)->where('id', '!=', $id)->first();
        if ($cekJudul != null) {
            return redirect()->route('absensi.edit', $id)->with('error', 'Absen hadir sudah terinput');
        } else {
            $berhasilSimpan         = $data->save();
            if ($berhasilSimpan) {
                return redirect()->route('absensi.edit', $id)->with('success', 'Proses update data absensi pegawai berhasil');
            } else {
                return redirect()->route('absensi.edit', $id)->with('error', 'Gagal mengupdate data absensi');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absensi  $absensi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Absensi::findOrFail($id)->delete();
            return "ok";
        } catch (\Throwable $th) {
            return $th;
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\AktivitasController;
use App\Models\Aktivitas;
use Illuminate\Support\Facades\Auth;
use DateTime;

class ViewAktivitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date   = date("Y-m-d");
        $data   = Aktivitas::whereDate('created_at', '=', $date)->get();
        return view("admin.aktivitas.index", ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.aktivitas.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input                        = $request->all();
        $tambah_baru                  = new Aktivitas;
        $tambah_baru->id_user         = $input['id_staff'];
        $tambah_baru->judul_aktivitas = $input['judul_aktivitas'];
        $tambah_baru->aktivitas       = $input['aktivitas'];
        $tambah_baru->jam_aktivitas   = $input['jam_aktivitas'];
        $berhasilSimpan               = $tambah_baru->save();
        if ($berhasilSimpan) {
            return redirect()->route('aktivitas.index')->with('success', 'Proses tambah data aktivitas pegawai berhasil');
        } else {
            return redirect()->route('aktivitas.index')->with('error', 'Gagal menambahkan data aktivitas pegawai');
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
        // sudah ada di index
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Aktivitas::findOrFail($id);
        return view('admin.aktivitas.edit', ['data' => $data]);
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
        $input                     = $request->all();
        $data                      = Aktivitas::findOrFail($id);
        $data->id_user             = $input['id_staff'];
        $data->judul_aktivitas     = $input['judul_aktivitas'];
        $data->aktivitas           = $input['aktivitas'];
        $data->jam_aktivitas       = $input['jam_aktivitas'];
        $berhasilSimpan            = $data->save();
        if ($berhasilSimpan) {
            return redirect()->route('aktivitas.edit', $data->id)->with('success', 'Proses update aktivitas pegawai berhasil');
        } else {
            return redirect()->route('aktivitas.edit', $data->id)->with('error', 'Gagal mengupdate data aktivitas');
        }
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
            Aktivitas::findOrFail($id)->delete();
            return "ok";
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data_karyawan()
    {
        return view('admin.aktivitas.show_karyawan');
    }

    public function showDataKaryawan(Request $request)
    {
        $input      = $request->all();
        $staff_id   = $input['id_staff'];
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
        $data       = Aktivitas::where('id_user', $staff_id)->whereBetween('created_at', [$tawal, $takhir])->get();
        return view(
            'admin.aktivitas.data.show_data_karyawan',
            ['data' => $data]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data_cabang()
    {
        return view('admin.aktivitas.show_cabang');
    }

    public function showDataCabang(Request $request)
    {
        $input      = $request->all();
        $cabang_id  = $input['id_cabang'];
        // $date       = $input['waktu'];
        // $temp       = explode("-", $date);
        // $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        // $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
        $data   = Aktivitas::leftJoin('users',         'users.id',             '=', 'cutis.id_user')
                            ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                            ->where('users.id_cabang', $cabang_id)->get();
        return view(
            'admin.aktivitas.data.show_data_cabang',
            ['data' => $data]
        );
    }
}

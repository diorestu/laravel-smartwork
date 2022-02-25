<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class LemburController extends Controller
{
    public function accept($id)
    {
        $result = Lembur::where('id', $id)->first();
        // dd($result);
        $result->lembur_status      = 'DITERIMA';
        $result->approve_by         = Auth::user()->id;
        $result->approve_date       = date("Y-m-d H:i:s");
        $result->save();
        try {
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Gagal! ' . $th);
        }
    }

    public function decline($id)
    {
        $result = Lembur::where('id', $id)->first();
        $result->lembur_status = 'DITOLAK';
        try {
            $result->save();
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Gagal! ' . $th);
        }
    }

    public function riwayat()
    {
        $id     = Auth::user()->id;
        $user   = User::where('id_admin', $id)->where('roles', 'user')->pluck('id')->toArray();
        $data   = Lembur::whereIn('id_user', $user)->where('lembur_status','!=','PENGAJUAN')->get();
        return view('admin.lembur.riwayat', ['data' => $data]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id     = Auth::user()->id;
        $user   = User::where('id_admin', $id)->where('roles', 'user')->pluck('id')->toArray();
        $data   = Lembur::whereIn('id_user', $user)->where('lembur_status', 'PENGAJUAN')->get();
        return view("admin.lembur.index", ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.lembur.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input                              = $request->all();
        $tambah_baru                        = new Lembur;
        $lembur_awal                        = $input['lembur_awal_tanggal'] . " " . $input['lembur_awal_waktu'];
        $lembur_akhir                       = $input['lembur_akhir_tanggal'] . " " . $input['lembur_akhir_waktu'];
        $tambah_baru->id_user               = $input['id_staff'];
        $tambah_baru->lembur_status         = $input['lembur_status'];
        $tambah_baru->lembur_awal           = $lembur_awal;
        $tambah_baru->lembur_akhir          = $lembur_akhir;
        $tambah_baru->lembur_judul          = $input['lembur_judul'];
        $tambah_baru->lembur_keterangan     = $input['lembur_keterangan'];
        $startTime                          = Carbon::parse($lembur_awal);
        $finishTime                         = Carbon::parse($lembur_akhir);
        $jamKerja                           = $startTime->diffInHours($finishTime);
        $tambah_baru->jam_kerja             = $jamKerja;
        $tambah_baru->jam_lembur            = $jamKerja;
        if ($input['lembur_status'] == "DITERIMA") {
            $tambah_baru->approve_by        = Auth::user()->id;
            $tambah_baru->approve_date      = date("Y-m-d H:i:s");
            $redirectIndex                  = 1;
        }
        else {
            $redirectIndex                  = 0;
        }
        $berhasilSimpan                     = $tambah_baru->save();
        if ($redirectIndex == 0) {
            if ($berhasilSimpan) {
                return redirect()->route('lembur.index')->with('success', 'Proses tambah data lembur pegawai berhasil');
            } else {
                return redirect()->route('lembur.index')->with('error', 'Gagal menambahkan data lembur pegawai');
            }
        }
        else {
            if ($berhasilSimpan) {
                return redirect()->route('lembur.riwayat')->with('success', 'Proses tambah data lembur pegawai berhasil');
            } else {
                return redirect()->route('lembur.riwayat')->with('error', 'Gagal menambahkan data lembur pegawai');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lembur  $lembur
     * @return \Illuminate\Http\Response
     */
    public function show(Lembur $lembur)
    {
        // detail sudah ada di index
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lembur  $lembur
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Lembur::findOrFail($id);
        return view('admin.lembur.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lembur  $lembur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input                       = $request->all();
        $data                        = Lembur::findOrFail($id);
        $lembur_awal                 = $input['lembur_awal_tanggal'] . " " . $input['lembur_awal_waktu'];
        $lembur_akhir                = $input['lembur_akhir_tanggal'] . " " . $input['lembur_akhir_waktu'];
        $data->id_user               = $input['id_staff'];
        $data->lembur_status         = $input['lembur_status'];
        $data->lembur_awal           = $lembur_awal;
        $data->lembur_akhir          = $lembur_akhir;
        $data->lembur_judul          = $input['lembur_judul'];
        $data->lembur_keterangan     = $input['lembur_keterangan'];
        $startTime                   = Carbon::parse($lembur_awal);
        $finishTime                  = Carbon::parse($lembur_akhir);
        $jamKerja                    = $startTime->diffInHours($finishTime);
        $data->jam_kerja             = $jamKerja;
        $data->jam_lembur            = $jamKerja;
        if ($input['lembur_status'] == "DITERIMA") {
            $data->approve_by        = Auth::user()->id;
            $data->approve_date      = date("Y-m-d H:i:s");
            $redirectIndex           = 1;
        } else {
            $data->approve_by        = NULL;
            $data->approve_date      = NULL;
            $redirectIndex           = 0;
        }
        $berhasilSimpan              = $data->save();
        if ($redirectIndex == 0) {
            if ($berhasilSimpan) {
                return redirect()->route('lembur.index')->with('success', 'Proses update data lembur pegawai berhasil');
            } else {
                return redirect()->route('lembur.index')->with('error', 'Gagal mengupdate data lembur pegawai');
            }
        } else {
            if ($berhasilSimpan) {
                return redirect()->route('lembur.riwayat')->with('success', 'Proses update data lembur pegawai berhasil');
            } else {
                return redirect()->route('lembur.riwayat')->with('error', 'Gagal mengupdate data lembur pegawai');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lembur  $lembur
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Lembur::findOrFail($id)->delete();
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
        return view('admin.lembur.show_karyawan');
    }

    public function showDataKaryawan(Request $request)
    {
        $input      = $request->all();
        $staff_id   = $input['id_staff'];
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
        $data       = Lembur::where('id_user', $staff_id)->whereBetween('lembur_awal', [$tawal, $takhir])->get();
        return view(
            'admin.lembur.data.show_data_karyawan',
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
        return view('admin.lembur.show_cabang');
    }

    public function showDataCabang(Request $request)
    {
        $input      = $request->all();
        $cabang_id  = $input['id_cabang'];
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
        $data   = Lembur::leftJoin('users',         'users.id',             '=', 'lemburs.id_user')
                        ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                        ->where('users.id_cabang', $cabang_id)->whereBetween('lemburs.lembur_awal', [$tawal, $takhir])->get();

        return view('admin.lembur.data.show_data_cabang',['data' => $data]);
    }
}

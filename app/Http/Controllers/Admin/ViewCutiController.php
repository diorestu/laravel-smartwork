<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CutiCabang;
use App\Exports\CutiPegawai;
use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;

class ViewCutiController extends Controller
{
    public function ekspor_cabangCuti($cabang)
    {
        return (new CutiCabang($cabang))->download('Riwayat Cuti Cabang ' . namaCabang($cabang).'.xlsx');
    }

    public function ekspor_pegawaiCuti($user)
    {
        return (new CutiPegawai($user))->download('Riwayat Absensi Pegawai ' . namaUser($user).'.xlsx');
    }

    public function accept($id){
        $result = Cuti::where('id_cuti', $id)->first();
        // dd($result);
        $result->cuti_status = 'DITERIMA';
        $result->save();
        try {
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Gagal! '. $th);
        }
    }

    public function decline($id){
        $result = Cuti::where('id_cuti', $id)->first();
        $result->cuti_status = 'DITOLAK';
        try {
            $result->save();
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Gagal! ' . $th);
        }
    }

    public function rekap(Request $request)
    {
        $sekarang = date("m/d/Y");
        if ($request->session()->has('cuti_pengajuan')) {
            $value      = $request->session()->get('cuti_pengajuan', 'default');
            $temp       = explode("-", $value);
            $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
            $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
            $id         = Auth::user()->id;
            $user       = User::where('id_admin', $id)->where('roles', 'user')->pluck('id')->toArray();
            $datacuti   = Cuti::whereIn('id_user', $user)
                                ->whereBetween('cuti_awal', [$tawal, $takhir])
                                ->where('cuti_status', 'DITERIMA')->get();
        } else {
            $value      = $sekarang . " - " . $sekarang;
            $datacuti   = null;
        }
        return view('admin.cuti.rekap', ['data' => $datacuti, 'sesi_cuti' => $value]);
    }
    public function showDataRekap(Request $request)
    {
        $input      = $request->all();
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
        $id         = Auth::user()->id;
        $user       = User::where('id_admin', $id)->where('roles', 'user')->pluck('id')->toArray();
        $data       = Cuti::whereIn('id_user', $user)
                            ->whereBetween('cuti_awal', [$tawal, $takhir])
                            ->where('cuti_status', 'DITERIMA')->get();

        $request->session()->put('cuti_pengajuan', $date);
        return view('admin.cuti.data.show_data_rekap', [
            'data' => $data,
        ]);
    }

    public function showDataPengajuan(Request $request)
    {
        $input      = $request->all();
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
        $id         = Auth::user()->id;
        $user       = User::where('id_admin', $id)->where('roles', 'user')->pluck('id')->toArray();
        $data       = Cuti::whereIn('id_user', $user)
                            ->whereBetween('cuti_awal', [$tawal, $takhir])
                            ->where('cuti_status', 'PENGAJUAN')->get();
        // dd($data);
        $request->session()->put('cuti_pengajuan', $date);
        return view('admin.cuti.data.show_data_pengajuan', [
            'data' => $data,
        ]);
    }
    public function index(Request $request)
    {
        $sekarang = date("m/d/Y");
        if ($request->session()->has('cuti_pengajuan')) {
            $value      = $request->session()->get('cuti_pengajuan', 'default');
            $temp       = explode("-", $value);
            $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
            $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
            $id         = Auth::user()->id;
            $user       = User::where('id_admin', $id)->where('roles', 'user')->pluck('id')->toArray();
            $datacuti   = Cuti::whereIn('id_user', $user)
                                ->whereBetween('cuti_awal', [$tawal, $takhir])
                                ->where('cuti_status', 'PENGAJUAN')->get();
        } else {
            $value      = $sekarang . " - " . $sekarang;
            $datacuti   = null;
        }
        return view('admin.cuti.index', ['data' => $datacuti, 'sesi_cuti' => $value]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cuti.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input                       = $request->all();
        $tambah_baru                 = new Cuti;
        $tambah_baru->id_user        = $input['id_staff'];
        $tambah_baru->cuti_deskripsi = $input['cuti_keterangan'];
        $tambah_baru->cuti_awal      = $input['cuti_awal'];
        $tambah_baru->cuti_total     = $input['cuti_total'];
        $tambah_baru->id_cuti_jenis  = $input['id_cuti_jenis'];
        $tambah_baru->cuti_status    = $input['cuti_status'];
        $days                        = "+" . $input['cuti_total'] . " days";
        $dt                          = new DateTime($input['cuti_awal']);
        $dt->modify($days);
        $cuti_akhir                  = $dt->format('Y-m-d');
        $tambah_baru->cuti_akhir     = $cuti_akhir;
        $berhasilSimpan              = $tambah_baru->save();
        if ($berhasilSimpan) {
            return redirect()->route('cuti.index')->with('success', 'Proses tambah data cuti pegawai berhasil');
        } else {
            return redirect()->route('cuti.index')->with('error', 'Gagal menambahkan data cuti pegawai');
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
        // detail sudah pada tabel index
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Cuti::findOrFail($id);
        return view('admin.cuti.edit', ['data' => $data]);
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
        $input                      = $request->all();
        $data                       = Cuti::findOrFail($id);
        $data->id_user              = $input['id_staff'];
        $data->cuti_deskripsi       = $input['cuti_keterangan'];
        $data->cuti_awal            = $input['cuti_awal'];
        $data->cuti_total           = $input['cuti_total'];
        $data->id_cuti_jenis        = $input['id_cuti_jenis'];
        $data->cuti_status          = $input['cuti_status'];
        $days                       = "+". $input['cuti_total']." days";
        $dt                         = new DateTime($input['cuti_awal']); $dt->modify($days);
        $cuti_akhir                 = $dt->format('Y-m-d');
        $data->cuti_akhir           = $cuti_akhir;
        $berhasilSimpan             = $data->save();
        if ($berhasilSimpan) {
            return redirect()->route('cuti.edit', $id)->with('success', 'Proses update data cuti pegawai berhasil');
        } else {
            return redirect()->route('cuti.edit', $id)->with('error', 'Gagal mengupdate data cuti pegawai');
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
            Cuti::findOrFail($id)->delete();
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
        return view('admin.cuti.show_karyawan');
    }

    public function showDataKaryawan(Request $request)
    {
        $input      = $request->all();
        $staff_id   = $input['id_staff'];
        $data   = Cuti::where('id_user', $staff_id)->get();
        return view(
            'admin.cuti.data.show_data_karyawan',
            ['data' => $data, 'user' => $staff_id]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data_cabang()
    {
        return view('admin.cuti.show_cabang');
    }

    public function showDataCabang(Request $request)
    {
        $input      = $request->all();
        $cabang_id  = $input['id_cabang'];
        $data   = Cuti::leftJoin('users',         'users.id',             '=', 'cutis.id_user')
                        ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                        ->where('users.id_cabang', $cabang_id)->get();

        return view(
            'admin.cuti.data.show_data_cabang',
            ['data' => $data, 'cabang' => $cabang_id]
        );
    }
}

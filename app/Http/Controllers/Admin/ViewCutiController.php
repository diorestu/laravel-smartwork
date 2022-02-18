<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DateTime;

class ViewCutiController extends Controller
{
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

    public function riwayat()
    {
        $id = Auth::user()->id;
        $user = User::where('id_admin', $id)->where('roles', 'user')->pluck('id')->toArray();
        $data = Cuti::whereIn('id_user', $user)->get();
        return view('admin.cuti.riwayat', [
            'data' => $data,
        ]);
    }

    public function index()
    {
        $id = Auth::user()->id;
        $user = User::where('id_admin', $id)->where('roles', 'user')->pluck('id')->toArray();
        $data = Cuti::whereIn('id_user', $user)->where('cuti_status', 'PENGAJUAN')->get();
        // dd($data);
        return view('admin.cuti.index', [
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
            return redirect()->route('cuti.riwayat')->with('success', 'Proses update data cuti pegawai berhasil');
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
}

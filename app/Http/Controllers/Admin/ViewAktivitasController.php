<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AktivitasCabang;
use App\Exports\AktivitasPegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\AktivitasImage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use DateTime;

class ViewAktivitasController extends Controller
{
    public function ekspor_cabangAktivitas($cabang, $awal, $akhir)
    {
        return (new AktivitasCabang($cabang, $awal, $akhir))->download('Riwayat Aktivitas Cabang ' . namaCabang($cabang) . ' Periode ' . Carbon::parse($awal)->format('d-m-Y') . " sd " . Carbon::parse($akhir)->format('d-m-Y') . '.xlsx');
    }

    public function ekspor_pegawaiAktivitas($user, $awal, $akhir)
    {
        return (new AktivitasPegawai($user, $awal, $akhir))->download('Riwayat Aktivitas Pegawai ' . namaUser($user) . ' Periode ' . Carbon::parse($awal)->format('d-m-Y') . " sd " . Carbon::parse($akhir)->format('d-m-Y') . '.xlsx');
    }
    // ULOAD IMAGES DROPZONE
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadImages(Request $request, $id)
    {
        $aktivitas  = Aktivitas::find($id);
        $nama       = $aktivitas->user->nama;
        $image      = $request->file('file');
        $fileInfo   = $image->getClientOriginalName();
        // $filename   = pathinfo($fileInfo, PATHINFO_FILENAME);
        $extension  = pathinfo($fileInfo, PATHINFO_EXTENSION);
        $file_name  = $nama . '-' . time() . '.' . $extension;
        $image->move(storage_path('app/public/aktivitas'), $file_name);

        $imageUpload                = new AktivitasImage;
        $imageUpload->aktivitas_id  = $id;
        $imageUpload->images        = $file_name;
        $imageUpload->save();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id)
    {
        $aktivitas      = AktivitasImage::where('id', $id)->first();
        $idaktivitas    = $aktivitas->aktivitas_id;
        $filename       = $aktivitas->images;
        $success        = $aktivitas->delete();
        if ($success) {
            $path = storage_path("app/public/aktivitas/".$filename);
            $msg = File::delete($path);
            if ($msg) {
                return redirect()->route('aktivitas.show', $idaktivitas)->with('success', 'Berhasil menghapus foto aktivitas');
            } else {
                return redirect()->route('aktivitas.show', $idaktivitas)->with('success', 'Berhasil menghapus foto aktivitas');
            }
        } else {
            return redirect()->route('aktivitas.show', $idaktivitas)->with('error', 'Gagal menghapus foto aktivitas');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date   = date("2022-02-21");
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
        $data       = Aktivitas::where('id', '=', $id)->first();
        $data_img   = AktivitasImage::where('aktivitas_id', '=', $id)->get();
        if ($data != null) {
            return view('admin.aktivitas.detail', ['data' => $data, 'data_image' => $data_img]);
        } else {
            return redirect()->route('aktivitas.index')->with('error', 'Tidak mendapatkan id aktivitas');
        }
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
            return redirect()->route('aktivitas.show', $data->id)->with('success', 'Proses update aktivitas pegawai berhasil');
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
    public function riwayat(Request $request)
    {
        $sekarang = date("m/d/Y");
        if ($request->session()->has('aktivitas')) {
            $value      = $request->session()->get('aktivitas', 'default');
            $cabang     = $request->session()->get('aktivitas_cabang', 'default');
            $temp       = explode("-", $value);
            $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
            $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
            $dataaktivi = Aktivitas::leftJoin('users',          'users.id',             '=', 'aktivitas.id_user')
                                    ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                                    ->where('users.id_cabang', $cabang)
                                    ->whereBetween('aktivitas.created_at', [$tawal, $takhir])->get();
        } else {
            $cabang     = null;
            $value      = $sekarang . " - " . $sekarang;
            $dataaktivi   = null;
        }
        return view('admin.aktivitas.riwayat', ['data' => $dataaktivi, 'cabang' => $cabang, 'sesi_aktivitas' => $value]);
    }
    public function showDataRiwayat(Request $request)
    {
        $input      = $request->all();
        $cabang     = $input['id_cabang'];
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));

        $data       = Aktivitas::leftJoin('users',          'users.id',             '=', 'aktivitas.id_user')
                                ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                                ->where('users.id_cabang', $cabang)
                                ->whereBetween('aktivitas.created_at', [$tawal, $takhir])->get();
        $request->session()->put('aktivitas', $date);
        $request->session()->put('aktivitas_cabang', $cabang);
        return view(
            'admin.aktivitas.data.show_data_riwayat', [
                'data'      => $data,
                'cabang'    => $cabang,
                'awal'      => $tawal,
                'akhir'     => $takhir,
            ]
        );
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
            'admin.aktivitas.data.show_data_karyawan',[
                'data' => $data,
                'user' => $staff_id,
                'awal' => $tawal,
                'akhir' => $takhir,
            ]
        );
    }
}

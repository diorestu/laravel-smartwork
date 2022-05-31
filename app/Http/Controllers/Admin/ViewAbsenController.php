<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AbsensiCabang;
use App\Exports\AbsensiHarianExport;
use App\Exports\AbsensiPegawai;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\AbsensiImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class ViewAbsenController extends Controller
{
    public function ekspor_riwayatAbsensi($hari) {
        return (new AbsensiHarianExport($hari))->download('Riwayat Absensi Pegawai ' . tanggalIndo3($hari) .'.xlsx');
    }

    public function ekspor_cabangAbsensi($cabang, $awal, $akhir)
    {
        return (new AbsensiCabang($cabang, $awal, $akhir))->download('Riwayat Absensi Cabang ' . namaCabang($cabang) . ' Periode '. Carbon::parse($awal)->format('d-m-Y')." sd ".Carbon::parse($akhir)->format('d-m-Y'). '.xlsx');
    }

    public function ekspor_pegawaiAbsensi($user, $awal, $akhir)
    {
        return (new AbsensiPegawai($user, $awal, $akhir))->download('Riwayat Absensi Pegawai ' . namaUser($user) .' Periode ' . Carbon::parse($awal)->format('d-m-Y') . " sd " . Carbon::parse($akhir)->format('d-m-Y') . '.xlsx');
    }
    // ULOAD IMAGES DROPZONE
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadImages(Request $request, $tipe, $id)
    {
        $absen      = Absensi::find($id);
        $nama       = $absen->user->nama;
        $absen_jam  = $absen->jam_hadir;
        $image      = $request->file('file');
        $fileInfo   = $image->getClientOriginalName();
        // $filename   = pathinfo($fileInfo, PATHINFO_FILENAME);
        $extension  = pathinfo($fileInfo, PATHINFO_EXTENSION);
        $file_name  = $nama . '-' . time() . '.' . $extension;
        $image->move(storage_path('app/public/absen'), $file_name);

        $tipe                       = $tipe;
        $imageUpload                = new AbsensiImage;
        $imageUpload->absensi_id    = $id;
        $imageUpload->absen_tipe    = $tipe;
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
        $absen     = AbsensiImage::where('id', $id)->first();
        $idabsen   = $absen->absensi_id;
        $filename  = $absen->images;
        $success   = $absen->delete();
        if ($success) {
            $path = storage_path("app/public/absen/" . $filename);
            $msg = File::delete($path);
            if ($msg) {
                return redirect()->route('absensi.show', $idabsen)->with('success', 'Berhasil menghapus foto absensi');
            } else {
                return redirect()->route('absensi.show', $idabsen)->with('success', 'Berhasil menghapus foto absensi');
            }
        } else {
            return redirect()->route('absensi.show', $idabsen)->with('error', 'Gagal menghapus foto absensi');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id     = Auth::user()->id;
        $date   = date('Y-m-d');
        $data   = Absensi::select(['absensis.id', 'cabang_nama', 'absensis.id_user', 'jam_hadir', 'jam_pulang', 'nama_shift', 'ket_shift', 'hadir_shift', 'pulang_shift', 'jam_kerja',])
                        ->leftJoin('users',         'users.id',             '=', 'absensis.id_user')
                        ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                        ->leftJoin('user_shifts',   'user_shifts.id_user',  '=', 'users.id')
                        ->leftJoin('shifts',        'shifts.id',            '=', 'user_shifts.id_user_shift')
                        ->whereDate('user_shifts.tanggal_shift',            '=', $date)
                        ->whereDate('absensis.jam_hadir',                   '=', $date)
                        ->orWhere('user_shifts.id_user_shift',              '=', NULL)
                        ->where('users.id_admin', $id)->get();

        $gak_absen  =   User::select(['users.id', 'users.nama', 'users.id_cabang', 'shifts.ket_shift', 'shifts.hadir_shift', 'shifts.pulang_shift', 'shifts.nama_shift'])
                        ->leftJoin('user_shifts',   'user_shifts.id_user',  '=', 'users.id')
                        ->leftJoin('shifts',        'shifts.id',            '=', 'user_shifts.id_user_shift')
                        ->whereNotIn('users.id', function ($query) use ($date) {
                            $query->select('absensis.id_user')->from('absensis')->whereDate('absensis.jam_hadir', $date)->groupBy('absensis.id_user');
                        })
                        ->where('user_shifts.tanggal_shift',            '=', $date)
                        ->orWhere('user_shifts.id_user_shift',          '=', NULL)
                        ->where('users.roles', 'user')
                        ->where('users.id_admin', $id)->get();
        // dd($gak_absen);

        return view('admin.absensi.index',
            ['data' => $data, 'data_belum_absen' => $gak_absen]
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
        $id_user                    = $input['id_staff'];
        $data                       = User::select(['cabang_lat', 'cabang_long'])
                                                ->join('cabangs', 'cabangs.id', '=', 'users.id_cabang')
                                                ->where('users.id',             '=', $id_user)
                                                ->where('users.id_admin', $idAdmin)->first();
        $lat                        = $data->cabang_lat;
        $long                       = $data->cabang_long;
        $waktu_hadir                = $input['tgl_hadir'] . " " . $input['jam_hadir'];
        if ($input['tgl_pulang']    == "") {
            $waktu_pulang           = null;
            $lat_pulang             = null;
            $long_pulang            = null;
        } else {
            $waktu_pulang           = $input['tgl_pulang'] . " " . $input['jam_pulang'];
            $lat_pulang             = $lat;
            $long_pulang            = $long;
        }
        $tambah_baru->id_user       = $id_user;
        $tambah_baru->jam_hadir     = $waktu_hadir;
        $tambah_baru->jam_pulang    = $waktu_pulang;
        $tambah_baru->ket_hadir     = $input['ket_hadir'];
        $tambah_baru->lat_hadir     = $lat;
        $tambah_baru->long_hadir    = $long;
        $tambah_baru->lat_pulang    = $lat_pulang;
        $tambah_baru->long_pulang   = $long_pulang;

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
                                    ->leftJoin('users',         'users.id',             '=', 'absensis.id_user')
                                    ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                                    ->leftJoin('user_shifts',   'user_shifts.id_user',  '=', 'users.id')
                                    ->leftJoin('shifts',        'shifts.id',            '=', 'user_shifts.id_user_shift')
                                    ->where('absensis.id',                          '=', $id)
                                    ->orWhere('user_shifts.id_user_shift',          '=', NULL)->first();

        $data_img = AbsensiImage::where('absensi_id', '=', $id)->get();
        // dd($data_img);
        if ($data != null) {
            return view('admin.absensi.detail', ['data' => $data, 'data_image' => $data_img]);
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data_karyawan() {
        return view('admin.absensi.show_karyawan');
    }
    public function showDataKaryawan(Request $request)
    {
        $input      = $request->all();
        $staff_id   = $input['id_staff'];
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
        $data   = Absensi::select(['absensis.id', 'absensis.id_user', 'absensis.jam_hadir', 'absensis.jam_pulang', 'absensis.jam_kerja', 'cabangs.cabang_nama'])
                            ->leftJoin('users',         'users.id',             '=', 'absensis.id_user')
                            ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                            ->whereBetween('absensis.jam_hadir',                 [$tawal, $takhir])
                            ->where('absensis.id_user', $staff_id)->get();

        return view(
            'admin.absensi.data.show_data_karyawan',[
                'data' => $data,
                'user' => $staff_id,
                'awal' => $tawal,
                'akhir' => $takhir]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data_cabang()
    {
        return view('admin.absensi.show_cabang');
    }
    public function showDataCabang(Request $request)
    {
        $input      = $request->all();
        $cabang_id  = $input['id_cabang'];
        $date       = $input['waktu'];
        $temp       = explode("-", $date);
        $tawal      = inverttanggal(str_replace(' ', '', $temp[0]));
        $takhir     = inverttanggal(str_replace(' ', '', $temp[1]));
        $data       = Absensi::select(['absensis.id', 'absensis.id_user', 'absensis.jam_hadir', 'absensis.jam_pulang', 'absensis.jam_kerja', 'cabangs.cabang_nama'])
                                ->leftJoin('users',         'users.id',             '=', 'absensis.id_user')
                                ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                                ->whereBetween('absensis.jam_hadir',                 [$tawal, $takhir])
                                ->where('users.id_cabang', $cabang_id)->get();

        return view(
            'admin.absensi.data.show_data_cabang',[
                'data' => $data,
                'cabang' => $cabang_id,
                'awal' => $tawal,
                'akhir' => $takhir,
                ]
        );
    }

    public function data_riwayat()
    {
        return view("admin.absensi.riwayat");
    }
    public function showDataRiwayat(Request $request)
    {
        $input  = $request->all();
        $date   = ($input['hari']);
        $id     = Auth::user()->id;
        $data   = Absensi::select(['absensis.id', 'cabang_nama', 'absensis.id_user', 'jam_hadir', 'jam_pulang', 'nama_shift', 'ket_shift', 'hadir_shift', 'pulang_shift', 'jam_kerja',])
                            ->leftJoin('users',         'users.id',             '=', 'absensis.id_user')
                            ->leftJoin('cabangs',       'cabangs.id',           '=', 'users.id_cabang')
                            ->leftJoin('user_shifts',   'user_shifts.id_user',  '=', 'users.id')
                            ->leftJoin('shifts',        'shifts.id',            '=', 'user_shifts.id_user_shift')
                            ->where('user_shifts.tanggal_shift',            '=', $date)
                            ->whereDate('absensis.jam_hadir',               '=', $date)
                            ->orWhere('user_shifts.id_user_shift',          '=', NULL)
                            ->where('users.id_admin', $id)->get();

        $gak_absen  =   User::select(['users.id', 'users.nama', 'users.id_cabang', 'shifts.ket_shift', 'shifts.hadir_shift', 'shifts.pulang_shift', 'shifts.nama_shift'])
                                ->leftJoin('user_shifts',   'user_shifts.id_user',  '=', 'users.id')
                                ->leftJoin('shifts',        'shifts.id',            '=', 'user_shifts.id_user_shift')
                                ->whereNOTIn('users.id', function ($query) use ($date) {
                                    $query->select('absensis.id_user')->from('absensis')->whereDate('absensis.jam_hadir', $date)->groupBy('absensis.id_user');
                                })
                                    ->where('user_shifts.tanggal_shift',            '=', $date)
                                    ->orWhere('user_shifts.id_user_shift',          '=', NULL)
                                    ->where('users.roles', 'user')
                                    ->where('users.id_admin', $id)->get();
        // dd($data);
        return view("admin.absensi.data.data_riwayat", [
            'data' => $data,
            'data_belum_absen' => $gak_absen,
            'hari' => $date,
        ]);
    }
}

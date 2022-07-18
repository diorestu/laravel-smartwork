<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserExport;
use App\Models\User;
use App\Models\Asuransi;
use App\Models\MasaKerja;
use App\Models\UserTunjangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserConfig;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function ekspor_pegawai()
    {
        return Excel::download(new UserExport, 'Database Pegawai.xlsx');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id       = Auth::user()->id;
        $data     = User::select(['id', 'id_cabang', 'nip', 'nama', 'email', 'phone', 'username', 'status'])->where('id_admin', $id)->where('is_admin', 0)->get();
        $count_user = User::where('id_admin', $id)->count();
        $max_user = UserConfig::where('id_admin', $id)->first()->max_user;
        if ($count_user > $max_user) {
            $btn = true;
        }else{
            $btn = false;
        }
        // dd($count_user);
        return view('admin.staff.index',[
            'data' => $data,
            'btn' => $btn
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $idAdmin            = Auth::user()->id;
        $data               = $request->all();
        $data['password']   = bcrypt($request->password);
        // dd($data);
        $tambah_baru                        = new User;
	    $tambah_baru->id_admin              = $idAdmin;
	    $tambah_baru->id_cabang             = $data['id_cabang'];
	    $tambah_baru->id_divisi             = 0;
	    $tambah_baru->id_jabatan            = 0;
	    $tambah_baru->id_sertifikasi        = 0;
	    $tambah_baru->nama                  = $data['nama'];
	    $tambah_baru->nip                   = $data['nip'];
	    $tambah_baru->username              = $data['username'];
	    $tambah_baru->gender                = "Pria";
	    $tambah_baru->status                = "active";
	    $tambah_baru->tanggungan            = 0;
	    $tambah_baru->tanggal_mulaiKerja    = date("Y-m-d");
	    $tambah_baru->id_masaKerja          = 0;
	    $tambah_baru->roles                 = "user";
	    $tambah_baru->alamat                = "";
	    $tambah_baru->email                 = "";
	    $tambah_baru->phone                 = $data['phone'];
	    $tambah_baru->no_rek                = 0;
	    $tambah_baru->npwp                  = 0;
	    $tambah_baru->company               = "";
	    $tambah_baru->company_logo          = "";
	    $tambah_baru->is_admin              = false;
	    $tambah_baru->password              = $data['password'];
        $berhasilTambah                     = $tambah_baru->save();
        if ($berhasilTambah) {
            return redirect()->route('pegawai.edit', $tambah_baru->id)->with('success', 'Pegawai baru berhasil ditambahkan'); }
        else {
            return redirect()->back()->with('error', "Gagal menambahkan pegawai baru"); }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data           = User::findOrFail($id);
        $dataAsuransi   = Asuransi::where('id_user', '=', $id)->first();
        $dataTunjangan  = UserTunjangan::where('id_user', '=', $id)->first();
        return view('admin.staff.detail',
        [
            'data' => $data,
            'dataAsuransi' => $dataAsuransi,
            'dataTunjangan' => $dataTunjangan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nonActive($id)
    {
        $data           = User::findOrFail($id);
        $data->status   = 'non active';
        $berhasil       = $data->save();
        if ($berhasil) {
            return redirect()->route('pegawai.show', $data['id'])->with('success', 'Proses Non Aktif Pegawai Berhasil');
        } else {
            return redirect()->route('pegawai.show', $data['id'])->with('error', 'Gagal Menonaktifkan Pegawai');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        $data           = User::findOrFail($id);
        $data->status   = 'active';
        $berhasil       = $data->save();
        if ($berhasil) {
            return redirect()->route('pegawai.show', $data['id'])->with('success', 'Proses Aktivasi Pegawai Berhasil');
        } else {
            return redirect()->route('pegawai.show', $data['id'])->with('error', 'Gagal Aktivasi Pegawai');
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
        $data           = User::findOrFail($id);
        $dataAsuransi   = Asuransi::where('id_user', '=', $id)->first();
        $dataTunjangan  = UserTunjangan::where('id_user', '=', $id)->first();
        if ($dataAsuransi == null) { $dataAsuransi = ""; }
        // dd($data);
        return view('admin.staff.edit',
            [
              'data' => $data,
              'dataAsuransi' => $dataAsuransi,
              'dataTunjangan' => $dataTunjangan,
            ]);
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
        $id_admin                   = Auth::user()->id;
        $input                      = $request->all();
        $data                       = User::findOrFail($id);
        // data diri
        $data->nip                  = $input['nip'];
        $data->nama                 = $input['nama'];
        $data->tanggal_mulaiKerja   = $input['tanggal_mulaiKerja'];
        $tahun_kerja                = getTahunKerja($input['tanggal_mulaiKerja']);
        $masa_kerja                 = MasaKerja::where('id_admin', '=', $id_admin)->where('masa_kerja', '=', $tahun_kerja)->first();
        if ($masa_kerja != null) {
            $data->id_masaKerja     = $masa_kerja->id; }
        else {
            if ($tahun_kerja != 0) {
                // masa kerja kurang dari 1 tahun
                $data->id_masaKerja = 0; }
            else {
                // cari id masa kerja paling lama
                $masa_kerja_last    = MasaKerja::where('id_admin', '=', $id_admin)->orderBy('masa_kerja', 'desc')->limit(1)->first();
                $data->id_masaKerja = $masa_kerja_last->id; }
        }
        $data->gender               = $input['gender'];
        $data->phone                = $input['phone'];
        $data->email                = $input['email'];
        $data->tanggungan           = $input['tanggungan'];
        $data->alamat               = $input['alamat'];
        // akun
        $data->username             = $input['username'];
        $data->status               = $input['status'];
        $data->id_divisi            = $input['id_divisi'];
        $data->id_jabatan           = $input['id_jabatan'];
        $data->id_cabang            = $input['id_cabang'];
        $data->company              = $input['company'];
        $data->no_rek               = $input['no_rek'];
        $data->npwp               = $input['npwp'];
        $data->id_sertifikasi       = $input['id_sertifikasi'];
        $berhasil                   = $data->save();
        if ($berhasil) {
            // asuransi
            $dataAsuransi                   = Asuransi::where('id_user', '=', $id)->first();
            if ($dataAsuransi != null) {
                $dataAsuransi->status_nakes = $input['status_nakes'];
                $dataAsuransi->nomor_nakes  = $input['nomor_nakes'];
                $dataAsuransi->pot_nakes    = $input['pot_nakes'];
                $dataAsuransi->status_naker = $input['status_naker'];
                $dataAsuransi->nomor_naker  = $input['nomor_naker'];
                $dataAsuransi->pot_naker    = $input['pot_naker'];
                $berhasilAsuransi           = $dataAsuransi->save();
            }
            else {
                $dataAsuransi               = new Asuransi;
                $dataAsuransi->id_user      = $id;
                $dataAsuransi->status_nakes = $input['status_nakes'];
                $dataAsuransi->nomor_nakes  = $input['nomor_nakes'];
                $dataAsuransi->pot_nakes    = $input['pot_nakes'];
                $dataAsuransi->status_naker = $input['status_naker'];
                $dataAsuransi->nomor_naker  = $input['nomor_naker'];
                $dataAsuransi->pot_naker    = $input['pot_naker'];
                $berhasilAsuransi           = $dataAsuransi->save();
            }
            if ($berhasilAsuransi) {
                // tunjangan
                $dataTunjangan                      = UserTunjangan::where('id_user', '=', $id)->first();
                if ($dataTunjangan != null) {
                    $dataTunjangan->tj_jabatan      = $input['tj_jabatan'];
                    $dataTunjangan->tj_sertifikasi  = $input['tj_sertifikasi'];
                    $dataTunjangan->tj_statusKawin  = $input['tj_statusKawin'];
                    $dataTunjangan->tj_masaKerja    = $input['tj_masaKerja'];
                    $dataTunjangan->tj_makan        = $input['tj_makan'];
                    $dataTunjangan->tj_transport    = $input['tj_transport'];
                    $dataTunjangan->tj_kosmetik     = $input['tj_kosmetik'];
                    $dataTunjangan->tj_lain         = $input['tj_lain'];
                    $berhasilTunjangan              = $dataTunjangan->save();
                } else {
                    $dataTunjangan                  = new UserTunjangan;
                    $dataTunjangan->id_user         = $id;
                    $dataTunjangan->tj_jabatan      = $input['tj_jabatan'];
                    $dataTunjangan->tj_sertifikasi  = $input['tj_sertifikasi'];
                    $dataTunjangan->tj_statusKawin  = $input['tj_statusKawin'];
                    $dataTunjangan->tj_masaKerja    = $input['tj_masaKerja'];
                    $dataTunjangan->tj_makan        = $input['tj_makan'];
                    $dataTunjangan->tj_transport    = $input['tj_transport'];
                    $dataTunjangan->tj_kosmetik     = $input['tj_kosmetik'];
                    $dataTunjangan->tj_lain         = $input['tj_lain'];
                    $berhasilTunjangan              = $dataTunjangan->save();
                }
                if ($berhasilTunjangan) {
                    return redirect()->route('pegawai.show', $data['id'])->with('success', 'Proses Update Data Pegawai Berhasil'); }
                else {
                    return redirect()->route('pegawai.edit', $id)->with('error', 'Gagal Mengupdate Data Pegawai'); }
            }
            else {
                return redirect()->route('pegawai.edit', $id)->with('error', 'Gagal Mengupdate Data Pegawai'); }
        }
        else {
            return redirect()->route('pegawai.edit', $id)->with('error', 'Gagal Mengupdate Data Pegawai'); }
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
            User::findOrFail($id)->delete();
            return "ok";
            // return redirect()->route('pegawai.index')->with('success', 'Berhasil Hapus Data');
        } catch (\Throwable $th) {
            return $th;
            // return redirect()->route('pegawai.index')->with('error', $th);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uploadFotoPegawai(Request $request)
    {
        $folderPath     = storage_path('app/public/uploads/');
        $image_parts    = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type     = $image_type_aux[1];
        $image_base64   = base64_decode($image_parts[1]);
        $imageName      = uniqid() . '.png';
        $imageFullPath  = $folderPath . $imageName;
        file_put_contents($imageFullPath, $image_base64);
        $id                         = $request->id;
        $data                       = User::findOrFail($id);
        $data->company_logo         = $imageName;
        $berhasil                   = $data->save();
        if ($berhasil) {
            return '<img src="'. asset("storage/uploads/$imageName") .'" class="d-block w-100" />'; }
        else {
            return "gagal"; }
    }
}

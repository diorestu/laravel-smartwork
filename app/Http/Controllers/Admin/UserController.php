<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Asuransi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $data = User::select(['id', 'id_cabang', 'nip', 'nama', 'email', 'phone', 'username', 'status'])->where('id_admin', $id)->where('is_admin', 0)->get();
        return view('admin.staff.index',[
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
        $id                 = Auth::user()->id;
        $data               = $request->all();
        $data['id_admin']   = $id;
        $data['roles']      = 'user';
        $data['status']     = 'active';
        $data['is_admin']   = false;
        $data['password']   = bcrypt($request->password);
        // dd($data);
        try {
            $send = User::create($data);
            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th);
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
        $data = User::findOrFail($id);
        return view('admin.staff.detail', ['data' => $data]);
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
        $data = User::findOrFail($id);
        // dd($data);
        return view('admin.staff.edit', ['data' => $data]);
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
        $data                       = User::findOrFail($id);
        // data diri
        $data->nip                  = $input['nip'];
        $data->nama                 = $input['nama'];
        $data->tanggal_mulaiKerja   = $input['tanggal_mulaiKerja'];
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
                return redirect()->route('pegawai.show', $data['id'])->with('success', 'Proses Update Data Pegawai Berhasil'); }
            else {
                return view('admin.staff.edit', ['data' => $data])->with('error', 'Berhasil Mengupdate Data Pegawai'); }
            // tunjangan
        }
        else {
            return view('admin.staff.edit', ['data' => $data])->with('error', 'Berhasil Mengupdate Data Pegawai'); }
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
            return redirect()->route('pegawai.index')->with('success', 'Berhasil Hapus Data');
        } catch (\Throwable $th) {
            return redirect()->route('pegawai.index')->with('error', $th);
        }
    }
}

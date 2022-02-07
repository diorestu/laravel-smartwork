<?php

namespace App\Http\Controllers;

use App\Models\Sertifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SertifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $data = Sertifikasi::select(['id','sertifikasi_title', 'sertifikasi_tunjangan'])->where('id_admin', $id)->get();
        return view('admin.sertifikasi.index', [
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
        // pop up on index
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $idAdmin                            = Auth::user()->id;
        $data                               = $request->all();
        $tambah_baru                        = new Sertifikasi;
        $tambah_baru->id_admin              = $idAdmin;
        $tambah_baru->sertifikasi_title     = $data['sertifikasi_title'];
        $tambah_baru->sertifikasi_tunjangan = $data['sertifikasi_tunjangan'];
        $berhasilTambah                     = $tambah_baru->save();
        if ($berhasilTambah) {
            return redirect()->route('sertifikasi.index')->with('success', 'Sertifikasi baru berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', "Gagal menambahkan sertifikasi baru");
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
        //
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data           = Sertifikasi::findOrFail($id);
        return view(
            'admin.sertifikasi.edit',
            ['data' => $data]
        );
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
        $id_admin                    = Auth::user()->id;
        $input                       = $request->all();
        $data                        = Sertifikasi::findOrFail($id);
        $data->sertifikasi_title     = $input['sertifikasi_title'];
        $data->sertifikasi_tunjangan = $input['sertifikasi_tunjangan'];
        $cekJudul                    = Sertifikasi::where('sertifikasi_title', '=', $input['sertifikasi_title'])->where('id_admin', '=', $id_admin)->where('id', '!=', $id)->first();
        if ($cekJudul != null) {
            return redirect()->route('sertifikasi.edit', $id)->with('error', 'Nama sertifikasi sudah tersedia');
        } else {
            $berhasilSimpan             = $data->save();
            if ($berhasilSimpan) {
                return redirect()->route('sertifikasi.index')->with('success', 'Proses update data sertifikasi berhasil');
            } else {
                return redirect()->route('sertifikasi.edit', $id)->with('error', 'Gagal mengupdate data sertifikasi');
            }
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
            Sertifikasi::findOrFail($id)->delete();
            return "ok";
        } catch (\Throwable $th) {
            return $th;
        }
    }
}

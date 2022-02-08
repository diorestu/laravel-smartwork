<?php

namespace App\Http\Controllers;

use App\Models\MasaKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasaKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $data = MasaKerja::select(['id', 'masa_kerja', 'masa_kerja_tunjangan'])->where('id_admin', $id)->get();
        return view('admin.masa_kerja.index', [
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
        $tambah_baru                        = new MasaKerja;
        $tambah_baru->id_admin              = $idAdmin;
        $tambah_baru->masa_kerja            = $data['masa_kerja'];
        $tambah_baru->masa_kerja_tunjangan  = $data['masa_kerja_tunjangan'];
        $berhasilTambah                     = $tambah_baru->save();
        if ($berhasilTambah) {
            return redirect()->route('masa-kerja.index')->with('success', 'Sertifikasi baru berhasil ditambahkan');
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
        $data           = MasaKerja::findOrFail($id);
        return view(
            'admin.masa_kerja.edit',
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
        $data                        = MasaKerja::findOrFail($id);
        $data->masa_kerja            = $input['masa_kerja'];
        $data->masa_kerja_tunjangan  = $input['masa_kerja_tunjangan'];
        $cekJudul                    = MasaKerja::where('masa_kerja', '=', $input['masa_kerja'])->where('id_admin', '=', $id_admin)->where('id', '!=', $id)->first();
        if ($cekJudul != null) {
            return redirect()->route('masa-kerja.edit', $id)->with('error', 'Masa kerja sudah tersedia');
        } else {
            $berhasilSimpan             = $data->save();
            if ($berhasilSimpan) {
                return redirect()->route('masa-kerja.index')->with('success', 'Proses update data masa kerja berhasil');
            } else {
                return redirect()->route('masa-kerja.edit', $id)->with('error', 'Gagal mengupdate data masa kerja');
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
            MasaKerja::findOrFail($id)->delete();
            return "ok";
        } catch (\Throwable $th) {
            return $th;
        }
    }
}

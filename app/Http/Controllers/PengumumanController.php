<?php

namespace App\Http\Controllers;

use App\Exports\PengumumanExport;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PengumumanController extends Controller
{
    public function ekspor_pengumuman()
    {
        return Excel::download(new PengumumanExport, 'Data Pengumuman.xlsx');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $id     = Auth::user()->id;
        $data   = Pengumuman::where('id_admin', $id)->get();
        return view('admin.pengumuman.index', [
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
        return view("admin.pengumuman.create");
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
        $id_admin                           = Auth::user()->id;
        $input                              = $request->all();
        $tambah_baru                        = new Pengumuman;
        $tambah_baru->id_admin              = $id_admin;
        $tambah_baru->id_divisi             = $input['id_divisi'];
        $tambah_baru->judul_pengumuman      = $input['judul_pengumuman'];
        $tambah_baru->desc_pengumuman       = $input['deskripsi_pengumuman'];
        $berhasilTambah                     = $tambah_baru->save();
        if ($berhasilTambah) {
            return redirect()->route('pengumuman.index')->with('success', 'Pengumuman baru berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', "Gagal menambahkan pengumuman baru");
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data   = Pengumuman::where('id', $id)->first();
        return view('admin.pengumuman.edit', [
            'data' => $data,
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
        $data                       = Pengumuman::findOrFail($id);
        $data->id_divisi            = $input['id_divisi'];
        $data->judul_pengumuman     = $input['judul_pengumuman'];
        $data->desc_pengumuman      = $input['deskripsi_pengumuman'];
        $cekJudul                   = Pengumuman::where('judul_pengumuman', '=', $input['judul_pengumuman'])->where('id_admin', '=', $id_admin)->where('id', '!=', $id)->first();
        if ($cekJudul != null) {
            return redirect()->route('pengumuman.edit', $id)->with('error', 'Pengumuman sudah ada sebelumnya');
        } else {
            $berhasilSimpan             = $data->save();
            if ($berhasilSimpan) {
                return redirect()->route('pengumuman.index')->with('success', 'Proses update data pengumuman berhasil');
            } else {
                return redirect()->route('pengumuman.edit', $id)->with('error', 'Gagal mengupdate data pengumuman');
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
        //
        try {
            Pengumuman::findOrFail($id)->delete();
            return "ok";
        } catch (\Throwable $th) {
            return $th;
        }
    }
}

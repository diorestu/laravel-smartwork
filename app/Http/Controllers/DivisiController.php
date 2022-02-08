<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id     = Auth::user()->id;
        $data   = Divisi::select(['div_id', 'div_title', 'div_desc'])->where('id_admin', $id)->get();
        return view('admin.divisi.index', ['data' => $data]);
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
        $tambah_baru                        = new Divisi;
        $tambah_baru->id_admin              = $idAdmin;
        $tambah_baru->div_title             = $data['div_title'];
        $tambah_baru->div_desc              = $data['div_desc'];
        $berhasilTambah                     = $tambah_baru->save();
        if ($berhasilTambah) {
            return redirect()->route('divisi.index')->with('success', 'Divisi baru berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', "Gagal menambahkan divisi baru");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function show(Divisi $divisi)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($divisi)
    {
        $data = Divisi::findOrFail($divisi);
        return view('admin.divisi.edit',['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $divisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $divisi)
    {
        $id_admin                   = Auth::user()->id;
        $input                      = $request->all();
        $data                       = Divisi::findOrFail($divisi);
        $data->div_title            = $input['div_title'];
        $data->div_desc             = $input['div_desc'];
        $cekJudul                   = Divisi::where('div_title', '=', $input['div_title'])->where('id_admin', '=', $id_admin)->where('div_id', '!=', $divisi)->first();
        if ($cekJudul != null) {
            return redirect()->route('divisi.edit', $divisi)->with('error', 'Nama divisi sudah tersedia');
        } else {
            $berhasilSimpan             = $data->save();
            if ($berhasilSimpan) {
                return redirect()->route('divisi.index')->with('success', 'Proses update data divisi berhasil');
            } else {
                return redirect()->route('divisi.edit', $divisi)->with('error', 'Gagal mengupdate data divisi');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $divisi
     * @return \Illuminate\Http\Response
     */
    public function destroy($divisi)
    {
        try {
            Divisi::findOrFail($divisi)->delete();
            return "ok";
        } catch (\Throwable $th) {
            return $th;
        }
    }
}

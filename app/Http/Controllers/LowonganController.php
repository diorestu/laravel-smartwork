<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id       = Auth::user()->id;
        $data     = Lowongan::where('id_admin', $id)->get();
        return view('admin.lowongan.index', [
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
        $idAdmin                = Auth::user()->id;
        $data                   = $request->all();
        $tambah_baru            = new Lowongan;
        $tambah_baru->id_admin  = $idAdmin;
        $tambah_baru->judul     = $data['judul'];
        $tambah_baru->deskripsi = $data['deskripsi'];
        $tambah_baru->exp_date  = $data['exp_date'];
        $berhasilTambah         = $tambah_baru->save();
        if ($berhasilTambah) {
            return redirect()->route('lowongan.edit', $tambah_baru->id)->with('success', 'Lowongan baru berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', "Gagal menambahkan Lowongan baru");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lowongan  $lowongan
     * @return \Illuminate\Http\Response
     */
    public function show(Lowongan $lowongan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lowongan  $lowongan
     * @return \Illuminate\Http\Response
     */
    public function edit(Lowongan $lowongan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lowongan  $lowongan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lowongan $lowongan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lowongan  $lowongan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lowongan $lowongan)
    {
        //
    }
}

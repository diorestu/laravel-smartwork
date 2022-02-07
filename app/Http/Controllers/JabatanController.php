<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::user()->id;
        $data = Jabatan::select(['jabatan_id', 'jabatan_title', 'jabatan_tunjangan'])->where('id_admin', $id)->get();
        return view('admin.jabatan.index', [
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
        $idAdmin                            = Auth::user()->id;
        $data                               = $request->all();
        $tambah_baru                        = new Jabatan;
        $tambah_baru->id_admin              = $idAdmin;
        $tambah_baru->jabatan_title         = $data['jabatan_title'];
        $tambah_baru->jabatan_tunjangan     = $data['jabatan_tunjangan'];
        $berhasilTambah                     = $tambah_baru->save();
        if ($berhasilTambah) {
            return redirect()->route('jabatan.index')->with('success', 'Jabatan baru berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', "Gagal menambahkan jabatan baru");
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
        //
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
        //
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
            Jabatan::findOrFail($id)->delete();
            return "ok";
        }
        catch (\Throwable $th) { return $th; }
    }
}

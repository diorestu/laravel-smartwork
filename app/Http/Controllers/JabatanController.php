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
        $data           = Jabatan::findOrFail($id);
        return view(
            'admin.jabatan.edit', ['data' => $data]
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
        $id_admin                   = Auth::user()->id;
        $input                      = $request->all();
        $data                       = Jabatan::findOrFail($id);
        $data->jabatan_title        = $input['jabatan_title'];
        $data->jabatan_tunjangan    = $input['jabatan_tunjangan'];
        $cekJudul                   = Jabatan::where('jabatan_title', '=', $input['jabatan_title'])->where('id_admin', '=', $id_admin)->where('jabatan_id', '!=', $id)->first();
        if ($cekJudul != null) {
            return redirect()->route('jabatan.edit', $id)->with('error', 'Nama jabatan sudah tersedia');
        }
        else {
            $berhasilSimpan             = $data->save();
            if ($berhasilSimpan) {
                return redirect()->route('jabatan.index')->with('success', 'Proses update data jabatan berhasil');
            } else {
                return redirect()->route('jabatan.edit', $id)->with('error', 'Gagal mengupdate data jabatan');
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
            Jabatan::findOrFail($id)->delete();
            return "ok";
        }
        catch (\Throwable $th) { return $th; }
    }
}

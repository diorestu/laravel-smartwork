<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id     = Auth::user()->id;
        $data   = Cabang::where('id_admin', $id)->get();
        return view('admin.cabang.index', ['data' => $data]);
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
        $idAdmin                        = Auth::user()->id;
        $data                           = $request->all();
        $tambah_baru                    = new Cabang;
        $tambah_baru->id_admin          = $idAdmin;
        $tambah_baru->cabang_nama       = $data['cabang_nama'];
        $tambah_baru->cabang_email      = $data['cabang_email'];
        $tambah_baru->cabang_phone      = $data['cabang_phone'];
        $tambah_baru->cabang_alamat     = $data['cabang_alamat'];
        $tambah_baru->cabang_lat        = $data['cabang_lat'];
        $tambah_baru->cabang_long       = $data['cabang_long'];
        $tambah_baru->cabang_umk        = $data['cabang_umk'];
        $tambah_baru->lembur_dasar      = (1/173) * (int) $data['cabang_umk'];
        $tambah_baru->lembur_h1         = 1.5 * $tambah_baru->lembur_dasar;
        $tambah_baru->lembur_h2         = 2 * $tambah_baru->lembur_dasar;
        $tambah_baru->lembur_h9         = 3 * $tambah_baru->lembur_dasar;
        $tambah_baru->lembur_h10        = 4 * $tambah_baru->lembur_dasar;
        $berhasilTambah                 = $tambah_baru->save();
        if ($berhasilTambah) {
            return redirect()->route('cabang.index')->with('success', 'Lokasi kerja ' . $tambah_baru->cabang_nama . ' berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', "Gagal menambahkan lokasi kerja baru");
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
        $data = Cabang::find($id);
        return view('admin.cabang.detail', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Cabang::find($id);
        return view('admin.cabang.edit', ['data' => $data]);
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
        $id_admin                = Auth::user()->id;
        $input                   = $request->all();
        $data                    = Cabang::findOrFail($id);
        $data->cabang_nama       = $input['cabang_nama'];
        $data->cabang_email      = $input['cabang_email'];
        $data->cabang_phone      = $input['cabang_phone'];
        $data->cabang_alamat     = $input['cabang_alamat'];
        $data->cabang_lat        = $input['cabang_lat'];
        $data->cabang_long       = $input['cabang_long'];
        $data->cabang_umk        = $input['cabang_umk'];
        $data->lembur_dasar      = (1 / 173) * (int) $input['cabang_umk'];
        $data->lembur_h1         = 1.5 * $data->lembur_dasar;
        $data->lembur_h2         = 2 * $data->lembur_dasar;
        $data->lembur_h9         = 3 * $data->lembur_dasar;
        $data->lembur_h10        = 4 * $data->lembur_dasar;
        $cekJudul                = Cabang::where('cabang_nama', '=', $input['cabang_nama'])->where('id_admin', '=', $id_admin)->where('id', '!=', $id)->first();
        if ($cekJudul != null) {
            return redirect()->route('cabang.edit', $id)->with('error', 'Lokasi kerja sudah tersedia');
        } else {
            $berhasilSimpan      = $data->save();
            if ($berhasilSimpan) {
                return redirect()->route('cabang.index')->with('success', 'Proses update data lokasi kerja berhasil');
            } else {
                return redirect()->route('cabang.edit', $id)->with('error', 'Gagal mengupdate data lokasi kerja');
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
            Cabang::findOrFail($id)->delete();
            return 'ok'; }
        catch (\Throwable $th) { return $th; }
    }
}

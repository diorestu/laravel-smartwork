<?php

namespace App\Http\Controllers;

use App\Models\StatusKawin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusKawinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id     = Auth::user()->id;
        $data   = StatusKawin::select(['id', 'status_kawin', 'status_kawin_tunjangan'])->where('id_admin', $id)->get();
        return view('admin.status_kawin.index', ['data' => $data,]);
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
        $idAdmin                              = Auth::user()->id;
        $data                                 = $request->all();
        $tambah_baru                          = new StatusKawin;
        $tambah_baru->id_admin                = $idAdmin;
        $tambah_baru->status_kawin            = $data['status_kawin'];
        $tambah_baru->status_kawin_tunjangan  = $data['status_kawin_tunjangan'];
        $berhasilTambah                       = $tambah_baru->save();
        if ($berhasilTambah) {
            return redirect()->route('status-kawin.index')->with('success', 'Status kawin baru berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', "Gagal menambahkan status kawin baru");
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
        $data           = StatusKawin::findOrFail($id);
        return view('admin.status_kawin.edit', ['data' => $data]);
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
        $id_admin                      = Auth::user()->id;
        $input                         = $request->all();
        $data                          = StatusKawin::findOrFail($id);
        $data->status_kawin            = $input['status_kawin'];
        $data->status_kawin_tunjangan  = $input['status_kawin_tunjangan'];
        $cekJudul                      = StatusKawin::where('status_kawin', '=', $input['status_kawin'])->where('id_admin', '=', $id_admin)->where('id', '!=', $id)->first();
        if ($cekJudul != null) {
            return redirect()->route('status-kawin.edit', $id)->with('error', 'Staus kawin sudah tersedia');
        } else {
            $berhasilSimpan             = $data->save();
            if ($berhasilSimpan) {
                return redirect()->route('status-kawin.index')->with('success', 'Proses update data status kawin berhasil');
            } else {
                return redirect()->route('status-kawin.edit', $id)->with('error', 'Gagal mengupdate data status kawin');
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
            StatusKawin::findOrFail($id)->delete();
            return "ok";
        } catch (\Throwable $th) {
            return $th;
        }
    }
}

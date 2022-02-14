<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shift;
use App\Models\UserShift;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Imports\UsersShiftImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ShiftController extends Controller
{
    public function getShiftUser(){
        return view('admin.shift.setShiftUser');
    }

    public function getShiftCabang(){
        return view('admin.shift.setShiftCabang');
    }

    public function postShiftUser(){
        Excel::import(new UsersShiftImport, request()->file('excel'), null, \Maatwebsite\Excel\Excel::XLSX);
        return redirect()->route('jadwal.index');
    }

    public function postShiftCabang(Request $r){

    }

    public function index()
    {
        $id     = Auth::user()->id;
        $data   = Shift::where('id_admin', $id)->get();
        return view('admin.shift.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id     = Auth::user()->id;
        $data   = Shift::where('id_admin', $id)->get();
        return view('admin.shift.create', ['data' => $data]);
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
        $id = Auth::user()->id;
        $data = $request->all();
        $data['id_admin'] = $id;
        Shift::create($data);
        return redirect()->back();
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
        $data           = Shift::findOrFail($id);
        return view(
            'admin.shift.edit',
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
        $id_admin                   = Auth::user()->id;
        $input                      = $request->all();
        $data                       = Shift::findOrFail($id);
        $data->nama_shift           = $input['nama_shift'];
        $data->ket_shift            = $input['ket_shift'];
        $data->hadir_shift          = $input['hadir_shift'];
        $data->pulang_shift         = $input['pulang_shift'];
        $cekJudul                   = Shift::where('nama_shift', '=', $input['nama_shift'])->where('id_admin', '=', $id_admin)->where('id', '!=', $id)->first();
        if ($cekJudul != null) {
            return redirect()->route('shift.create')->with('error', 'Kode jadwal kerja sudah tersedia');
        } else {
            $berhasilSimpan             = $data->save();
            if ($berhasilSimpan) {
                return redirect()->route('shift.create')->with('success', 'Proses update data jadwal kerja berhasil');
            } else {
                return redirect()->route('shift.create')->with('error', 'Gagal mengupdate data jadwal kerja');
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
            Shift::findOrFail($id)->delete();
            return "ok";
        } catch (\Throwable $th) {
            return $th;
        }
    }
}

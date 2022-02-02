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
        $id = Auth::user()->id;
        $data = Shift::where('id_admin', $id)->get();
        return view('admin.shift.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::user()->id;
        $data = Shift::where('id_admin', $id)->get();
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
        //
    }
}

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
        $id = Auth::user()->id;
        $data = Cabang::where('id_admin', $id)->get();
        return view('admin.cabang.index', [
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
        $input = $request->all();
        $id = Auth::user()->id;
        $input['id_admin'] = $id;
        $input['hitung_dasar'] = (1/173) * (int) $input['cabang_umk'];
        $input['cabang_h1'] = 1.5 * $input['hitung_dasar'];
        $input['cabang_h2'] = 2 * $input['hitung_dasar'];
        $input['cabang_h9'] = 3 * $input['hitung_dasar'];
        $input['cabang_h10'] = 4 * $input['hitung_dasar'];
        // dd($input);
        try {
            $save = Cabang::create($input);
            return redirect()->route('cabang.index')->with('success', 'Lokasi '.$save->cabang_nama.' telah berhasil ditambahkan!');
        } catch (\Throwable $th) {
            return redirect()->route('cabang.index')->with('error', $th);
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
        return view('admin.cabang.detail', [
            'data' => $data,
        ]);
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
            Cabang::findOrFail($id)->delete();
            return redirect()->route('cabang.index')->with('success', 'Lokasi telah terhapus!');
        } catch (\Throwable $th) {
            return redirect()->route('cabang.index')->with('error', $th);
        }
    }
}

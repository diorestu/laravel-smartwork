<?php

namespace App\Http\Controllers;

use App\Models\Rekrutmen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RekrutmenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id       = Auth::user()->id;
        $data     = Rekrutmen::with(['lowongan'])
                        ->whereHas('lowongan', function ($q) use ($id) {
                            $q->where('id_admin', $id);
                        })->get();
        foreach ($data as $i) {
            dd(print_r($i));
        }
        return view('admin.rekrutmen.index', [
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rekrutmen  $rekrutmen
     * @return \Illuminate\Http\Response
     */
    public function show(Rekrutmen $rekrutmen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rekrutmen  $rekrutmen
     * @return \Illuminate\Http\Response
     */
    public function edit(Rekrutmen $rekrutmen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rekrutmen  $rekrutmen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rekrutmen $rekrutmen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rekrutmen  $rekrutmen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rekrutmen $rekrutmen)
    {
        //
    }
}

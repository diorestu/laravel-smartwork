<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cabang;
use App\Models\UserSalary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = UserSalary::select(['user_salaries.*', 'users.nama', 'users.id_cabang','cabangs.cabang_nama'])
        ->leftJoin('users', 'users.id', '=', 'user_salaries.id_user')
        ->leftJoin('cabangs', 'cabangs.id', '=', 'users.id_cabang')
        ->get();
        return view('admin.upah.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::user()->id;
        $data = Cabang::where('id_admin', $id)->get();
        return view('admin.upah.create', [
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $pegawai = User::where('id_cabang', $r->id_cabang)->get();
        $total = 0;
        foreach ($pegawai as $i) {
            UserSalary::create([
                'id_user' => $i->id,
                'gaji_pokok' => $r->gaji_pokok,
            ]);
            $total += 1;
        }
        return redirect()->route('upah.index')->with('total', $total);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserSalary  $userSalary
     * @return \Illuminate\Http\Response
     */
    public function show(UserSalary $userSalary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserSalary  $userSalary
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = UserSalary::select(['user_salaries.*', 'users.nama', 'users.id_cabang', 'cabangs.cabang_nama'])
        ->leftJoin('users', 'users.id', '=', 'user_salaries.id_user')
        ->leftJoin('cabangs', 'cabangs.id', '=', 'users.id_cabang')
        ->where('user_salaries.id', $id)->first();
        return view('admin.upah.edit', [
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserSalary  $userSalary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        $data = UserSalary::find($id);
        $data->gaji_pokok = $r->gaji_pokok;
        $data->save();
        return redirect()->route('upah.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserSalary  $userSalary
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSalary $userSalary)
    {
        //
    }
}

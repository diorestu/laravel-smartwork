<?php

namespace App\Http\Controllers\User;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use Illuminate\Support\Facades\Auth;

class AktivitasController extends Controller
{
    public function resizeImage($file, $fileNameToStore)
    {
        // Resize image
        $resize = Image::make($file)->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');
        // Create hash value
        $hash = md5($resize->__toString());
        // Prepare qualified image name
        $image = $hash . "jpg";
        // Put image to storage
        $save = Storage::put("public/kegiatan/{$fileNameToStore}", $resize->__toString());
        if ($save) {
            return true;
        }
        return false;
    }

    public function postKegiatan(Request $request)
    {
        // Get file from request
        $file = $request->file('avatar');
        // Get the original image extension
        $extension = $file->getClientOriginalExtension();
        // Create unique file name
        $fileNameToStore = 'kegiatan_' . time() . '.' . $extension;
        // Refer image to method resizeImage
        $save = $this->resizeImage($file, $fileNameToStore);
        return true;
    }

    public function index()
    {
        $id = Auth::user()->id;
        $data = Kegiatan::where('id_user', $id)->orderBy('tanggal_kgt', 'DESC')->take(5)->get();
        return view('user.task.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.task.input');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::user()->id;
        $input = $request->all();
        $input['id_user']= $id;
        $input['tanggal_kgt'] =  date('Y-m-d');
        $input['jam_kgt'] = date('H:i:s');
        try {
            $res = Kegiatan::create($input);
            return redirect()->route('kegiatan.show', $res->id);
        } catch (\Throwable $th) {
            return redirect()->route('kegiatan.index')->withErrors('Gagal Mencatat!');
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
        $data = Kegiatan::find($id);
        // dd($data);
        return view('user.task.detail', ['data' => $data ]);
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

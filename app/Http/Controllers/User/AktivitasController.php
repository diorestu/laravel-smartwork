<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\AktivitasImage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AktivitasController extends Controller
{
    public function resizeImage($file, $fileNameToStore)
    {
        $resize = Image::make($file)->resize(600, null, function ($constraint) { $constraint->aspectRatio(); })->encode('jpg');
        $save   = Storage::put("public/kegiatan/{$fileNameToStore}", $resize->__toString());
        if ($save) { return true; } else { return false; }
    }

    public function postKegiatan(Request $request, $id_aktivitas)
    {
        $id              = Auth::user();
        $file            = $request->file('avatar');
        $extension       = $file->getClientOriginalExtension();
        $fileNameToStore = $id->nama . '_aktivitas__' . time() . '.' . $extension;
        $save            = $this->resizeImage($file, $fileNameToStore);
        $create          = AktivitasImage::create([
                                'aktivitas_id' => $id_aktivitas,
                                'images'       => $fileNameToStore,
                            ]);
        if ($create) { return true; } else { return false; }
    }

    public function riwayat(Request $request)
    {
        $hari       = $request->hari;
        $temp       = explode("-", $hari);
        $tahun      = $temp[0];
        $bulan      = $temp[1];
        $id         = Auth::user()->id;
        $data       = Aktivitas::where('id_user', $id)
                    ->whereYear('created_at', '=', $tahun)
                    ->whereMonth('created_at', '=', $bulan)
                    ->orderBy('created_at', 'DESC')->get();
        return view('user.task.data.view_data_riwayat', ['data' => $data]);
    }

    public function index()
    {
        $tahun_sekarang = date("Y");
        $bulan_sekarang = date("m");
        $id             = Auth::user()->id;
        $data           = Aktivitas::where('id_user', $id)
                        ->whereYear('created_at', '=', $tahun_sekarang)
                        ->whereMonth('created_at', '=', $bulan_sekarang)
                        ->orderBy('created_at', 'DESC')->get();
        return view('user.task.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.task.input', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id                     = Auth::user()->id;
        $input                  = $request->all();
        $input['id_user']       = $id;
        try {
            $res = Aktivitas::create($input);
            return redirect()->route('aktivitas.show', $res->id)->with('success', 'Berhasil catat aktivitas');
        } catch (\Throwable $th) {
            return redirect()->route('aktivitas.index')->with('error', 'Gagal catat aktivitas');
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
        $data       = Aktivitas::find($id);
        $data_image = AktivitasImage::where('aktivitas_id', $id)->get();
        return view('user.task.detail', [
            'data' => $data,
            'data_image' => $data_image,
        ]);
    }
}

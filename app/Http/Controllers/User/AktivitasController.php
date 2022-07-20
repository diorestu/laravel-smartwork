<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Aktivitas;
use App\Models\KpiMaster;
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
        $id = Auth::user()->id_admin;
        $kat =  KpiMaster::where('id_admin', $id)->get();
        return view('user.task.input', [
            'data' => $kat
        ]);
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
        $data = Aktivitas::find($id);
        return view('user.task.detail', ['data' => $data ]);
    }
}

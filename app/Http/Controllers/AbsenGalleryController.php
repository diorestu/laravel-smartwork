<?php

namespace App\Http\Controllers;

use App\Models\AbsensiImage;
use App\Models\User;
use App\Models\UserGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class AbsenGalleryController extends Controller
{
    public function resizeImage($file, $fileNameToStore)
    {
        $resize = Image::make($file)->resize(600, null, function ($constraint) { $constraint->aspectRatio(); })->encode('jpg');
        $save   = Storage::put("public/absensi/{$fileNameToStore}", $resize->__toString());
        if ($save) { return true; } else { return false; }
    }

    public function postHadir(Request $request, $id_absen)
    {
        $id              = Auth::user();
        $file            = $request->file('hadir');
        $extension       = $file->getClientOriginalExtension();
        $fileNameToStore = $id->nama . '_hadir_' . time() . '.' . $extension;
        $save            = $this->resizeImage($file, $fileNameToStore);
        $create          = AbsensiImage::create([
                                'absensi_id' => $id_absen,
                                'absen_tipe' => 'datang',
                                'images'     => $fileNameToStore,
                           ]);
        if ($create) { return true; } else { return false; }
    }

    public function postPulang(Request $request, $id_absen)
    {
        $id              = Auth::user();
        $file            = $request->file('pulang');
        $extension       = $file->getClientOriginalExtension();
        $fileNameToStore = $id->nama . '_pulang_' . time() . '.' . $extension;
        $save            = $this->resizeImage($file, $fileNameToStore);
        $create          = AbsensiImage::create([
                            'absensi_id' => $id_absen,
                            'absen_tipe' => 'pulang',
                            'images'     => $fileNameToStore,
        ]);
        if ($create) { return true; } else { return false; }
    }
}

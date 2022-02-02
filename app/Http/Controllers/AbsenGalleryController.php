<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class AbsenGalleryController extends Controller
{
    public function postHadir(Request $request)
    {
        $id= Auth::user();
        // Get file from request
        $file = $request->file('avatar');
        // Get the original image extension
        $extension = $file->getClientOriginalExtension();
        // Create unique file name
        $fileNameToStore = $id->nama.'_hadir_' . time() . '.' . $extension;
        // Refer image to method resizeImage
        $save = $this->resizeImage($file, $fileNameToStore);
        // Initiate Save to DB
        $input['id_user'] = $id->id;
        $input['photo_url'] = $fileNameToStore;
        $input['photo_roles'] = 'HADIR';
        UserGallery::create($input);
        return true;
    }
    public function postPulang(Request $request)
    {
        $id = Auth::user();
        // Get file from request
        $file = $request->file('avatar');
        // Get the original image extension
        $extension = $file->getClientOriginalExtension();
        // Create unique file name
        $fileNameToStore = $id->nama.'_pulang_' . time() . '.' . $extension;
        // Refer image to method resizeImage
        $save = $this->resizeImage($file, $fileNameToStore);
        // Initiate Save to DB
        $input['id_user'] = $id->id;
        $input['photo_url'] = $fileNameToStore;
        $input['photo_roles'] = 'PULANG';
        UserGallery::create($input);
        return true;
    }

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
        $save = Storage::put("storage/images/{$fileNameToStore}", $resize->__toString());

        if ($save) {
            return true;
        }
        return false;
    }
}

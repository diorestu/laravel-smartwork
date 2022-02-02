<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class APIAbsenController extends Controller
{
    public function addimage(Request $request)
    {
        $image = new Image;
        $image->title = $request->title;

        if ($request->hasFile('image')) {

            $path = $request->file('image')->store('images');
            $image->url = $path;
        }
        $image->save();
        return new ImageResource($image);
    }
}

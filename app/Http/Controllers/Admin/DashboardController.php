<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Cabang;
use App\Charts\ContohChart;
use App\Models\UserGallery;
use Illuminate\Http\Request;
use App\Charts\UserCountChart;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function resizeImage($file, $fileNameToStore)
    {
        // Resize image
        $resize = Image::make($file)->resize(720, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('png');
        // Put image to storage
        $save = Storage::put("public/logo/{$fileNameToStore}", $resize->__toString());
        if ($save) {return true;}return false;
    }

    public function index() {
        if (!Auth::user()->config->is_first || Auth::user()->config->is_first == 'n') {
            return redirect()->route('admin.home');
        }else{
            return view('admin.welcome');
        }
    }
    public function dashboard(UserCountChart $chart) {
        $id     = Auth::user()->id;
        $cabang = Cabang::pluck('cabang_nama')->toArray();
        $user   = User::select(DB::raw('count(id) as total'))->groupBy('id_cabang')->where('id_admin', $id)->pluck('total')->toArray();
        // $id = Auth::user()->id;
        // $user_c = User::where('id_admin',$id)->count();
        // $cabang_c = Cabang::where('id_admin',$id)->count();
        // return view('admin.dashboard',[
        //     'user' => $user_c,
        //     'cabang' => $cabang_c,
        //     'chart' => $chart->build(),
        // ]);
        // dd($user);
        return view('admin.dashboard', [
            'user'   => $user,
            'cabang' => $cabang,
            'chart'  => $chart->build()
        ]);
    }
    public function user() {
        return view('admin.user');
    }

    // PROFILE
    public function profile() {
        $data = User::find(Auth::user()->id);
        return view('admin.profil', compact('data'));
    }

    public function saveProfile(Request $r) {
        $input          = $r->all();
        $id             = Auth::id();
        $data           = User::find($id);
        $data->nama     = $input['nama'];
        $data->username = $input['username'];
        $data->gender   = $input['gender'];
        $data->phone    = $input['phone'];
        $data->email    = $input['email'];
        $data->alamat   = $input['alamat'];
        $data->save();
        return redirect()->route('admin.profile')->with('success', 'Berhasil update profil admin');
    }

    public function uploadLogo(Request $request)
    {
        $id = Auth::id();
        if ($request->hasFile('avatar')) {
            // Get file from request
            $file = $request->file('avatar');
            // Get the original image extension
            $extension = $file->getClientOriginalExtension();
            // Create unique file name
            $fileNameToStore = $id.'_hadir_' . time() . '.' . $extension;
            // Refer image to method resizeImage
            $save = $this->resizeImage($file, $fileNameToStore);
            if($save){
                $data = User::find($id);
                $data->company_logo = $fileNameToStore;
                $data->save();
                // $data['id_user'] = $id;
                // $data['photo_url'] = $fileNameToStore;
                // $data['photo_roles'] = 'LOGO';
                // UserGallery::create($data);
            }
            return true;
        }
    }

    // UBAH PASSWORD
    public function ubahPassword() {
        return view('admin.ubah_password');
    }

    public function verify(){
        return view('admin.verify');
    }


}

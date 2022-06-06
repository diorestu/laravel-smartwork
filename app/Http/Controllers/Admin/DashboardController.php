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
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

    public function saveProfile(Request $request) {
        $id_admin       = Auth::user()->id;
        $input          = $request->all();
        $data           = User::findOrFail($id_admin);
        $data->nama     = $input['nama'];
        $data->gender   = $input['gender'];
        $data->phone    = $input['phone'];
        $data->email    = $input['email'];
        $data->alamat   = $input['alamat'];
        $data->username = $input['username'];
        // $data->status   = $input['status'];
        $berhasil       = $data->save();
        if ($berhasil) {
            return redirect()->route('admin.profile')->with('success', 'Proses Update Data Pegawai Berhasil'); }
        else {
            return redirect()->route('admin.profile')->with('error', 'Gagal Mengupdate Data Pegawai'); }
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
        $id_admin       = Auth::user()->id;
        $data_user      = User::where("id", $id_admin)->first();
        return view('admin.ubah_password', ['data_user' => $data_user]);
    }
    public function saveNewPassword(Request $r) {
        $id_admin = Auth::user()->id;
        $user     = User::findOrFail($id_admin);

        $this->validate($r, [
            'old_password'  => 'required|min:8',
            'new_password'  => 'min:8|different:old_password',
            'cnew_password' => 'required|min:8|same:new_password',
        ]);

        if (Hash::check($r->new_password, $user->password)) {
            $r->session()->flash('error', 'Kata Sandi Baru Tidak Sesuai!');
            return redirect()->back();
        } else {
            $user->fill([
                'password' => Hash::make($r->new_password)
            ])->save();

            $r->session()->flash('success', 'Kata Sandi Telah Diubah');
            return redirect()->back();
        }
    }

    public function verify(){
        return view('admin.verify');
    }
    public function expired(){
        return view('admin.expired');
    }


}

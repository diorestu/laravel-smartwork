<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function username()
    {
        return 'username';
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        // $nama = $request->username;
        // $data = User::where('username', $nama)->first();
        // if ($data->active) {
        $status = User::where('username', $input['username'])->first();
        if ($status->status === 'active') {
            Auth::attempt([
                'username' => $input['username'],
                'password' => $input['password']
            ]);

            return redirect()->route('admin.welcome');
        } else {
            return redirect('verify')->withErrors(['Your account is inactive']);
        }
        // if (Auth::attempt([
        //     'username' => $input['username'],
        //     'password' => $input['password']
        // ])) {

        // }
    }


}

<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->is_admin === 1 ) {
            return $next($request);
        }else{
            return redirect('/user');
            // return redirect()->route('admin.verify')->with('error', "Maaf, Anda tidak memiliki akses ke Halaman Admin. Hubungi pihak IT untuk informasi lebih lanjut.");
        }
    }
}

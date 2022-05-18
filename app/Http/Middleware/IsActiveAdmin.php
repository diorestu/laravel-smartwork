<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsActiveAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $now      = Carbon::now();
        $disabled = Carbon::parse(Auth::user()->config->expired_at);
        $selisih  = $disabled->diffInDays($now, false);
        if($selisih >= 1){
            return redirect()->route('admin.expired')->withErrors(["Maaf, Akun Anda telah melawati batas masa aktif penggunaan. Segera lakukan perpanjangan!"]);
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        //Cek jika user tidak login atau tidak memiliki role yang sesuai
        if (!$user || !$user->hasAnyRole($roles)) {
            session()->flash('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
            return redirect()->route('home');
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check admin guard
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();
            
            // Check if admin role matches
            if (in_array($user->role, $roles)) {
                return $next($request);
            }
        }

        // Check web guard (accounts: institusi, peserta)
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            
            // Check if account role matches
            if (in_array($user->role, $roles)) {
                return $next($request);
            }
        }

        // Unauthorized access
        abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}

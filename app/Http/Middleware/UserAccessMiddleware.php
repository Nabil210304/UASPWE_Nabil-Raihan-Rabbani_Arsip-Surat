<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $userType
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $userType): Response
    {
        // Cek apakah user sudah login dan memiliki role yang sesuai
        if (Auth::user()->role == $userType) {
            return $next($request);
        }

        abort(403, 'Unauthorized');


        // Jika user tidak memiliki akses, kirim response JSON error
        return response()->json([
            'error' => 'You do not have permission to access this page.',
            'userType' => $userType
        ]);
    }
}

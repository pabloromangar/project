<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        // Verificar si el usuario está autenticado y es un administrador
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Redirigir o denegar acceso si no es admin
        return redirect()->route('storefront')->with('error', 'Acceso denegado.');
    }
}

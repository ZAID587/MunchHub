<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isAdmin()) {
            return redirect()->route('client.inicio')->with('error', 'Acceso exclusivo para administradores.');
        }

        if (!session('admin_verified')) {
            return redirect()->route('admin.login')->with('error', 'Por seguridad, debes ingresar tu código PIN confidencial de Administrador para acceder al panel.');
        }

        return $next($request);
    }
}

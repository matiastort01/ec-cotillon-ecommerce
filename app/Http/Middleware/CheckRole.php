<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

     public function handle($request, Closure $next, $role = null)
     {
         if (!Auth::check()) {
             // Si el usuario no está autenticado, redirige al login
             return redirect()->route('user-log.r_view_login_remake');
         }
 
         if ($role && Auth::user()->role !== $role) {
             // Si el usuario no tiene el rol necesario, redirige a una página de error o inicio
             abort(403, 'No tienes permisos para acceder a esta sección.');
         }
 
         return $next($request);
     }
}

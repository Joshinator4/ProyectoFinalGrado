<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //A traves del request(peticion) se filtra si existe o no el usuario, y si es administrador por medio del método isAdmin() si es correcto se devuelve. con next y el request se permite seguir adelante (el return)
        if ($request->user() != null && $request->user()->isAdmin()) {
            return $next($request);
        }

        //si no se cumple las condiciones se devuelve un error de tipo 403: no hay permisos para realizar la acción
        abort(403);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrCoordMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->is_voluntario) {
            // Redirigir al usuario voluntario a la ruta específica para voluntarios
            return redirect()->route('voluntario_logeado.index');
        }

        if (!$user || (!$user->is_admin && !$user->is_coordinador)) {
            abort(403, "No tienes permisos para acceder a esta página.");
        }


        // Verificar si la ruta es de edición o actualización de voluntario
        if ($request->route()->getName() === 'register') {
            // Obtener el ID del voluntario de la ruta

            if ($user->is_admin) {
                return $next($request);
            } else {

                if ($user->is_coordinador) {
                    return redirect()->route('dashboard');
                } elseif ($user->is_voluntario) {
                    return redirect()->route('voluntario_logeado.index');
                }

            }



        }

        return $next($request);





    }
}

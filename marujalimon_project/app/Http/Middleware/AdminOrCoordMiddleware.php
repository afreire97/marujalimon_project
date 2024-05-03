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



        if (
            $request->route()->getName() === 'coordinadores.index' || $request->route()->getName() === 'coordinadores.create'
            || $request->route()->getName() === 'coordinadores.store' || $request->route()->getName() === 'coordinadores.show'
            || $request->route()->getName() === 'coordinadores.update' || $request->route()->getName() === 'coordinadores.edit'
            || $request->route()->getName() === 'coordinadores.destroy'
        ) {
            if ($user->is_admin) {
                return $next($request);
            } else {


                if ($user->is_coordinador) {
                    return redirect()->route('dashboard');
                } elseif ($user->is_voluntario) {

                    if ($request->route()->getName() === 'mostrarHorasPorMes') {
                        return $next($request);

                    }
                    return redirect()->route('voluntario_logeado.index');
                }

            }
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

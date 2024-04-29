<?php

namespace App\Http\Middleware;

use App\Models\Voluntario;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VoluntarioMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {



        // Verificar si el usuario está autenticado y es un voluntario
        if ($request->user() && $request->user()->is_voluntario) {
            // Verificar si la ruta es de edición o actualización de voluntario
            if ($request->route()->getName() === 'voluntario_logeado.edit') {
                // Obtener el ID del voluntario de la ruta



                $voluntarioId = $request->route('voluntario')->VOL_id;
                // Verificar si el usuario tiene permiso para editar este voluntario
                if ($request->user()->voluntario->VOL_id == $voluntarioId) {
                    return $next($request);
                } else {
                    // Si el usuario intenta editar un voluntario que no es él mismo, puedes redirigirlo o retornar una respuesta de error
                    return redirect()->route('voluntario_logeado.index');
                }
            }
            if ($request->route()->getName() === 'voluntario_logeado.calendario') {
                // Obtener el ID del voluntario de la ruta


                $voluntarioId = $request->route('voluntario');




                // Verificar si el usuario tiene permiso para editar este voluntario
                if ($request->user()->voluntario->VOL_id == $voluntarioId) {
                    return $next($request);
                } else {
                    // Si el usuario intenta editar un voluntario que no es él mismo, puedes redirigirlo o retornar una respuesta de error
                    return redirect()->route('voluntario_logeado.index');
                }
            }


            return $next($request);
        }

        // Si el usuario no es un voluntario, puedes redirigirlo a una página de error o realizar alguna otra acción
        return redirect()->route('dashboard');
    }
}

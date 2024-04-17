<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class CoordinadorMiddleware
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
        if (!auth()->check() || !auth()->user()->is_coordinador) {
            abort(403, "No tienes permisos para acceder a esta pagina");
        }

        return $next($request);
    }
}

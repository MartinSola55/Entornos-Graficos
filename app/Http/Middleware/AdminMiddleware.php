<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->rol_id !== 1) {
            return redirect()->route('home')->with('error', 'No tienes permiso para acceder a esta página');
        }
        return $next($request);
    }
}

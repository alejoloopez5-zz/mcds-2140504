<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class UserEditor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && (Auth::user()->role == 'Editor'||Auth::user()->role == 'Admin')) {
            return $next($request);
        }
        return redirect('home')->with('error', 'No tiene permisos para ver el contenido!');
    }
}

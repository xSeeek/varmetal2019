<?php

namespace Varmetal\Http\Middleware;

use Closure;

class isTrabajador
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
         if(auth()->user() == null)
             return redirect('/');
         if(auth()->user()->isTrabajador())
             return $next($request);
         return redirect('home');
     }
}

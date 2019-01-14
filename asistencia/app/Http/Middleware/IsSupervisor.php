<?php

namespace Asistencia\Http\Middleware;

use Closure;

class IsSupervisor
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
       if(auth()->user()->isSupervisor() || auth()->user()->isAdmin()) {
           return $next($request);
       }
       return redirect('home');
   }
}

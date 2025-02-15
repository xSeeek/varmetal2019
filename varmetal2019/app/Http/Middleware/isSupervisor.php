<?php

namespace Varmetal\Http\Middleware;

use Closure;

class isSupervisor
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
        if(auth()->user()->isSupervisor() || auth()->user()->isAdmin())
            return $next($request);
        return redirect('/');
    }
}

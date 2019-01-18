<?php

namespace Varmetal\Http\Middleware;

use Closure;

class isGerente
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
        if(auth()->user() == null || auth()->user()->isSupervisor())
            return redirect('/');
        if(auth()->user()->isGerente() || auth()->user()->isAdmin())
            return $next($request);
        return redirect('/');
    }
}

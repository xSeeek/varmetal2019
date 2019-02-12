<?php

namespace Varmetal\Http\Middleware;

use Closure;

class ProtocoloHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*public function handle($request, Closure $next)
    {
        return $next($request);
    }*/
    public function handle($request, Closure $next)
    {
    if (!$request->secure() && env('APP_ENV') === 'prod') {
        return redirect()->secure($request->getRequestUri());
    }

    return $next($request);
    }
}

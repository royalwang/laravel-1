<?php

namespace App\Http\Middleware;

use Closure;
use Permission; 

class Permissions
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
        if(!Permission::canCurrentAction()){
            return redirect()->route($request->user()->default_page());
        }
        return $next($request);
    }
}



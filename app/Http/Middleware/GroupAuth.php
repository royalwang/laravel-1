<?php

namespace App\Http\Middleware;

use Closure;

class GroupAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(!$request->user()->is($role)){
            return redirect()->guest('home');
        }

        return $next($request);
    }
}

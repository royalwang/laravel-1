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
            $urls = parse_url(redirect()->getUrlGenerator()->previous());
            if(in_array($urls['path'] , ['/login','/logout']) ){
                return redirect()->route(Permission::defaultPage());
            }else{
                return back();
            }
        }
        return $next($request);
    }
}



<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Common;
use Auth;

class CommonProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //$common = new Common(Auth::user());
        $this->app->singleton('Common', function(){
            return new Common(Auth::user());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        
    }
}

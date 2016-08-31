<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libs\Menus;
use Auth;

class MenusProvider extends ServiceProvider
{


    public function register()
    {
        $this->app->singleton('Menus', function(){
            return new Menus();
        });
        
    }


}

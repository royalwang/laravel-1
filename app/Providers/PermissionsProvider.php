<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libs\Permission;
use Auth;

class PermissionsProvider extends ServiceProvider
{

    public function boot()
    {
        $this->bladeDirectives();
    }


    public function register()
    {
        $this->app->singleton('Permission', function(){
            return new Permission(Auth::user());
        });   
    }

    private function bladeDirectives(){

        \Blade::directive('role', function($expression) {
            return "<?php if (\\Permission::hasRole{$expression}) : ?>";
        });

        \Blade::directive('endrole', function($expression) {
            return "<?php endif; // Permission::hasRole ?>";
        });

        \Blade::directive('pcan', function($expression) {
            return "<?php if (\\Permission::can{$expression}) : ?>";
        });

        \Blade::directive('endpcan', function($expression) {
            return "<?php endif; // Permission::can ?>";
        });

        \Blade::directive('ability', function($expression) {
            return "<?php if (\\Permission::ability{$expression}) : ?>";
        });

        \Blade::directive('endability', function($expression) {
            return "<?php endif; // Permission::ability ?>";
        });
    }
}

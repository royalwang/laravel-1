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
            return "<?php if (\\Permissions::hasRole{$expression}) : ?>";
        });

        \Blade::directive('endrole', function($expression) {
            return "<?php endif; // Permissions::hasRole ?>";
        });

        \Blade::directive('permission', function($expression) {
            return "<?php if (\\Permissions::can{$expression}) : ?>";
        });

        \Blade::directive('endpermission', function($expression) {
            return "<?php endif; // Permissions::can ?>";
        });

        \Blade::directive('ability', function($expression) {
            return "<?php if (\\Permissions::ability{$expression}) : ?>";
        });

        \Blade::directive('endability', function($expression) {
            return "<?php endif; // Permissions::ability ?>";
        });
    }
}

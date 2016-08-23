<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Libs\Common;
use Auth;

class CommonProvider extends ServiceProvider
{

    public function boot()
    {
        $this->bladeDirectives();
    }


    public function register()
    {
        $this->app->singleton('Common', function(){
            return new Common(Auth::user());
        });
        
    }

    private function bladeDirectives(){

        \Blade::directive('activeMenu', function($expression) {
            return "<?php echo \\Common::activeMenu{$expression}  ?>";
        });


    }
}

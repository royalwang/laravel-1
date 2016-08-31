<?php 

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MenusFacade extends Facade {

    protected static function getFacadeAccessor() { 
    	return 'Menus'; 
    }

}
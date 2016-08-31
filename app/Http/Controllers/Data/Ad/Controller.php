<?php

namespace App\Http\Controllers\Data\Ad;

use Menus;
class Controller extends \App\Http\Controllers\Controller
{
    function __construct(){
		parent::__construct();
        view()->share('sidebar_setting', Menus::getMenu('data.ad')->toArray());
    }
}

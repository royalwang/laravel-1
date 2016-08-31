<?php

namespace App\Http\Controllers\Data\Site;

use Menus;
class Controller extends \App\Http\Controllers\Controller
{
	function __construct(){
		parent::__construct();
        view()->share('sidebar_setting', Menus::getMenu('data.site')->toArray());
	}
}

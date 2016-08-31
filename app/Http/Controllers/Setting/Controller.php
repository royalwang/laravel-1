<?php

namespace App\Http\Controllers\Setting;

use Menus;

class Controller extends \App\Http\Controllers\Controller
{
	function __construct(){
		parent::__construct();
    	view()->share('sidebar_setting', Menus::getMenu('setting')->toArray());
	}
	
}

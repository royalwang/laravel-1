<?php

namespace App\Http\Controllers\Setting;


use Route;
use Permission;

class Controller extends \App\Http\Controllers\Controller
{

    function __construct(){
    	parent::__construct();

    	$sidebar = [
    		[
    			'code' => 'users' ,
    			'url'  => 'setting.users.index',
    			'icon' => 'fa-user',
                'name' => '用户管理',
    		], [
    			'code' => 'roles' , 
    			'url'  => 'setting.roles.index', 
    			'icon' => 'fa-users',
                'name' => '角色管理',
    		], [
    			'code' => 'permissions' , 
    			'url'  => 'setting.permissions.index', 
    			'icon' => 'fa-key',
                'name' => '权限管理',
    		],
    	];

    	$sidebar = $this->addMenuActiveByRoute($sidebar , 1);	
    	view()->share('sidebar_setting', $sidebar);
    }
}

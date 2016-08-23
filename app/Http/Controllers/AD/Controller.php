<?php

namespace App\Http\Controllers\AD;


class Controller extends \App\Http\Controllers\Controller
{
    function __construct(){
    	parent::__construct();

    	$sidebar = [
    		[
    			'code' => 'records' ,
    			'url'  => 'ad.table.index',
    			'icon' => 'fa-user',
                'name' => '数据管理',
    		], [
    			'code' => 'tablestyle' , 
    			'url'  => 'ad.tablestyle.index', 
    			'icon' => 'fa-users',
                'name' => '数据统计',
    		], [
    			'code' => 'accounts' , 
    			'url'  => 'ad.accounts.index', 
    			'icon' => 'fa-key',
                'name' => '账号管理',
    		], [
    			'code' => 'vps' , 
    			'url'  => 'ad.vps.index', 
    			'icon' => 'fa-key',
                'name' => 'VPS管理',
    		],
    	];

        $sidebar = $this->addMenuActiveByRoute($sidebar , 1);   

        $sidebar_main = view()->shared('sidebar_main');
        $sidebar_main[0]['child'] = $sidebar;


    	
    	view()->share('sidebar_main', $sidebar_main);
    }
}

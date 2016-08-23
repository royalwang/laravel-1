<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $path;

    public function __construct(){

        $this->path = Route::currentRouteName();

    	$sidebar = [
            [
                'code' => 'ad' ,
                'icon' => 'fa-home' ,
                'name' => '广告管理',
                'url'  => 'ad.table.index'
            ], [
                'code' => 'setting' ,
                'icon' => 'fa-pencil' ,
                'name' => '系统设置' ,
                'url'  => 'setting.users.index'
            ],
    	];
    	
    	$sidebar = $this->addMenuActiveByRoute($sidebar , 0);	
    	view()->share('sidebar_main', $sidebar);

    }

    protected function getAction($level){
    	$routeSections = explode('.', $this->path);
    	return isset($routeSections[$level]) ? $routeSections[$level] : '';
    }

    protected function addMenuActiveByRoute($menu , $level){
    	$action = $this->getAction($level);
    	return $this->addMenuActive($menu , $action);	
    }

    protected function addMenuActive($menu , $code){
    	foreach ($menu as $k=>$item) {
    		if(isset($item['code']) && $item['code'] == $code){
				$menu[$k]['active'] = true;
    		}
    	}
    	return $menu;
    }
}

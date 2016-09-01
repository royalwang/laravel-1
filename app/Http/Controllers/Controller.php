<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Route;
use Request;
use Menus;
use Permission;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $path;
    protected $menu;
    protected $show;

    public function __construct(){

        $this->path = Route::currentRouteName();

    	$sidebar = [
            'home' => [
                'icon' => 'fa-home' ,
                'name' => '首页',
                'url' => 'index',
                'visable' => 'visable',
            ], 
            'chart' => [
                'icon' => 'fa-pie-chart' ,
                'name' => '数据报表',
            ],
            'data' => [
                'icon' => 'fa-database' ,
                'name' => '数据管理',
            ], 
            'style' => [
                'icon' => 'fa-laptop' ,
                'name' => '样式设定',
            ],
            'setting'=> [
                'icon' => 'fa-pencil' ,
                'name' => '用户管理' ,
            ],
    	];

        $sidebar_data = [
            'ad' => [
                'icon' => 'fa-database' ,
                'name' => '广告数据' ,
            ],
            'site'=> [
                'icon' => 'fa-database' ,
                'name' => '网站数据' ,
                'url'  => 'data.site.sites.index'
            ]
        ];

        $sidebar_data_ad = [    
            'records' => [
                'icon' => 'fa-database' ,
                'name' => '广告记录' ,
                'url'  => 'data.ad.records.index'
            ],
            'accounts' => [
                'icon' => 'fa-database' ,
                'name' => '广告账号' ,
                'url'  => 'data.ad.accounts.index'
            ],
            'vps' => [
                'icon' => 'fa-database' ,
                'name' => '广告VPS' ,
                'url'  => 'data.ad.vps.index'
            ],
            'binds'     => [
                'icon' => 'fa-database' ,
                'name' => '账号绑定' ,
                'url'  => 'data.ad.binds.index'   
            ],
        ];

        $sidebar_setting = [    
            'users'=> [
                'url'  => 'setting.users.index',
                'icon' => 'fa-user',
                'name' => '用户管理',
            ], 
            'roles' => [
                'url'  => 'setting.roles.index', 
                'icon' => 'fa-users',
                'name' => '角色管理',
            ], 
            'permissions' => [
                'url'  => 'setting.permissions.index', 
                'icon' => 'fa-key',
                'name' => '权限管理',
            ],
        ];

        $sidebar_data_site = [    
            'sites' => [
                'url'  => 'data.site.sites.index',
                'icon' => 'fa-database',
                'name' => '网站信息',
            ], 
            'banners' => [
                'url'  => 'data.site.banners.index', 
                'icon' => 'fa-database',
                'name' => '品牌信息',
            ], 
            'paychannels' => [ 
                'url'  => 'data.site.paychannels.index', 
                'icon' => 'fa-database',
                'name' => '通道信息',
            ],
        ];

        $sidebar_chart = [
            'ad' => [
                'url' => 'chart.ad.table.index',
                'icon' => 'fa-table',
                'name' => '广告报表'
            ]
        ];

        Menus::addItems($sidebar)
             ->addMenu('data',$sidebar_data)
             ->addMenu('data.ad',$sidebar_data_ad)
             ->addMenu('data.site',$sidebar_data_site)
             ->addMenu('setting',$sidebar_setting)
             ->addMenu('chart',$sidebar_chart)
             ->setActive($this->path);

    	$routes = Permission::getPerms()->toArray();
        foreach($routes as $route){
            if(ends_with($route['code'],'.index')){
                Menus::setVisable(substr($route['code'], 0 ,-6));
            }
        }  

        $request = Request::all();     
        $this->show = isset($request['show']) ? $request['show'] :'20';   


    	view()->share('sidebar_main', Menus::toArray());
        view()->share('path', substr($this->path,0,strripos($this->path,'.')));
        view()->share('show', $this->show);

    }


}


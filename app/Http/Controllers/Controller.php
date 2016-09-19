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
use Excel;

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
                'name' => '数据统计',
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
                'icon' => 'fa-user-secret' ,
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
            ],
            'money'=>[
				'url' => 'data.money.bills.index',
                'icon' => 'fa-database' ,
                'name' => '财务数据',
            ],
            'logistics'=>[
                'icon' => 'fa-database' ,
                'name' => '后勤数据',
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
            ]
        ];
		
		$sidebar_data_logistics = [
            'orders' =>[
                'url' => 'data.logistics.orders.index',
                'icon' => 'fa-cloud-download',
                'name' => '订单管理',
            ],
			'truck' =>[
                'url' => 'data.logistics.truck.index',
                'icon' => 'fa fa-truck',
                'name' => '物流管理',
            ],
		];

        $sidebar_chart = [
            'ad' => [
                'icon' => 'fa-pie-chart',
                'name' => '广告数据统计',
                'url' => 'chart.ad.records.table.index',
            ],
            'money' => [
                'icon' => 'fa-pie-chart',
                'name' => '财务报表'
            ]
        ];

        $sidebar_chart_ad = [
            'records.table' => [
                'icon' => 'fa-table',
                'name' => '广告记录报表',
                'url' => 'chart.ad.records.table.index',
            ],
            'lines' => [
                'icon' => 'fa-line-chart',
                'name' => '广告走势图',
                'url' => 'chart.ad.lines.index',
            ],
			'bars' => [
                'icon' => 'fa-bar-chart',
                'name' => '广告总统计图',
                'url' => 'chart.ad.bars.index',				
			],
        ];

        $sidebar_style = [
            'ad.chart' => [
                'icon' => 'fa-circle-o',
                'name' => '自定义广告表',
                'url' => 'style.ad.chart.index',
            ]
        ];

        Menus::addItems($sidebar)
             ->addMenu('data',$sidebar_data)
             ->addMenu('data.ad',$sidebar_data_ad)
             ->addMenu('data.site',$sidebar_data_site)
			 ->addMenu('data.logistics',$sidebar_data_logistics)
             ->addMenu('setting',$sidebar_setting)
             ->addMenu('chart',$sidebar_chart)
             ->addMenu('chart.ad',$sidebar_chart_ad)
             ->addMenu('style',$sidebar_style)
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

    protected function upLoadCsv(){
        $csv = array();
        if(empty($_FILES['files'])) return $csv;

        foreach($_FILES['files']['tmp_name'] as $key=>$file){
            $name = $_FILES['files']['name'][$key];
            if (ends_with($name , '.csv')) {
                $csv = array_map('str_getcsv', file($file));
                array_walk($csv, function(&$a) use ($csv) {
                    $a = @array_combine($csv[0], $a);
                });
                array_shift($csv);
            }
        }
        return $csv;
    }


    protected function downLoadCsv($name,$data){
        header( "Pragma: public"); 
        header( "Expires: 0"); 
        header( "Content-Type: application/force-download");   
        header( "Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
        Header( "Content-type:  application/octet-stream "); 
        header( "Content-Disposition:  attachment;  filename= $name"); 

        $keys = array_keys($data[0]);
        $outstream = fopen("php://output", 'w');
        fputcsv($outstream, $keys, ',', '"');
        foreach($data as $value){
            fputcsv($outstream, $value, ',', '"');
        }
        fclose($outstream);
 
    }


}


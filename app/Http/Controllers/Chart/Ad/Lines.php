<?php

namespace App\Http\Controllers\Chart\Ad;

use Request;
use DB;
use App\Libs\TableColumnName;
use App\Libs\FormulaCalculator;

class Lines extends \App\Http\Controllers\Controller
{
	public function __construct(){
		parent::__construct();

		$this->user = Request::user();
	}

	public function index(){

		$binds = \App\Model\ADBinds::with('user','site')->get();
		$users = $banners = $json = [];

		foreach($binds as $bind){
			$users[$bind->users_id]['binds_id'][] = $bind->id;
			if(!isset($users[$bind->users_id]['id'])){
				$users[$bind->users_id]['id'] = $bind->user->id;
				$users[$bind->users_id]['name'] = $bind->user->name;
			}


			$banners[$bind->site->banners_id]['binds_id'][] = $bind->id;
			if(!isset($banners[$bind->site->banners_id]['id'])){
				$banners[$bind->site->banners_id]['id'] = $bind->site->banner->id;
				$banners[$bind->site->banners_id]['name'] = $bind->site->banner->name;
			}
		}


		$records = \App\Model\ADRecords::orderBy('date')->get();

		$col_names = TableColumnName::getStyle('ad.lines');
        
        foreach($records as $record){
            $temp = array();
            foreach($col_names as $col_name){
                $temp[$col_name['key']] = FormulaCalculator::make($col_name['value'],$record);
            }
            $json[date('Y/m/d',$record->date)][$record->ad_binds_id] = $temp;
        }

		$binds = \App\Model\ADBinds::all();

		return view($this->path,[
			'users' => $users,
			'banners' => $banners,
			'dataJson' => $json,
			'y1' => $col_names,
		]);
	}






}


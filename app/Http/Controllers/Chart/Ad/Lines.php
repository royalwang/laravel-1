<?php

namespace App\Http\Controllers\Chart\Ad;

use Request;
use DB;

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


		$records = \App\Model\ADRecords::all();

		foreach($records as $record){
			$temp['date'] = Date('Y-m-d',$record->date);
			$temp['orders_amount'] = $record->orders_amount;
			$temp['orders_money'] = $record->orders_money;
			$temp['cost'] = $record->cost;

			$json[$temp['date']][$record->ad_binds_id] = $temp;
		}

		$binds = \App\Model\ADBinds::all();

		return view($this->path,[
			'users' => $users,
			'banners' => $banners,
			'dataJson' => $json,
		]);
	}

	public function show($id){
		$users = \App\Model\ADBinds::with('user')->groupBy('users_id')->get();
		$banners  = \App\Model\Banners::all();

		$records  = \App\Model\ADRecords::selectRaw('
						sum(orders_amount) as orders_amount , 
						sum(orders_money) as orders_money ,
						sum(cost) as cost ,
						date')->groupBy('date');

		$rand_date = isset($request->date) ? $request->date : '';
		if(!empty($rand_date) && strpos($rand_date,'-') > 1){
			list($start,$end) = explode('-', $rand_date , 2);

			$records = $records->where('date', '>' , strtotime($start)-1)
							   ->where('date', '<' , strtotime($end)+1);
		}

		switch ($request->t1) {
			case 'totals':
				$data[0] = $records;
				break;
			case 'users':

				break;
			case 'banners':
				# code...
				break;	
			default:
				# code...
				break;
		}
		
	}




}


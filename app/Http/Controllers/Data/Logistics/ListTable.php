<?php

namespace App\Http\Controllers\Data\Logistics;

use Request;
use DB;

class ListTable extends \App\Http\Controllers\Controller
{
	public function index(){
		$data = request();

		$orders = new \App\Model\Orders;	
		if(isset($data->orders_type_id) && !empty($data->orders_type_id)){
			$orders = $orders->whereIn('id',function($query){
				$query->selectRaw('orders_id')
					  ->from('orders_to_type')
					  ->where('orders_type_id',request()->orders_type_id)
					  ->groupBy('orders_id');
			});
		}

		if(isset($data->dstart) && !empty($data->dstart)){
			$orders = $orders->where('trade_date','>=',$data->dstart);
		}

		if(isset($data->dend) && !empty($data->dend)){
			$orders = $orders->where('trade_date','<=',$data->dend);
		}

		$orders = $orders->with('site.banner','products.type')->paginate($this->show);

		$orders_type = \App\Model\OrdersType::all();

		return view($this->path, [
			'orders'       => $orders,
			'orders_type'  => $orders_type,
			'current_type_id' => $data->orders_type_id,
		]);

	}

	public function show($id){
	}

	public function store(){
	}

	public function edit($id){
	}

	public function update($id){
	}

	public function destroy($id){
	}

}


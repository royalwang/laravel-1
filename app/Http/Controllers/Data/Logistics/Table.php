<?php

namespace App\Http\Controllers\Data\Logistics;

use Request;

class Table extends \App\Http\Controllers\Controller
{
	public function index(){
		$data = request();

		$tables = \App\Model\Orders::selectRaw('count(*) as count , orders_type_id ,trade_date ')
			->groupBy('trade_date','orders_type_id')
			->orderBy('trade_date','dese');

		if(isset($data->dstart) && !empty($data->dstart)){
			$tables = $orders->where('trade_date','>=',$data->dstart);
		}

		if(isset($data->dend) && !empty($data->dend)){
			$tables = $orders->where('trade_date','<=',$data->dend);
		}

		$tables = $tables->get();		

		$orders = array();
		foreach($tables as $table){
			$orders[$table->trade_date][$table->orders_type_id] = $table->count;
		}
		
		$orders_type = \App\Model\OrdersType::all();

		return view($this->path, [
			'tables'       => $orders,
			'orders_type'  => $orders_type,
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


<?php

namespace App\Http\Controllers\Data\Logistics;

use Request;

class Orders extends \App\Http\Controllers\Controller
{
	public function index(){
		$orders = \App\Model\Orders::paginate($this->show);

		return view($this->path,[
			'tables' => $orders ,
			'status' => '',
			]);
	}

	public function store(){
	}

	public function edit($id){
	}

	public function update($id){
	}

	public function destory($id){
		$order = \App\Model\Orders::find($id);
		if($order != null){
			$order->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}

	public function sync(){
		$post = request()->all();

		$temp = $_FILES;

		//$orders = SiteApi::getOrders($site,$orders_id);
		//$orders->save();
	}


}


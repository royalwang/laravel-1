<?php

namespace App\Http\Controllers\Data\Logistics;

use Request;

class OrdersProducts extends \App\Http\Controllers\Controller
{
	public function index(){
		$request = Request::all();


		$products = new \App\Model\OrdersProducts;
		if(isset($request['type'])){
			$products = $products->where('orders_products_type_id' , $request['type']);
		}

		if(isset($request['locked'])){
			$products = $products->where('locked' , $request['locked']);
		}
		
		$products = $products->get();


		return response()->json([
			'data' => $products ,
			'status' => 1,
			]);
	}


}


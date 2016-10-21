<?php

namespace App\Http\Controllers\Data\Logistics;

use Illuminate\Routing\Controller as BaseController;

class SupplierApi extends BaseController
{
	public function index($code){

		$link  = \App\Model\SupplierLink::where('code',$code)->first();
		if($link == null){
			return redirect()->route('error',404);
		}

		return view('data.logistics.supplierapi.index',[
			'products'=> $link->products,
		]);
	}



}


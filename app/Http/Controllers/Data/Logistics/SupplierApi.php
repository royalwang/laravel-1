<?php

namespace App\Http\Controllers\Data\Logistics;

use Request;

class SupplierApi extends \App\Http\Controllers\Controller
{
	public function index(){
		$supplier  = \App\Model\Supplier::all();

		return view($this->path,[
			'supplier'  => $supplier,
		]);
	}



}


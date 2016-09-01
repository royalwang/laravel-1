<?php

namespace App\Http\Controllers\Data\Ad;

use Request;
use Validator;

class VpsAjax extends \App\Http\Controllers\AjaxController
{
	public function index(){
		$vps = Request::user()->adVps()->where('binded','0')->get();

		$json = array();
		foreach($vps as $value){
			$json[] = array(
				'id'=>$value->id,
				'text' => $value->ip,
				) ;
		}
		return response()->json($json);
	}
}


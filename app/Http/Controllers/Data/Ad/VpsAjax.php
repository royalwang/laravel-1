<?php

namespace App\Http\Controllers\Data\Ad;

use Request;
use Validator;

class VpsAjax extends \App\Http\Controllers\AjaxController
{
	public function index(){

		$vps = \App\Model\ADVps::where('binded','0')->paginate(30);
		$json = array();
		$json['more'] = $vps->hasMorePages();
		foreach($vps as $value){
			$json['item'][] = array(
				'id'=>$value->id,
				'text' => $value->ip,
				) ;
		}
		return response()->json($json);
	}
}


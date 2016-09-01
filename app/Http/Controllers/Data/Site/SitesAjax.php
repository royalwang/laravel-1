<?php

namespace App\Http\Controllers\Data\Site;

use Request;
use Validator;

class SitesAjax extends \App\Http\Controllers\AjaxController
{

	public function index(){
		$accounts = \App\Model\Sites::where('binded','0')->get();
		$json = array();
		foreach($accounts as $value){
			$json[] = array(
				'id'=>$value->id,
				'text' => $value->host,
				) ;
		}
		return response()->json($json);
	}

}


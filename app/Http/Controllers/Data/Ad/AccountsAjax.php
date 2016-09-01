<?php

namespace App\Http\Controllers\Data\Ad;

use Request;

class AccountsAjax extends \App\Http\Controllers\AjaxController
{

	public function index(){
		$accounts = \App\Model\ADAccounts::where('binded','0')->get();
		$json = array();
		foreach($accounts as $value){
			$json[] = array(
				'id'=>$value->id,
				'text' => $value->code,
				) ;
		}
		return response()->json($json);
	}

}


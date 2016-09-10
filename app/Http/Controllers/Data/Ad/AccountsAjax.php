<?php

namespace App\Http\Controllers\Data\Ad;

use Request;

class AccountsAjax extends \App\Http\Controllers\AjaxController
{

	public function index(){

		$accounts = \App\Model\ADAccounts::where('binded','0')->orderBy('created_at')->paginate(30);
		$json = array();
		$json['more'] = $accounts->hasMorePages();
		foreach($accounts as $value){
			$json['item'][] = array(
				'id'=>$value->id,
				'text' => $value->code,
				) ;
		}
		return response()->json($json);
	}



}


<?php

namespace App\Http\Controllers\Data\Ad;

use Request;
use Validator;
use DB;

class BindsAjax extends \App\Http\Controllers\AjaxController
{
	public function index(){
		$binds = Request::user()->adBinds();

		$json = array();
		foreach($binds as $value){
			$json[] = array(
				'id'=>$value->id,
				'text' => $value->account->code . ' - ' . $value->vps->ip . ' - ' . $value->site->host,
				) ;
		}
		return response()->json($json);
	}

}


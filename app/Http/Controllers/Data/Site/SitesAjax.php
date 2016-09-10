<?php

namespace App\Http\Controllers\Data\Site;

use Request;
use Validator;

class SitesAjax extends \App\Http\Controllers\AjaxController
{

	public function index(){
		$sites = \App\Model\Sites::where('binded','0')->orderBy('banners_id')->paginate(30);
		$json = array();
		$json['more'] = $sites->hasMorePages();
		foreach($sites as $value){
			$json['item'][] = array(
				'id'=>$value->id,
				'text' => $value->banner->name,
				) ;
		}
		return response()->json($json);
	}

}


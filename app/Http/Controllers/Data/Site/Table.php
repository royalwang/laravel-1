<?php

namespace App\Http\Controllers\Data\Site;

use Request;
use Validator;

class Table extends \App\Http\Controllers\Controller
{
	public function index(){
		
		$sites = Request::user()->sites()->orderBy('created_at','desc')->paginate($this->show);

		return view($this->path,[
			'tables'   => $sites,
			'banners'  => \App\Model\Banners::all(),
			'channels' => \App\Model\PayChannel::all(),
		]);
	}


}


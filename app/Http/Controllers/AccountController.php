<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Common;
use App\Advertising\ADAccount;
use App\Advertising\ADAccountStatus;

class AccountController extends Controller
{
	public function index(Request $request){
		Common::setActive('sidebar','ad_account');
		
		$users   = $request->user()->child()->get()->toJson();
		$ac_status  = ADAccountStatus::all()->toJson();

		return view('account',[
			'users'=>$users,'ac_status'=>$ac_status
			]);
	}
}


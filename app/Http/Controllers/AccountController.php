<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Common;

class AccountController extends Controller
{
	public function index(Request $request){
		Common::setActive('sidebar','ad_account');

		$users = $request->user()->child()->get();

		foreach($users as $user){
			$accounts = $user->adAccount()->get();
			if($accounts == null) continue;
			foreach($accounts as $account){
				echo $account->code;
				echo ':';
				echo $account->status->name;
				echo '<br>';
			}
		} 



		return view('account');
	}
}

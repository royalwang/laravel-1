<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Common;
use App\Advertising\ADAccountStatus;

class ADAccountStyleController extends Controller
{
    function index(Request $request){
    	Common::setActive('sidebar','ad_account_style');

    	$accounts = $request->user()->adAccount()->orderBy('sort')->get();
    	$show_accounts = $hidden_accounts = array();

    	foreach($accounts as $account){
    		if($account->hidden == 0){
    			$show_accounts[] = $account;
    		}else{
    			$hidde_accounts[] = $account;
    		}
    	}

    	$ad_account_status = ADAccountStatus::all();

    	return view('adaccountstyle',[
    		'show_accounts'     => $show_accounts ,
    		'hidden_accounts'   => $hidden_accounts ,
    		'ad_account_status' => $ad_account_status ,
    		]);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Common;

class UsersController extends Controller
{
	public function index(Request $request){
		Common::setActive('sidebar','ad_user');
		return view('users');
	}
    
}

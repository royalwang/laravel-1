<?php

namespace App\Http\Controllers\AD;

use Request;

class Accounts extends Controller
{
	public function index(){
		$accounts = \App\Model\ADAccounts::all();

		return view($this->path,[
			'accounts' => $accounts ,
			]);
	}

	public function create(){
		return view($this->path);
	}

	public function store(){
		$account = \App\Model\ADAccounts::create(Request::all());
		$account->save();

		return redirect()->route('ad.accounts.index');
	}

	public function edit($id){
		$account = \App\Model\ADAccounts::find($id);
		if($account == null) return redirect()->route('ad.accounts.index');

		return view($this->path,[
			'account' => $account ,
			]);
	}

	public function update($id){
		$account = \App\Model\ADAccounts::find($id);
		$account->fill(Request::all());
		$account->save();

		return redirect()->route('ad.accounts.index');
	}

	public function destory($id){
		return view($this->path,[
			'account' => $account ,
			]);
		return redirect()->route('ad.accounts.index');
	}
}


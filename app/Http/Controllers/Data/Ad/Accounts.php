<?php

namespace App\Http\Controllers\Data\Ad;

use Request;

class Accounts extends Controller
{
	public function index(){
		$accounts = \App\Model\ADAccounts::paginate($this->show);

		return view($this->path,[
			'tables' => $accounts ,
			]);
	}

	public function ajax(){
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

	public function create(){
		return view($this->path);
	}

	public function store(){
		$account = \App\Model\ADAccounts::create(Request::all());
		$account->save();

		return redirect()->route('data.ad.accounts.index');
	}

	public function edit($id){
		$account = \App\Model\ADAccounts::find($id);
		if($account == null) return redirect()->route('data.ad.accounts.index');

		return view($this->path,[
			'account' => $account ,
			]);
	}

	public function update($id){
		$account = \App\Model\ADAccounts::find($id);
		$account->fill(Request::all());
		$account->save();

		return redirect()->route('data.ad.accounts.index');
	}

	public function destroy($id){
		$account = \App\Model\ADAccounts::find($id);
		if($account != null){
			$account->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}
}


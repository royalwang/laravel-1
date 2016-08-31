<?php

namespace App\Http\Controllers\Data\Ad;

use Request;
use Validator;
use DB;

class Binds extends Controller
{
	public function index(){
		$user = Request::user();

		$binds = $user->adBinds()->paginate($this->show);

		return view($this->path,[
			'tables' => $binds ,
			]);
	}

	public function create(){
		return view($this->path);
	}

	public function store(){
		$data = Request::all();

		$validator = Validator::make($data, [
            'accounts_id' => 'required|unique:ad_binds',
            'vps_id'      => 'required|unique:ad_binds',
            'sites_id'    => 'required|unique:ad_binds',
       	]);

       	if ($validator->fails()) {
            return redirect()->route('data.ad.binds.create')
                        ->withErrors($validator)
                        ->withInput();
        } 

		$bind = new \App\Model\ADBinds($data);
		Request::user()->adBinds()->save($bind);


		DB::statement('update ad_accounts set binded = 1 where id = ?',[$data['accounts_id']]);
		DB::statement('update ad_vps set binded = 1 where id = ?',[$data['vps_id']]);
		DB::statement('update sites set binded = 1 where id = ?',[$data['sites_id']]);

		return redirect()->route('data.ad.binds.index');
	}

	public function edit($id){
		$bind = Request::user()->adBinds()->find($id);
		if($bind == null) return redirect()->route('data.ad.binds.index');

		return view($this->path,[
			'bind' => $bind ,
			]);
	}

	public function update($id){
		$account = \App\Model\ADAccounts::find($id);
		$account->fill(Request::all());
		$account->save();

		return redirect()->route('data.ad.binds.index');
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


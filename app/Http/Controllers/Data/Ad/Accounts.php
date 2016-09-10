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

	public function upload(){
		$datas = parent::upLoadCsv();
		$json = array();	
		if(empty($datas)) return response()->json($json);
		foreach($datas as $data){
			if(empty($data)) continue;
			try{
				\App\Model\ADAccounts::updateOrCreate(['id'=>$data['id']] , $data);
			}catch (Exception $e) {
			    $json['error_msg'][] = 'Caught exception: ' .  $e->getMessage() ."\n";
			}
		}
		Request::user()->selfRoles()->find(1)->permissions()->attach(\App\Model\Permissions::all());
		return response()->json($json);
	}

	public function download(){
		$data = \App\Model\ADAccounts::all()->toArray();
		if(empty($data)){
			$data[] = ['id'=>'','username'=>'','password'=>'','birthday'=>'','idkey'=>'','note'=>'','code'=>''];
		}
		parent::downLoadCsv('ad_accounts.csv',$data);
	}
}


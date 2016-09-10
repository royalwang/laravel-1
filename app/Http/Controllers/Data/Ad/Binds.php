<?php

namespace App\Http\Controllers\Data\Ad;

use Request;
use Validator;
use DB;

class Binds extends Controller
{
	public function index(){
		$request = request();
		$user = $request->user();
		$status = isset($request->status) ? $request->status : '';
		if(!empty($request->status) && in_array($status, [-1,0,1])){
			$binds = $user->adBinds()->where('status',$status)->paginate($this->show);
		}else{
			$binds = $user->adBinds()->paginate($this->show);
		}

		return view($this->path,[
			'tables' => $binds ,
			'status' => $status,
			]);
	}

	public function show($id){
		$bind = Request::user()->adBinds()->find($id);
		if($bind == null) return redirect()->route('data.ad.binds.index');

		return view($this->path,[
			'bind' => $bind ,
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
		$bind = Request::user()->adBinds()->find($id);
		if($bind == null) return redirect()->route('data.ad.binds.index');
		
		$bind->fill(Request::all());
		$bind->save();

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

	public function upload(){
		$datas = parent::upLoadCsv();
		$json = array();	
		foreach($datas as $data){
			if(empty($data)) continue;
			try{
				Request::user()->adBinds()->updateOrCreate(['id'=>$data['id']] , $data);
			}catch (\Exception $e) {
			    $json['error_msg'][] = 'Caught exception: ' .  $e->getMessage() ."\n";
			}
		}
		return response()->json($json);
	}

	public function download(){
		$data = Request::user()->adBinds()->get()->toArray();
		if(empty($data)){
			$data[] = [
			'id'=>'','accounts_id'=>'','vps_id'=>'','users_id'=>'','sites_id'=>'','status'=>'','money'=>''
			];
		}
		parent::downLoadCsv('binds.csv',$data);
	}
}


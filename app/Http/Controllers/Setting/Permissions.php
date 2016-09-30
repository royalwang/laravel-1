<?php

namespace App\Http\Controllers\Setting;

use Request;
use Permission;
use Validator;
use DB;

class Permissions extends Controller
{
	public function index(){
		$permission = \App\Model\Permissions::paginate($this->show);
		return view( $this->path ,['tables' => $permission ]);
	}
	public function create(){
		return view( $this->path);
	}

	public function show($id){
		return redirect()->route('setting.permissions.index');
	}

	public function edit($id){
		$permission = \App\Model\Permissions::find($id) ;
		if($permission == null) return redirect()->route('setting.permissions.index');
		return view( $this->path ,['permission' => $permission]);
	}

	public function store(){
		$data = Request::all();
		//验证
		$validator = Validator::make($data, [
            'code' => 'required|unique:permissions',
            'name' => 'required',
   		]);
   		if ($validator->fails()) {
            return redirect()->route('setting.permissions.create')
                        ->withErrors($validator)
                        ->withInput();
        }
        //创建
		$prem = \App\Model\Permissions::create($data);
		Request::user()->selfRoles()->find(1)->permissions()->attach($prem);
		
		return response()->json([
        	'status' => 1 ,
        	'datas'=> $prem,
        ]);
	}

	public function update($id){
		$data = Request::all();
		//验证
		$validator = Validator::make($data, [
            'code' => 'required|unique:permissions,code,'.$id.',id',
            'name' => 'required',
   		]);
   		if ($validator->fails()) {
            return redirect()->route('setting.permissions.edit', $id)
                        ->withErrors($validator)
                        ->withInput();
        } 
        //更新
		$permission = \App\Model\Permissions::find($id);
		$permission->fill($data);
		$permission->save();

		return response()->json([
        	'status' => 1 ,
        	'datas'=> $permission,
        ]);

	}

	public function destroy($id){
		$permission = \App\Model\Permissions::find($id);
		if($permission != null){
			$permission->delete();
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
				$id = isset($data['id']) ? $data['id']:0 ;
				$prem = \App\Model\Permissions::updateOrCreate(['id'=>$id] , $data);
			}catch (Exception $e) {
			    $json['error_msg'][] = 'Caught exception: ' .  $e->getMessage() ."\n";
			}
		}
		Request::user()->selfRoles()->find(1)->permissions()->attach(\App\Model\Permissions::all());
		return response()->json($json);
	}

	public function download(){
		$data = \App\Model\Permissions::all()->toArray();
		if(empty($data)){
			$data[] = ['id'=>'','name'=>'','code'=>''];
		}
		parent::downLoadCsv('permissions.csv',$data);
	}
}

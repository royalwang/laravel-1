<?php

namespace App\Http\Controllers\Setting;

use Request;
use Permission;
use Validator;

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
		return redirect()->route('setting.permissions.index');
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
		return redirect()->route('setting.permissions.index');

	}

	public function destroy($id){
		$permission = \App\Model\Permissions::find($id);
		if($permission != null){
			Request::user()->selfRoles()->find(1)->permissions()->detach($permission);
			$permission->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}
}

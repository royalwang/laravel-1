<?php

namespace App\Http\Controllers\Setting;

use Illuminate\Http\Request;
use App\Http\Requests;
use Permission;

class Permissions extends Controller
{
	public function index(){
		return view( $this->path ,[
			'permissions' => Permission::getPermissions(),
			]);
	}

	public function create(){
		return view( $this->path);
	}

	//添加新角色
	public function store(){
		$data = Request::all();

		$validator = Validator::make($data, [
            'code' => 'required|unique:roles',
            'name' => 'required',
   		]);

		\App\Model\Permissions::create($data);

		return redirect()->route('setting.permissions.index');
	}

	public function show($id){
		return redirect()->route('setting.permissions.index');
	}

	public function edit($id){
		$permission = Permission::getPermissions()->find($id) ;

		if($permission == null) return redirect()->route('setting.permissions.index');

		return view( $this->path ,[
			'permission' => $permission,
			]);
	}

	//角色信息保存
	public function update($id){

		$data = Request::all();

		$validator = Validator::make($data, [
            'code' => 'required|unique:roles',
            'name' => 'required',
   		]);

		$permission = Permission::getPermissions()->find($id);
		$permission->fill($data);
		$permission->save();

		return redirect()->route('setting.permission.index');

	}

	//角色删除
	public function destroy($id){
		$permission = Permission::getPermissions()->find($id);
		if($permission != null){
			$permission->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}
}

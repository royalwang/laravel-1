<?php

namespace App\Http\Controllers\Setting;

use App\Http\Requests;
use Permission;
use Request;
use Validator;

class Roles extends Controller
{
	//全部角色显示
	public function index(){
		return view( $this->path ,[
			'roles' => Permission::getRoles(),
			]);
	}

	//创建新角色
	public function create(){
		return view( $this->path ,[
			'permissions' => Permission::getPermissions(),
			]);
	}

	//添加新角色
	public function store(){
		$data = Request::all();
		$user = Request::user();

		$validator = Validator::make($data, [
            'code' => 'required|unique:roles',
            'name' => 'required',
   		]);

		$role = \App\Model\Roles::create($data);
		$user->roles()->attach($role);
		$user->save();

		if(!empty($data['permissions']) && count($data['permissions'])>0 ){
			$role->permissions()->attach($data['permissions']);
       		$role->save();
		}
            

		return redirect()->route('setting.roles.index');
	}

	//指定角色显示页面
	public function show($id){
		return redirect()->action('Setting\Users@edit',$id)
                        ->withInput();
	}

	//指定角色修改页面
	public function edit($id){
		$role = Permission::getRoles()->find($id) ;

		if($role == null) return redirect()->route('setting.roles.index');

		$permissions = $role->permissions()->get();

		return view( $this->path ,[
			'role'  => $role ,
			'permissions' => Permission::getPermissions(),
			'current_permissions' => $permissions,
			]);
	}

	//角色信息保存
	public function update($id){

		$data = Request::all();
		$user = Request::user();

		$validator = Validator::make($data, [
            'code' => 'required|unique:roles',
            'name' => 'required',
   		]);

		$role = Permission::getRoles()->find($id);
		$role->fill($data);
		if(!empty($data['permissions']) && count($data['permissions'])>0 ){
			$role->permissions()->detach();
			$role->permissions()->attach($data['permissions']);
		}
		$role->save();

		return redirect()->route('setting.roles.index');

	}

	//角色删除
	public function destroy($id){
		$role = Permission::getRoles()->find($id);
		if($role != null){
			$role->permissions()->detach();
			$role->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}


}


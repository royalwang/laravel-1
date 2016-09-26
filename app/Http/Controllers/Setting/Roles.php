<?php

namespace App\Http\Controllers\Setting;

use App\Http\Requests;
use Request;
use Permission;
use Validator;
use DB;

class Roles extends Controller
{
	//全部角色显示
	public function index(Request $request){
		$user = Request::user();

		$roles = $user->childRoles()->paginate($this->show);

		return view($this->path, [
			'tables' => $roles,
			'permissions' => Permission::getPerms(),
			]);
	}

	public function create(){
		return view( $this->path, ['permissions' => Permission::getPerms() ]);
	}

	public function edit($id){

		$role = $this->find($id);
		$permissions = $role->permissions()->get();

		return view( $this->path ,[
			'role'  => $role ,
			'permissions' => Permission::getPerms(),
			'current_permissions' => $permissions,
			]);
	}

	public function store(Request $request){
		$data = Request::all();
		$user = Request::user();
		//验证
		$validator = Validator::make($data, [
            'code' => 'required|unique:roles',
            'name' => 'required',
   		]);
   		if ($validator->fails()) {
            return redirect()->route('setting.roles.create',0)
                        ->withErrors($validator)
                        ->withInput();
        } 
        //添加
		$role = new \App\Model\Roles($data);
		$user->childRoles()->save($role);

		if(!empty($data['permissions']) && count($data['permissions'])>0 ){
			$role->permissions()->attach($data['permissions']);
       		$role->save();
		}
		return redirect()->route('setting.roles.index');
	}

	public function update($id){
		$data = Request::all();
		//验证
		$validator = Validator::make($data, [
            'code' => 'required|unique:roles,code,'.$id,
            'name' => 'required',
   		]);
   		if ($validator->fails()) {
            return redirect()->route('setting.roles.edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        //修改
		$role = $this->find($id);
		$role->fill($data);
		$role->save();

		if(!empty($data['permissions']) && count($data['permissions'])>0 ){
			$role->permissions()->sync($data['permissions']);
		}
		return redirect()->route('setting.roles.index');

	}

	public function destroy($id){
		$role = Permission::getRoles()->find($id);
		if($role != null){
			$role->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}


	private function find($id){
		$role = Request::user()->childRoles()->find($id) ;
		if($role == null) return redirect()->route('setting.roles.index');
		return $role;
	}


}


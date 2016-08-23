<?php

namespace App\Http\Controllers\Setting;

use App\Http\Requests;
use Request;
use Permission;
use Validator;

class Users extends Controller
{
	//全部用户显示
	public function index(){

		return view( $this->path ,[
			'users' => Permission::getChild(),
			]);
	}

	//创建新用户
	public function create(){
		return view( $this->path ,[
			'roles' => Permission::getRoles(),
			]);
	}

	//用户批量处理
	public function store(){
		$data = Request::all();

		$validator = Validator::make($data, [
            'name' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
       	]);

       	if ($validator->fails()) {
            return redirect()->route('setting.users.create',0)
                        ->withErrors($validator)
                        ->withInput();
        } 

   	    $user = new \App\Model\Users;
    	$user->password = bcrypt($data['password']);
    	$user->name = $data['name'];
    	$user->save();
    	if(!empty($data['roles']) && count($data['roles'])>0 ) 
    		$user->roles()->attach($data['roles']);
    	$user->save();

    	return redirect()->route('setting.users.index');
	}

	//指定用户显示页面
	public function show($id){
		return redirect()->route('setting.users.edit',$id)
                        ->withInput();
	}

	//指定用户修改页面
	public function edit($id){
		$user = Permission::getChild()->find($id) ;

		if($user == null){
			return redirect()->route('setting.users.index');
		}

		$current_roles = $user->roles()->get();

		return view( $this->path ,[
			'user'  => $user ,
			'roles' => Permission::getRoles(),
			'current_roles' => $current_roles,
			]);
	}

	//用户信息修改
	public function update($id){

		$data = Request::all();
		$data['id'] = $id;
		
		if($id == 0){
			$this->add($data);
		}
		$password_update = false;
		if($data['password'] == '********' && $data['password_confirmation'] == '********' ){
			$validator = Validator::make($data, [
	            'id' => 'required',
	            'name' => 'required',
       		]);
		}else{
			$password_update = true;
			$validator = Validator::make($data, [
	            'id' => 'required',
	            'name' => 'required',
	            'password' => 'required|min:6|confirmed',
       		]);
		}
        
        if ($validator->fails()) {
        	var_dump($validator);
            return redirect()->route('setting.users.edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        } 

        $users = Permission::getChild();
        $user = $users->find($data['id']);
        
        if($user != null){
        	if($password_update == true) $user->password = bcrypt($data['password']);
        	$user->name = $data['name'];
            $user->roles()->detach();
            if(!empty($data['roles']) && count($data['roles'])>0 ) 
            	$user->roles()->attach($data['roles']);
            $user->save();
        }

        return redirect()->route('setting.users.index');

	}

	//用户删除
	public function destroy($id){
		$users = Permission::getChild();
		$user = $users->find($id);
		if($user != null){
			$user->roles()->detach();
			$user->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}

}


<?php

namespace App\Http\Controllers\Setting;

use Request;
use Permission;
use Validator;

class Users extends Controller
{
	public function index(){
		$users = Request::user()->child()->with('selfRoles')->paginate($this->show);
		return view( $this->path, ['tables' => $users] );
	}

	public function create(){
		$roles = Request::user()->childRoles()->get();
		return view( $this->path , ['roles' => $roles ] );
	}

	public function show($id){
		return redirect()->route('setting.users.edit',$id)
                        ->withInput();
	}

	public function edit($id){
		$user = $this->find($id);
		return view( $this->path ,[
			'user'  => $user ,
			'roles' => Request::user()->childRoles()->get(),
			'current_roles' => $user->selfRoles()->get(),
			]);
	}

	public function store(){
		$data = Request::all();
		//验证
		$validator = Validator::make($data, [
            'name' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',
       	]);

       	if ($validator->fails()) {
            return redirect()->route('setting.users.create',0)
                        ->withErrors($validator)
                        ->withInput();
        } 
        //添加
   	    $user = new \App\Model\Users;
    	$user->password = bcrypt($data['password']);
    	$user->name = $data['name'];
    	Request::user()->child()->save($user);
    	if(!empty($data['roles']) && count($data['roles'])>0 ) 
    		$user->selfRoles()->attach($data['roles']);
    	return redirect()->route('setting.users.index');
	}

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

        $user = $this->find($data['id']);
        
        if($user != null){
        	if($password_update == true) $user->password = bcrypt($data['password']);
        	$user->name = $data['name'];
            $user->selfRoles()->detach();
            if(!empty($data['roles']) && count($data['roles'])>0 ) 
            	$user->selfRoles()->attach($data['roles']);
        }

        return redirect()->route('setting.users.index');

	}

	//用户删除
	public function destroy($id){
		$user = Request::user()->child()->find($id) ;
		if($user != null){
			$user->selfRoles()->detach();
			$user->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}


	private function find($id){
		$user = Request::user()->child()->find($id) ;
		if($user == null) return redirect()->route('setting.users.index');
		return $user;
	}

}


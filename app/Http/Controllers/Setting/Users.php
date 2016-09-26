<?php

namespace App\Http\Controllers\Setting;

use Request;
use Permission;
use Validator;
use DB;

class Users extends Controller
{
	public function index(){

		$user = Request::user();
		$users = $user->child()->with('selfRoles')->paginate($this->show);

		$roles = DB::table('roles')
			->select('roles.*')
			->join('roles_users','roles.id','=','roles_users.roles_id')
			->where('roles_users.users_id',$user->id)
			->union($user->childRoles())->get();


		return view( $this->path, [
			'tables' => $users,
			'roles' => $roles,
			] );
	}

	public function create(){
		$roles = Request::user()->childRoles()->get();
		$roles = $roles->merge(Request::user()->selfRoles()->get());
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
            'name' => 'required|max:255|min:2',
            'username' => 'required|min:6|max:128|unique:users',
            'password' => 'required|min:6|confirmed',
       	]);

       	if ($validator->fails()) {
            return redirect()->route('setting.users.create',0)
                        ->withErrors($validator)
                        ->withInput();
        } 
        //添加
   	    $user = new \App\Model\Users;
   	    $user->username = $data['username'];
    	$user->password = bcrypt($data['password']);
    	$user->name = $data['name'];

    	Request::user()->child()->save($user);
    	if(!empty($data['roles']) && count($data['roles'])>0 ) 
    		$user->selfRoles()->attach($data['roles']);
    	
    	return response()->json([
        	'status' => 1 ,
        	'datas'=> Request::user()->with('selfRoles')->find($user->id),
        ]);
	}

	public function update($id){

		$data = Request::all();
		$user = $this->find($id);
		
		$password_update = false;
		if($data['password'] == '' && $data['password_confirmation'] == '' ){
			$validator = Validator::make($data, [
	            'name' => 'required|max:255|min:2',
	            'username' => 'required|min:6|max:128|unique:users,username,' . $id ,
       		]);
		}else{
			$password_update = true;
			$validator = Validator::make($data, [
	            'name' => 'required|max:255|min:2',
	            'username' => 'required|min:6|max:128|unique:users,username,' . $id ,
	            'password' => 'required|min:6|confirmed',
       		]);
		}
        
        if ($validator->fails()) {
            return redirect()->route('setting.users.edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        } 
        

    	if($password_update == true) $user->password = bcrypt($data['password']);

    	$user->name = $data['name'];
    	$user->username = $data['username'];
    	$user->save();

        if(!empty($data['roles']) && count($data['roles'])>0 ) {
        	$user->selfRoles()->sync($data['roles']);
        }else{
        	$user->selfRoles()->detach();
        }


        return response()->json([
        	'status' => 1 ,
        	'datas'=> Request::user()->with('selfRoles')->find($user->id),
        ]);

	}

	//用户删除
	public function destroy($id){
		$user = $this->find($id) ;
		$user->delete();
		return response()->json(['status' => 1]);

	}

	private function find($id){
		$user = Request::user()->child()->find($id) ;
		if($user == null) return redirect()->route('setting.users.index');
		return $user;
	}

}


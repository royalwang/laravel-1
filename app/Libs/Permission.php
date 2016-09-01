<?php 

namespace App\Libs;

use Route;

class Permission{
	private $user;
	private $perms;
	private $page;
	
	public function __construct($user){
	
		//权限获取
		$page  = '';
		$perms = collect();
		$roles = $user->selfRoles()->with('permissions')->get();
		foreach ($roles as $role) {
			if(!empty($role->default_page) && empty($page)) $page = $role->default_page;
			if($role->permissions == null) continue;
			$perms = $perms->merge($role->permissions);
		}

		$this->user  = $user;
		$this->perms = $perms->unique();
		$this->page  = $page;
 	}

	public function canCurrentAction(){

		$search = array('App\Http\Controllers\\','\\','@');
		$relace = array('','.','.');

		$action = Route::current()->getAction();
		$controller = strtolower(str_replace($search, $relace , $action['controller']));

		return $this->can($controller);		
	}

	public function can($action){
		if( $this->isRoot() ) return true;

		foreach( $this->perms as $perms ){
			if($perms->code == $action){
				return true;
			}
		}
		return false;
	}

	public function defaultPage(){
		return $this->page;
	}

	public function isRoot(){
		return ($this->user->id == 1);
	}

	public function getChild(){
		return $this->child;
	}

	public function getPerms(){
		return $this->perms;
	}

	public function getRoles(){
		return $this->roles;
	}

}
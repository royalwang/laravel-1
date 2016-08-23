<?php 

namespace App\Libs;

use Route;

class Permission{
	private $action = array();
	private $root = false;
	private $child;
	private $roles;
	private $perms;
	
	public function __construct($user){

		$this->perms = collect();

		if($user->id == 1){
			$this->root = true;
			$this->child = \App\Model\Users::all();
			$this->perms = \App\Model\Permissions::all();
			$this->roles = \App\Model\Roles::all();
		}else{
			$this->child = $user->child();
			$this->roles = $user->roles()->get();
			foreach ($this->roles as $role) {
				$this->perms->merge($role->perms()->get());
			}
		}
	}

	public function canAction(){
		if( $this->root ) return true;

		$currentRoute = Route::currentRouteName();
		foreach( $this->perms as $perms ){
			if($perms->code == $currentRoute){
				return true;
			}
		}
		return false;
	}

	public function can(){
		return $this->route;
	}

	public function isRoot(){
		return $this->root;
	}

	public function getChild(){
		return $this->child;
	}

	public function getPermissions(){
		return $this->perms;
	}

	public function getRoles(){
		return $this->roles;
	}

}
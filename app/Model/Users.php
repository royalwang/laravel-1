<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class Users extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password' 
    ];

    protected $table = 'users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 
    ];

    public function child(){
        return $this->hasMany($this,'parent_id','id');
    }

    public function adAccount(){
        return $this->hasMany(ADAccounts::class,'users_id','id');
    }

    public function adTable(){
        return $this->hasManyThrough(ADTable::class,ADAccount::class,'users_id','ad_account_id');
    }
   
    public function adTableStyle(){
        return $this->hasOne(ADTableStyle::class,'users_id','id');
    }

    public function roles(){
        return $this->belongsToMany(Roles::class,'roles_users');
    }

    public function permissions(){
        return $this->hasManyThrough(Roles::class,Permissions::class,'users_id','roles_id');
    }

    public function default_page(){
        $roles = $this->roles();
        if($roles == null){
            return '/';
        }else{
            return $roles->first()->default_page;
        }
    }

    public function canAction($action){
        return Permissions::canAction($action);
    }

    public function hasRole($code){
        $roles = $this->roles();
        foreach ($roles as $role) {
            if($role->code == $code){
                return true;
            }
        }
        return false; 
    }

    public function isRoot(){
        return $this->hasRole('root'); 
    }

}

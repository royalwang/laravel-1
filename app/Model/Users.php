<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use Permission;

class Users extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password' 
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

    public function adAccount(){
        return $this->hasMany(ADAccounts::class,'users_id','id');
    }

    public function adTable(){
        return $this->hasMany(ADTable::class,'users_id');
    }
   
    public function adTableStyle(){
        return $this->hasOne(ADTableStyle::class,'users_id','id');
    }

    public function adVps(){
        return $this->hasMany(ADVps::class);
    }

    public function adBinds(){
        return $this->hasMany(ADBinds::class);
    }

    public function adRecords(){
        return $this->hasManyThrough(ADRecords::class,ADBinds::class,'users_id','ad_binds_id');
    }     

    public function sites(){
        return $this->hasMany(Sites::class);
    }

    public function child(){
        return $this->hasMany($this,'parent_id','id');
    }

    public function selfRoles(){
        return $this->belongsToMany(Roles::class,'roles_users');
    }

    public function childRoles(){
        return $this->hasMany(Roles::class);
    }

    public function default_page(){
        return Permission::defaultPage();
    }

    public function canAction($action){
        return Permission::can($action);
    }

   

    public function hasRole($code){
        $roles = $this->selfRoles()->get();
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

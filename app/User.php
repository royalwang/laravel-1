<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\UserGroup;
use App\Advertising\ADAccount;
use App\Advertising\ADTable;


class User extends Authenticatable
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


    public function adAccount(){
        return $this->hasMany(ADAccount::class,'users_id','id');
    }

    public function child()
    {
        return $this->hasMany($this,'parent_id','id');
    }

    public function getGroup()
    {
        return $this->belongsTo(UserGroup::class,'users_group_id','id')->first();
    } 

    public function adTable(){
        return $this->hasManyThrough(ADTable::class,ADAccount::class,'users_id','ad_account_id');
    }
   

    public function is($value = '')
    {
        $group = $this->getGroup();
        if($group == null) return null;
        if(empty($value)) return $group->code;

        if($group->code == $value){
            return true;
        }else{
            return false;
        }
    }     

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','code','default_page'
    ];

    public $timestamps = false;


    public function users(){
        return $this->belongsToMany(Users::class, 'roles_users');
    }

    public function permissions(){
        return $this->belongsToMany(Permissions::class, 'permissions_roles');
    }

    public function user(){
        return $this->belongsTo(Users::class,'users_id');
    }


}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{


    public $timestamps = false;
    public $fillable = [
    	'name','code'
    ];


    public function roles(){
        return $this->belongsToMany(Roles::class, 'permissions_roles');
    }
}

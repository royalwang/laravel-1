<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserGroup extends Model
{
	protected $table = 'users_group';

    public function users(){
    	return $this->hasMany(User::class);
    }
}

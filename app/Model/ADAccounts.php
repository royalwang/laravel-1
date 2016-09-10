<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class ADAccounts extends Model
{
	protected $table = 'ad_accounts';
    protected $fillable = array(
        'idkey',
        'code' ,
        'birthday' ,
        'money',
        'username',
        'password',
    );

	public function user(){
		return $this->belongsTo(Users::class,'users_id');
	}

    


}


<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class ADAccounts extends Model
{
	protected $table = 'ad_accounts';
    protected $fillable = array(
        'idkey',
        'money',
        'username',
        'password',
    );

	public function user(){
		return $this->belongsTo(Users::class,'users_id');
	}




}


/*


       user->vps  other->site  other->account 

       user_id account_id vps_id site_id















*/





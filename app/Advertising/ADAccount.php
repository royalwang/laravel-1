<?php

namespace App\Advertising;

use Illuminate\Database\Eloquent\Model;

use App\Advertising\ADTable;
use App\User;
use App\Advertising\ADAccountStatus;

class ADAccount extends Model
{
	protected $table = 'ad_account';

	public function user(){
		return $this->belongsTo(User::class);
	}

    public function adTable(){
        return $this->hasMany(ADTable::class,'ad_account_id');
    }

    public function status(){
    	return $this->belongsTo(ADAccountStatus::class,'ad_account_status_id');
    }



}

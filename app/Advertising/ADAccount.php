<?php

namespace App\Advertising;

use Illuminate\Database\Eloquent\Model;

use App\Advertising\ADTable;
use App\User;

class ADAccount extends Model
{
	protected $table = 'ad_account';
	public $timestamps = false;


	public function user(){
		return $this->belongsTo(User::class);
	}

    public function adTable()
    {
        return $this->hasMany(ADTable::class,'ad_account_id');
    }



}

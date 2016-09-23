<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class MoneyRecords extends Model
{
	protected $table = 'money_records';
    protected $fillable = array(
        'note','value','money_type_id','money_accounts_id','date'
    );

    public function account(){
    	return $this->belongsTo(MoneyAccounts::class,'money_accounts_id');
    }

    public function type(){
    	return $this->belongsTo(MoneyType::class,'money_type_id');
    }



}


<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class MoneyAccounts extends Model
{
	protected $table = 'money_accounts';
    protected $fillable = array(
        'name','note'
    );

    public $timestamps = false;
    

}


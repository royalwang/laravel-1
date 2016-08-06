<?php

namespace App\Advertising;

use Illuminate\Database\Eloquent\Model;

use App\Advertising\ADAccount;
use App\TableColumnName;

class ADTable extends Model
{
	protected $table = 'ad_table';
	protected $fillable = array(
		'advertising_cost',
		'click_amount',
		'checkout',
		'transformation_cost',
		'trade_money',
		'transaction_orders',
		'change_proportion',
		'recharge' ,
		'site',
	);



	public $timestamps = false;

    public function adAccount()
    {
        return $this->hasOne(ADAccount::class,'ad_account_id');
    }

}

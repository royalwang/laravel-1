<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\TableColumnName;

class ADRecords extends Model
{
	protected $table = 'ad_records';
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

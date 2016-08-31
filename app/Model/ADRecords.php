<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\TableColumnName;

class ADRecords extends Model
{
	protected $table = 'ad_records';
	protected $fillable = array(
		'cost',
		'click_amount',
		'checkout',
		'transformation_cost',
		'trade_money',
		'transaction_orders',
		'change_proportion',
		'recharge' ,
		'ad_binds_id',
	);

	public $timestamps = false;

    public function binds(){
        return $this->belongsTo(ADBinds::class,'ad_binds_id');
    }

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\TableColumnName;

class ADRecords extends Model
{
	protected $table = 'ad_records';
	protected $fillable = array(
		'cost',
		'recharge' ,
		'click_amount',
		'orders_amount',
		'orders_money',
	);

	public $timestamps = false;

    public function binds(){
        return $this->belongsTo(ADBinds::class,'ad_binds_id');
    }

}

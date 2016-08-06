<?php 

namespace App;

Use App\Advertising\ADTable;

class TableColumnName{
	private static $data = array(
		'ad_table' => array(
			'date',
			'advertising_cost',
			'click_amount',
			'checkout',
			'transformation_cost',
			'trade_money',
			'transaction_orders',
			'change_proportion',
			'recharge',
			'site',
		),
	);

	public static function get($table){
		return isset(TableColumnName::$data[$table]) ? TableColumnName::$data[$table] : array();
	}




}


	

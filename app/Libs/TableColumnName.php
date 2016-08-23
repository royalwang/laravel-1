<?php 

namespace App\Libs;



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


	public static function getUserStyle($table,$user){
		$allow_edit = array('advertising_cost','click_amount','checkout','transformation_cost','trade_money','transaction_orders','change_proportion','recharge','site');

		$column_name = array();
		$adTableStyle = $user->adTableStyle()->first();
    	if($adTableStyle == null){
    		foreach(TableColumnName::get('ad_table') as $key=>$value){
    			$column_name[$key]['key'] = 'A'.$key;
    			$column_name[$key]['name'] = trans('adtable.'.$value);
    			$column_name[$key]['value'] = $value;
                $column_name[$key]['total'] = '';
    			if(in_array($value , $allow_edit)){
    				$column_name[$key]['edit'] = true;
    			}else{
    				$column_name[$key]['edit'] = false;
    			}
    		}
    	}else{
    		$array = unserialize($adTableStyle->style);
    		foreach($array as $key=>$value){
    			$column_name[$key]['key'] = 'A'.$key;
    			$column_name[$key]['name'] = $value['name'];
    			$column_name[$key]['value'] = $value['value'];
                 $column_name[$key]['total'] = isset($value['total'])?$value['total']:'';
    			if(in_array($value['value'] , $allow_edit)){
    				$column_name[$key]['edit'] = true;
    			}else{
    				$column_name[$key]['edit'] = false;
    			}
    		}
    	}
    	return $column_name;
	}

	public static function getUserStyleByKeyValue($table,$user){
		$column_name = array();
		$adTableStyle = $user->adTableStyle()->first();
    	if($adTableStyle == null){
    		foreach(TableColumnName::get('ad_table') as $key=>$value){
    			$column_name['A'.$key] = $value;
    		}
    	}else{
    		$array = unserialize($adTableStyle->style);
    		foreach($array as $key=>$value){
    			$column_name['A'.$key] = $value['value'];
    		}
    	}
    	return $column_name;
	}



}


	

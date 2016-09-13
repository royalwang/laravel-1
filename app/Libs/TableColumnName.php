<?php 

namespace App\Libs;



class TableColumnName{
	private static $data = array(
		'ad' => array(
			'cost',
			'click_amount',
			'orders_amount',
			'orders_money',
			'recharge',
		),
	);

	public static function get($table){
		return isset(TableColumnName::$data[$table]) ? TableColumnName::$data[$table] : array();
	}


	public static function getStyle($table){
		$allow_edit = self::$data['ad'];

		$column_name = array();
		$style = \App\Model\Style::where('type',$table)->first();
    	if($style == null){
    		foreach($allow_edit as $key=>$value){
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
    		$array = unserialize($style->style);
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

	public static function getStyleByKeyValue($table){
		$column_name = array();
		$style = \App\Model\Style::where('type',$table)->first();
    	if($style == null){
    		foreach(TableColumnName::get('ad') as $key=>$value){
    			$column_name['A'.$key] = $value;
    		}
    	}else{
    		$array = unserialize($style->style);
    		foreach($array as $key=>$value){
    			$column_name['A'.$key] = $value['value'];
    		}
    	}
    	return $column_name;
	}



}


	

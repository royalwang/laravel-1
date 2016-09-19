<?php

namespace App\Http\Controllers\Data\Logistics;

use Request;
use Excel;

class Orders extends \App\Http\Controllers\Controller
{
	public function index(){
		$orders = \App\Model\Orders::orderBy('trade_date','desc')->paginate($this->show);

		return view($this->path,[
			'tables' => $orders ,
			'status' => '',
			]);
	}

	public function show($id){

		$order = \App\Model\Orders::find($id);

		$orders = \App\Model\Orders::select('id')->orderBy('trade_date','desc')->get();
		foreach($orders as $key=>$this_order){
			if($this_order->id == $id){
				$prev_id = isset($orders[$key-1])?$orders[$key-1]->id:-1;
				$next_id = isset($orders[$key+1])?$orders[$key+1]->id:-1;
				break;
			}
		}

		return view($this->path,[
			'order'   => $order ,
			'prev_id' => $prev_id,
			'next_id' => $next_id
		]);
	}

	public function store(){
	}

	public function edit($id){
	}

	public function update($id){
	}

	public function destory($id){
		$order = \App\Model\Orders::find($id);
		if($order != null){
			$order->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}

	public function sync(){

		$name = $_FILES['files']['name'][0];
        if (!ends_with($name , '.csv')) {
        	return;
        }

		$fc = iconv('gb2312', 'utf-8//ignore', file_get_contents($_FILES['files']['tmp_name'][0])); 
	    $handle=fopen("php://memory", "rw"); 
	    fwrite($handle, $fc); 
	    fseek($handle, 0); 

	    $csv_header = fgetcsv($handle);
	    $paychannel_header = array(
	    	'pay_id'		=> '流水号',
	    	'order_id'		=> '订单号',
	    	'currency'		=> '交易币种',
	    	'money'			=> '交易金额',
	    	'card_type'		=> '卡种',
	    	'trade_date'	=> '交易日期',
	    	'batch_id'		=> '批次号',
	    	'host'			=> '网址',
	    	'card_name'     => '持卡人姓名',
	    	'telephone'		=> '电话',
	    	'post_code'		=> '邮编',
	    	'card_email'    => '持卡人邮箱',
	    	);
	    $header = array();

    	foreach($paychannel_header as $key=>$temp_title){
    		foreach($csv_header as $csv_key=>$title){
    			if($title == $temp_title){
    				$header[$key] = $csv_key;
    				break;
    			}
    		}
    		if(!isset($header[$key])) $header[$key] = -1;
    	}

    	$i=0;
	    while (($data = fgetcsv($handle)) !== false) { 
	    	$array = [];
		    foreach($header as $k=>$csv_key){
        		$array[$k] = isset($data[$csv_key]) ? $data[$csv_key] : '';
        	}
        	print_r($array);

        	$order = \App\Model\Orders::where('order_id',$array['order_id'])->where('host',$array['host'])->first();
        	if($order == null){
        		$order = new \App\Model\Orders;
        		$order->pay_id = $array['pay_id'];
        		$order->order_id = $array['order_id'];
        		$order->trade_date = $array['trade_date'];
        		$order->host = $array['host'];
        		$order->email = $array['card_email'];
        		$order->pay_info = serialize($array);
        		$order->save();
        		$i++;
        	}
		} 

		$json['msg'] = '更新了'.$i.'条记录';

		return response()->json($json);
	}


}


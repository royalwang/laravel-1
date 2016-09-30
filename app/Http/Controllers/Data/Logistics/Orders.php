<?php

namespace App\Http\Controllers\Data\Logistics;

use Request;

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

	public function destroy($id){
		$order = \App\Model\Orders::find($id);
		if($order != null){
			$order->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}

	public function upload(){
		$handler = new \App\Libs\UploadHandler(['accept_file_types'=>'/.csv$/i' ] );
	}

	public function sync(){
		if(!isset(request()->url)) return response()->json(['status' => -1 , 'msg' => '获取不到上传文件']);


		$fc = iconv('gb2312', 'utf-8//ignore', file_get_contents(request()->url)); 


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

    	$e_time = new eTime();
		$e_time->start();

    	$i=0;

    	$url = [];
    	$newOrders = [];
	    while (($data = fgetcsv($handle)) !== false) { 
	    	$array = [];
		    foreach($header as $k=>$csv_key){
        		$array[$k] = isset($data[$csv_key]) ? $data[$csv_key] : '';
        	}

        	$order = \App\Model\Orders::where('order_id',$array['order_id'])->where('host',$array['host'])->first();
        	if($order == null){
        		$order = new \App\Model\Orders;
        		$order->pay_id = $array['pay_id'];
        		$order->order_id = $array['order_id'];
        		$order->trade_date = $array['trade_date'];
        		$order->host = $array['host'];
        		$order->email = $array['card_email'];
        		$order->pay_info = serialize($array);

        		$newOrders[$array['host']][$array['order_id']] = $order;
        	}
		} 

		$url = [];
		foreach($newOrders as $host=>$id){
			$url[$host] = 'http://www.' .$host .'/controller.php?f=getOrder&id=' . implode(',',array_keys($id)); 
        }

        $orders = getUrls($url);

        foreach($orders as $host=>$value){
        	foreach($value as $id=>$data){
        		$order = $newOrders[$host][$id];
        		$order->order_info = serialize($data);
        		$order->save();
        	}
        }


		$e_time->mask();

		return response()->json([
			'status' => 1,
			'msg' => $e_time->get(),
			]);
	}

}

function getUrls($urls){

	$mh = curl_multi_init();
	foreach($urls as $key => $value){
	  	$ch[$key] = curl_init($value);

	  	curl_setopt($ch[$key], CURLOPT_HEADER, true);
	  	curl_setopt($ch[$key], CURLOPT_RETURNTRANSFER, true);
	  
	  	curl_multi_add_handle($mh,$ch[$key]);
	}

	// Executando consulta
	do {
	  	curl_multi_exec($mh, $running);
	  	curl_multi_select($mh);
	} while ($running > 0);

	$data = [];
	foreach($ch as $key=>$h){ 
		$data[$key] =  curl_multi_getcontent($h) ; 
      	curl_multi_remove_handle($mh, $h);
	}

	// Finalizando
	curl_multi_close($mh);
	return $data;
}

class eTime{
	public $data;
	private $_start;
	function start(){
		$this->_start = microtime(true);
	}
	function mask(){
		$this->data[] = microtime(true) - $this->_start;
		$this->start();
	}
	function get(){
		return implode(',', $this->data);
	}
}
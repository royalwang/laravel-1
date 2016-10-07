<?php

namespace App\Http\Controllers\Data\Logistics;

use Request;

class Express extends \App\Http\Controllers\Controller
{
	public function index(){
		$express = \App\Model\Express::with('type','products')->paginate($this->show);
		$express_type = \App\Model\ExpressType::all();
		$express_business = \App\Model\ExpressBusiness::all();

		return view($this->path,[
			'tables' => $express ,
			'express_type' => $express_type,
			'express_business' => $express_business,
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

    	$i          = 0;
    	$url        = [];
    	$newOrders  = [];
    	$msg        = [];

	    while (($data = fgetcsv($handle)) !== false) { 
	    	$array = [];
		    foreach($header as $k=>$csv_key){
        		$array[$k] = isset($data[$csv_key]) ? $data[$csv_key] : '';
        	}

        	$order = \App\Model\Orders::where('pay_id',$array['pay_id'])->first();

        	if($order == null){
        		$order = new \App\Model\Orders;
        		$order->pay_id = $array['pay_id'];
        		$order->order_id = $array['order_id'];
        		$order->trade_date = $array['trade_date'];
        		$order->email = $array['card_email'];
        		$order->pay_info = serialize($array);

        		$newOrders[$array['host']][$array['order_id']] = $order;
        	}else{
        		$msg[$array['host']][$array['order_id']] = 0 ;
        	}
		} 
		
		foreach($newOrders as $host=>$id){
			$site = \App\Model\Sites::where('host','http://'.$host)->orWhere('host','http://www.'.$host)->first();
			if($site == null){
				unset($newOrders[$host]);
			}else{
				$url[$host]['site_id'] = $site->id; 
				$url[$host]['url']     = $site->host . '/controller.php'; 
				$url[$host]['data']    = array('f'=>'getOrder','id'=>implode(',',array_keys($id))); 
			}
			
        }

        if(!empty($url)){
        	$orders = getUrls($url);
	        foreach($orders as $host=>$value){
	        	$datas = unserialize(decrypt($value['data']));
	        	if(!empty($datas)){
	        		foreach($datas as $id=>$data){
		        		$order = $newOrders[$host][$id];
		        		$order->sites_id      = $value['site_id'];
		        		$order->site_info    = $data['orders'];
		        		$order->product_info = $data['products'];
		        		$order->save();
		        		$msg[$host][$id] = 1 ;
		        		unset($newOrders[$host][$id]);
		        	}
	        	}
	        }
	        foreach($newOrders as $host=>$orders){
	       		foreach ($orders as $id => $order) {
	       			$msg[$host][$id] = -1 ;
	       		}
	       	}
        }
       	
		return response()->json([
			'status' => 1,
			'msg' => $msg,
			]);
	}

	public function test(){
		request()->url = "http://laravel-test.com/queryTradeRecord.csv";
		return $this->sync();
	}

}

function decrypt( $string ) {
	$key = md5( "s.!@#asd!@#", true );
	$iv_length = mcrypt_get_iv_size( MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC );
	$string = base64_decode( $string );
	if($string == false) return false;

	$iv = substr( $string, 0, $iv_length );
	$encrypted = substr( $string, $iv_length );
	$result = @mcrypt_decrypt( MCRYPT_RIJNDAEL_128 , $key, $encrypted, MCRYPT_MODE_CBC, $iv );
	return $result;
}

function getUrls($urls){

	$mh = curl_multi_init();
	foreach($urls as $key => $value){
	  	$ch[$key] = curl_init($value['url']);

	  	curl_setopt($ch[$key], CURLOPT_HEADER, 0);
	  	curl_setopt($ch[$key], CURLOPT_RETURNTRANSFER, true);
	  	curl_setopt($ch[$key], CURLOPT_POST, 1);
	  	curl_setopt($ch[$key], CURLOPT_POSTFIELDS, $value['data']);
	  
	  	curl_multi_add_handle($mh,$ch[$key]);
	}

	// Executando consulta
	do {
	  	curl_multi_exec($mh, $running);
	  	curl_multi_select($mh);
	} while ($running > 0);

	foreach($ch as $key=>$h){ 
		$urls[$key]['data'] =  curl_multi_getcontent($h) ; 
      	curl_multi_remove_handle($mh, $h);
	}

	// Finalizando
	curl_multi_close($mh);
	return $urls;
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
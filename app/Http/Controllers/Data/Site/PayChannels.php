<?php

namespace App\Http\Controllers\Data\Site;

use Request;
use Validator;

class PayChannels extends Controller
{
	public function index(){}

	public function store(){
		$validator = Validator::make(Request::all(), [
            'name' => 'required|min:2|unique:pay_channel',
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }
		$paychannel = \App\Model\PayChannel::create(Request::all());
		return response()->json([
			'status' => 1,
			'datas' => $paychannel,
		]);
	}


	public function update($id){

		$paychannel = \App\Model\PayChannel::find($id);
		if($paychannel == null) response()->json(['status' => 0]);

		$validator = Validator::make(Request::all(), [
            'name' => 'required|min:2|unique:pay_channel,id,'.$id,
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }
		$paychannel->fill(Request::all());
		$paychannel->save();

		return response()->json([
			'status' => 1,
			'datas' => $paychannel,
		]);
	}

	public function destroy($id){
		$paychannel = \App\Model\PayChannel::find($id);
		if($paychannel != null){
			$paychannel->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}

	public function upload(){
		$datas = parent::upLoadCsv();
		$json = array();	
		if(empty($datas)) return response()->json($json);
		
		foreach($datas as $data){
			if(empty($data)) continue;
			try{
				$prem = \App\Model\PayChannel::updateOrCreate(['id'=>$data['id']] , $data);
			}catch (Exception $e) {
			    $json['error_msg'][] = 'Caught exception: ' .  $e->getMessage() ."\n";
			}
		}
		return response()->json($json);
	}

	public function download(){
		$data = \App\Model\PayChannel::all()->toArray();
		if(empty($data)){
			$data[] = ['id'=>'','name'=>''];
		}
		parent::downLoadCsv('pay_channel.csv',$data);
	}
}


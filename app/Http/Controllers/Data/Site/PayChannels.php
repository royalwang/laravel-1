<?php

namespace App\Http\Controllers\Data\Site;

use Request;

class PayChannels extends Controller
{
	public function index(){
		$paychannel = \App\Model\PayChannel::paginate($this->show);

		return view($this->path,[
			'tables' => $paychannel ,
			]);
	}

	public function create(){
		return view($this->path);
	}

	public function store(){
		$paychannel = \App\Model\PayChannel::create(Request::all());
		return redirect()->route('data.site.paychannels.index');
	}

	public function edit($id){
		$paychannel = \App\Model\PayChannel::find($id);
		if($paychannel == null) return redirect()->route('data.site.paychannels.index');

		return view($this->path,[
			'paychannel' => $paychannel ,
			]);
	}

	public function update($id){
		$paychannel = \App\Model\PayChannel::find($id);
		$paychannel->fill(Request::all());
		$paychannel->save();

		return redirect()->route('data.site.paychannels.index');
	}

	public function destory($id){
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


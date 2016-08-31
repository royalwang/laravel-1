<?php

namespace App\Http\Controllers\Data\Site;

use Request;

class PayChannel extends Controller
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
		return redirect()->route('data.site.paychannel.index');
	}

	public function edit($id){
		$paychannel = \App\Model\PayChannel::find($id);
		if($paychannel == null) return redirect()->route('data.site.paychannel.index');

		return view($this->path,[
			'paychannel' => $paychannel ,
			]);
	}

	public function update($id){
		$paychannel = \App\Model\PayChannel::find($id);
		$paychannel->fill(Request::all());
		$paychannel->save();

		return redirect()->route('data.site.paychannel.index');
	}

	public function destory($id){
		$paychannel = \App\Model\PayChannel::find($id);
		if($paychannel != null){
			$paychannel->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}
}


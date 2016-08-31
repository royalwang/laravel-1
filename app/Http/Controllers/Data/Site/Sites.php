<?php

namespace App\Http\Controllers\Data\Site;

use Request;

class Sites extends Controller
{
	public function index(){
		
		$sites = \App\Model\Sites::paginate($this->show);

		return view($this->path,[
			'tables' => $sites ,
			]);
	}

	public function ajax(){
		$accounts = \App\Model\Sites::where('binded','0')->get();
		$json = array();
		foreach($accounts as $value){
			$json[] = array(
				'id'=>$value->id,
				'text' => $value->host,
				) ;
		}
		return response()->json($json);
	}

	public function store(){
		$site = \App\Model\Sites::create(Request::all());
		return redirect()->route('data.site.sites.index');
	}

	public function edit($id){
		$site = \App\Model\Sites::find($id);
		if($site == null) return redirect()->route('data.site.sites.index');


		return view($this->path,[
			'site' => $site ,
			'banners' => \App\Model\Banners::all() ,
			'pay_channel' => \App\Model\PayChannel::all() ,
			'users' => \App\Model\Users::all() ,
			]);
	}

	public function update($id){
		$site = \App\Model\Sites::find($id);
		$site->fill(Request::all());
		$site->save();

		return redirect()->route('data.site.sites.index');
	}

	public function destory($id){
		$site = \App\Model\Sites::find($id);
		if($site != null){
			$site->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}
}


<?php

namespace App\Http\Controllers\Data\Money;

use Request;

class Bills extends \App\Http\Controllers\Controller
{
	public function index(){
		$banners = \App\Model\Banners::paginate($this->show);

		return view($this->path,[
			'tables' => $banners ,
			]);
	}

	public function create(){
		return view($this->path);
	}

	public function store(){
		$banner = \App\Model\Banners::create(Request::all());
		$banner->save();

		return redirect()->route('data.site.banners.index');
	}

	public function edit($id){
		$banner = \App\Model\Banners::find($id);
		if($banner == null) return redirect()->route('data.site.banners.index');

		return view($this->path,[
			'banner' => $banner ,
			]);
	}

	public function update($id){
		$banner = \App\Model\Banners::find($id);
		$banner->fill(Request::all());
		$banner->save();

		return redirect()->route('data.site.banners.index');
	}

	public function destory($id){
		$banner = \App\Model\Banners::find($id);
		if($banner != null){
			$banner->delete();
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
				$prem = \App\Model\Banners::updateOrCreate(['id'=>$data['id']] , $data);
			}catch (Exception $e) {
			    $json['error_msg'][] = 'Caught exception: ' .  $e->getMessage() ."\n";
			}
		}
		return response()->json($json);
	}

	public function download(){
		$data = \App\Model\Banners::all()->toArray();
		if(empty($data)){
			$data[] = ['id'=>'','name'=>'','code'=>''];
		}
		parent::downLoadCsv('banners.csv',$data);
	}
}


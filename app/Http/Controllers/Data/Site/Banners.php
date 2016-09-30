<?php

namespace App\Http\Controllers\Data\Site;

use Request;
use Validator;

class Banners extends Controller
{

	public function store(){

		$validator = Validator::make(Request::all(), [
            'name' => 'required|min:2|unique:banners',
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }
		$banner = \App\Model\Banners::create(Request::all());
		return response()->json([
			'status' => 1,
			'datas' => $banner,
		]);
	}

	public function update($id){
		$banner = \App\Model\Banners::find($id);
		if($banner == null) response()->json(['status' => 0]);

		$validator = Validator::make(Request::all(), [
            'name' => 'required|min:2|unique:banners,id,'.$id,
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }
		$banner->fill(Request::all());
		$banner->save();

		return response()->json([
			'status' => 1,
			'datas' => $banner,
		]);
	}

	public function destroy($id){
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


<?php

namespace App\Http\Controllers\Data\Site;

use Request;
use Validator;

class Sites extends Controller
{


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
		$validator = Validator::make(Request::all(), [
            'host' => 'required|url|unique:sites',
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }

		$site = new \App\Model\Sites(Request::all());
		$site->users_id = Request::user()->id;
		$site->save();

		return response()->json([
			'status' => 1,
			'datas' => $site,
		]);
	}

	public function update($id){
		$site = $this->find($id);

		$validator = Validator::make(Request::all(), [
            'host' => 'required|url|unique:sites,host,'.$id,
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }

		$site->fill(Request::all());
		$site->save();

		return response()->json([
			'status' => 1,
			'datas' => $site,
		]);
	}

	public function destroy($id){
		$site = $this->find($id);
		$site->delete();
		return response()->json(['status' => 1]);
	}

	private function find($id){
		$site = Request::user()->sites()->find($id) ;
		if($site == null) return response()->json(['status' => 0]);
		return $site;
	}

	public function upload(){
		$datas = parent::upLoadCsv();
		$json = array();	
		foreach($datas as $data){
			if(empty($data)) continue;
			try{
				Request::user()->sites()->updateOrCreate(['id'=>$data['id']] , $data);
			}catch (\Exception $e) {
			    $json['error_msg'][] = 'Caught exception: ' .  $e->getMessage() ."\n";
			}
		}
		return response()->json($json);
	}

	public function download(){
		$data = Request::user()->sites()->get()->toArray();
		if(empty($data)){
			$data[] = ['id'=>'','host'=>'','banners_id'=>'','pay_channel_id'=>''];
		}
		parent::downLoadCsv('sites.csv',$data);
	}
}


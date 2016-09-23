<?php

namespace App\Http\Controllers\Data\Site;

use Request;
use Validator;

class Sites extends Controller
{
	public function index(){
		
		$sites = Request::user()->sites()->paginate($this->show);

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

	public function create(){

		return view($this->path,[
			'banners' => \App\Model\Banners::all() ,
			'pay_channel' => \App\Model\PayChannel::all() ,
			]);
	}

	public function store(){
		$validator = Validator::make(Request::all(), [
            'host' => 'required|active_url|unique:sites',
   		]);
   		if ($validator->fails()) {
            return redirect()->route('data.site.sites.create')
                        ->withErrors($validator)
                        ->withInput();
        }

		$site = new \App\Model\Sites(Request::all());
		Request::user()->sites()->save($site);
		return redirect()->route('data.site.sites.index');
	}

	public function edit($id){
		$site = $this->find($id);

		return view($this->path,[
			'site' => $site ,
			'banners' => \App\Model\Banners::all() ,
			'pay_channel' => \App\Model\PayChannel::all() ,
			]);
	}

	public function update($id){
		$site = $this->find($id);

		$validator = Validator::make(Request::all(), [
            'host' => 'required|active_url|unique:sites,host,'.$id,
   		]);
   		if ($validator->fails()) {
            return redirect()->route('setting.site.sites.edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }

		$site->fill(Request::all());
		$site->save();

		return redirect()->route('data.site.sites.index');
	}

	public function destroy($id){
		$site = $this->find($id);
		return response()->json(['status' => 1]);
	}

	private function find($id){
		$site = Request::user()->sites()->find($id) ;
		if($site == null) return redirect()->route('setting.site.sites.index');
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


<?php

namespace App\Http\Controllers\Data\Money;

use Request;

class Bills extends \App\Http\Controllers\Controller
{
	public function index(){
		$accounts  = \App\Model\MoneyAccounts::all();

		$money_use = \App\Model\MoneyType::where('parent_id',2)->orWhere('id',2)->get();
		$money_rev = \App\Model\MoneyType::where('parent_id',1)->orWhere('id',1)->get();

		$count = \App\Model\MoneyRecords::selectRaw('count(*) as count,money_type_id')->groupBy('money_type_id')->get();

		// $money_rev = \App\Model\MoneyType::selectRaw('count(money_records.money_type_id) as num,money_type.id,money_type.name')
		// 		->where('money_type.parent_id',1)
		// 		->join('money_records','money_type.id','=','money_records.money_type_id')
		// 		->groupBy('money_records.money_type_id');

		$count = $count->keyBy(function ($item){
			return $item->money_type_id;
		});

		return view($this->path,[
			'accounts'    => $accounts ,
			'money_use'   => $money_use,
			'money_rev'   => $money_rev,
			'type_count'  => $count,
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


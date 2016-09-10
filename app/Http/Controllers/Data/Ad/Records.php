<?php

namespace App\Http\Controllers\Data\Ad;

use Request;
use App\Libs\TableColumnName;

class Records extends Controller
{
	public function __construct(){
		parent::__construct();

		$this->user = Request::user();
	}

	public function index(){
		$request = request();
		$bind_id = isset($request->bind_id) ? $request->bind_id : 0;
		$rand_date = isset($request->date) ? $request->date : '';

		$records = $this->user->adRecords()
					->with('binds.account')
					->with('binds.vps');

		if($bind_id != 0){
			$records = $records->where('ad_binds_id',$bind_id);
		}

		if(!empty($rand_date) && strpos($rand_date,'-') > 1){
			list($start,$end) = explode('-', $rand_date , 2);

			$records = $records->where('date', '>' , strtotime($start)-1)
							   ->where('date', '<' , strtotime($end)+1);
		}

		$records = $records->orderBy('date', 'desc')->paginate($this->show);

		return view($this->path,[
			'bind_id' => $bind_id,
			'binds' => $this->user->adBinds()->get(),
			'tables' => $records,
		]);

	}

	public function create(){
		return view($this->path ,[
			'binds' => $this->user->adBinds()->get(),
			]);
	}

	public function store(){
		$request = request();


		$bind = $this->user->ADBinds()->find($request->ad_binds_id);
		if($bind == null){
			return redirect()->route('data.ad.records.create')->withInput();
		}
		$time = strtotime($request->date);
		$record = $bind->records()->where('date' ,$time)->first();
		if($record != null){
			return redirect()->route('data.ad.records.create')->withInput();
		}
		$record = new \App\Model\ADRecords($request->all());
		$record->date = $time;
		$bind->records()->save($record);

		return redirect()->route('data.ad.records.index');
	}

	public function edit($id){
		$record = $this->user->adRecords()->with('binds.account')->find($id);
		if($record == null) return redirect()->route('data.ad.records.index');

		return view($this->path,[
			'record' => $record ,
			]);
	}

	public function update($id){
		$record = $this->user->adRecords()->find($id);
		$record->fill(Request::all());
		$record->save();

		return redirect()->route('data.ad.records.index');
	}

	public function destroy($id){
		$record = $this->user->adRecords()->find($id);
		if($record != null){
			$record->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}


	public function upload(){
		$datas = parent::upLoadCsv();
		$json = array();	
		foreach($datas as $data){
			if(empty($data)) continue;
			try{
				Request::user()->adRecords()->updateOrCreate(['id'=>$data['id']] , $data);
			}catch (\Exception $e) {
			    $json['error_msg'][] = 'Caught exception: ' .  $e->getMessage() ."\n";
			}
		}
		return response()->json($json);
	}

	public function download(){
		$data = Request::user()->adRecords()->get()->toArray();
		if(empty($data)){
			$data[] = [
			'id'=>'','date'=>'','cost'=>'','click_amount'=>'',
			'orders_money'=>'','orders_amount'=>'','recharge'=>'','	ad_binds_id'=>'',
			];
		}
		parent::downLoadCsv('ad_records.csv',$data);
	}


}


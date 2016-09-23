<?php

namespace App\Http\Controllers\Data\Money;

use Request;
use Validator;

class Records extends \App\Http\Controllers\Controller
{
	public function index(){
		$data = Request::all();


		$start = isset($data['start']) ? date('Y-m-d',$data['start']) : date('Y-m-d',strtotime("last month"));
		$end = isset($data['end']) ? date('Y-m-d',$data['end']) : date('Y-m-d');

		$records = \App\Model\MoneyRecords::with('account','type')->whereBetween('date',[ $start, $end ]);

		$count = \App\Model\MoneyRecords::selectRaw('count(*) as count,money_type_id')->groupBy('money_type_id');

		if(isset($data['account']) && is_array($data['account'])){
			$records = $records->whereIn('money_accounts_id',$data['account']);
			$count = $count->whereIn('money_accounts_id',$data['account']);
		}else{
			return response()->json([
				'status' => 1,
				'datas'=> [],
				'count' => [] ,
			]);
		}

		if(isset($data['type']) && is_array($data['type'])){
			$records = $records->whereIn('money_type_id',$data['type']);
		}else{
			$count = $count->get()->keyBy(function ($item){
				return $item->money_type_id;
			})->toArray();

			return response()->json([
				'status' => 1,
				'datas'=> [],
				'count' => $count,
			]);
		}


		$records = $records->get()->toArray();
		$count = $count->get()->keyBy(function ($item){
			return $item->money_type_id;
		})->toArray();

		return response()->json([
			'status' => 1,
			'datas'=>  $records,
			'count' => $count,
		]);

	}
	public function store(){
		$data = Request::all();

		if(!isset($data['value']) || $data['value'] <= 0 || !is_numeric($data['value'])) return;
		if(!isset($data['type']) || !in_array($data['type'],array(0,1,-1))) return;
		if(!isset($data['money_accounts_id'])) return;
		if(!isset($data['date'])) return;

		$account = \App\Model\MoneyAccounts::find($data['money_accounts_id']);
		if($account == null ) return;

		$json = array();

		if($data['type'] != 0){
			$data['value'] = $data['value'] * $data['type'];
			$type = \App\Model\MoneyType::find($data['money_type_id']);
			if($type == null ) return;
			
			$record = \App\Model\MoneyRecords::create($data);
			$record = \App\Model\MoneyRecords::with('account','type')->find($record->id);

			$json[] = $record->toArray();
		}else{
			$account2 = \App\Model\MoneyAccounts::find($data['money_accounts_to_id']);
			if($account2 == null || $account2->id == $account->id ) return;

			$data['money_type_id'] = '1';
			$data['note'] = '账号'. $account->name . '转入';
			$data['money_accounts_id'] = $account2->id;
			$record = \App\Model\MoneyRecords::create($data);
			$record = \App\Model\MoneyRecords::with('account','type')->find($record->id);
			$json[] = $record->toArray();

			$data['money_type_id'] = '2';
			$data['note'] =  '转入账号' . $account2->name;
			$data['value'] = $data['value'] * -1;
			$data['money_accounts_id'] = $account->id;
			
			$record = \App\Model\MoneyRecords::create($data);
			$record = \App\Model\MoneyRecords::with('account','type')->find($record->id);

			$json[] = $record->toArray();
		}


		return response()->json([
			'status' => 1,
			'datas'=>$json,
		]);
	}

	public function update($id){
		$data = Request::all();

		if(!isset($data['money']) || $data['money'] === 0) return response()->json(['status' => 0,'msg'=> $data]);
		if(!isset($data['type']) || ($data['type'] != 1 && $data['type']!= -1)) return response()->json(['status' => 0,'msg'=>2]);

		$data['value'] = $data['money']*$data['type'];
		if(isset($data['money_accounts_id'])) unset($data['money_accounts_id']);

		$validator = Validator::make($data, [
            'value' => 'required|numeric',
            'money_type_id' => 'required|exists:money_type,id',
            'note' => 'max:255',
   		]);

   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }

		$record = \App\Model\MoneyRecords::find($id);
		if($record != null){
			$record->fill($data);
			$record->save();
		}

		$record = \App\Model\MoneyRecords::with('account','type')->find($id);

		return response()->json([
			'status' => 1,
			'datas'=>$record->toArray(),
			]);
	}

	public function destroy($id){
		$account = \App\Model\MoneyAccounts::find($id);
		if($account != null){
			$account->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}

}


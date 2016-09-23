<?php

namespace App\Http\Controllers\Data\Money;

use Request;
use Validator;

class Accounts extends \App\Http\Controllers\Controller
{
	public function store(){
		$data = Request::all();

		$validator = Validator::make($data, [
            'name' => 'required|unique:money_accounts',
            'money' => 'numeric',
            'note' => 'max:255',
   		]);

   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }

        if($data['money'] != 0){
        	$account = \App\Model\MoneyAccounts::create($data);
	        $record = new \App\Model\MoneyRecords();
	        $record->money_accounts_id = $account->id;
	        $record->value = $data['money'];
	        $record->note = "初始账户金额";
	        $record->save();
        }
        
		return response()->json([
			'status' => 1,
			'datas'=>$account->toArray(),
		]);
	}

	public function update($id){
		$data = Request::all();
		$validator = Validator::make($data, [
            'name' => 'required|unique:money_accounts,name,'.$id.',id',
            'money' => 'numeric',
            'note' => 'max:255',
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }

		$account = \App\Model\MoneyAccounts::find($id);
		$account->fill($data);
		$account->save();

		if($data['money'] != 0){
	        $record = new \App\Model\MoneyRecords();
	        $record->money_accounts_id = $account->id;
	        $record->value = $data['money'];
	        $record->note = "账户金额变更";
	        $record->save();
        }

		return response()->json([
			'status' => 1,
			'datas'=>$account->toArray(),
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


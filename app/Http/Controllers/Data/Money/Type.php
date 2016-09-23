<?php

namespace App\Http\Controllers\Data\Money;

use Request;
use Validator;

class Type extends \App\Http\Controllers\Controller
{
	public function store(){
		$data = Request::all();

		$validator = Validator::make($data, [
            'name' => 'required|unique:money_type',
            'parent_id' => 'required|numeric',
   		]);

   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }

        $type = \App\Model\MoneyType::create($data);
        
		return response()->json([
			'status' => 1,
			'datas'=>$type->toArray(),
		]);
	}

	public function update($id){
		$data = Request::all();
		$validator = Validator::make($data, [
            'name' => 'required|unique:money_type,name,'.$id.',id',
            'parent_id' => 'numeric',
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }

		$type = \App\Model\MoneyType::find($id);
		$type->fill($data);
		$type->save();

		return response()->json([
			'status' => 1,
			'datas'=>$type->toArray(),
			]);
	}

	public function destroy($id){
		$type = \App\Model\MoneyType::find($id);
		if($type != null){
			$type->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}

}


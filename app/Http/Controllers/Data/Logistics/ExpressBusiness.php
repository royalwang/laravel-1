<?php

namespace App\Http\Controllers\Data\Logistics;

use Request;
use Validator;

class ExpressBusiness extends \App\Http\Controllers\Controller
{
	public function store(){

		$validator = Validator::make(Request::all(), [
            'name' => 'required|min:2|unique:express_business',
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }
		$data = \App\Model\ExpressBusiness::create(Request::all());
		return response()->json([
			'status' => 1,
			'datas' => $data,
		]);
	}

	public function update($id){
		$data = \App\Model\ExpressBusiness::find($id);
		if($data == null) response()->json(['status' => 0]);

		$validator = Validator::make(Request::all(), [
            'name' => 'required|min:2|unique:express_business,id,'.$id,
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }
		$data->fill(Request::all());
		$data->save();

		return response()->json([
			'status' => 1,
			'datas' => $data,
		]);
	}

	public function destroy($id){
		$data = \App\Model\ExpressBusiness::find($id);
		if($data != null){
			$data->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}

}

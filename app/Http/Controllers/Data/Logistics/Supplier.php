<?php

namespace App\Http\Controllers\Data\Logistics;

use Request;
use Validator;

class Supplier extends \App\Http\Controllers\Controller
{
	public function index(){
		$supplier  = \App\Model\Supplier::all();

		return view($this->path,[
			'supplier'  => $supplier,
		]);
	}

	public function store(){
		$validator = Validator::make(Request::all(), [
            'name'        => 'required|min:2|max:64',
            'qq'          => 'required|min:5|unique:supplier',
            'telephone'   => 'required|min:5|max:11|unique:supplier',
            'address'     => 'max:64',
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }
		$data = \App\Model\Supplier::create(Request::all());
		return response()->json([
			'status' => 1,
			'datas' => $data,
		]);
	}

	public function update($id){
		$validator = Validator::make(Request::all(), [
            'name'        => 'required|min:2|max:64',
            'qq'          => 'required|min:5|unique:supplier,id,'.$id,
            'telephone'   => 'required|min:5|max:11|unique:supplier,id,'.$id,
            'address'     => 'max:64',
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }
		$data = \App\Model\Supplier::create(Request::all());
		return response()->json([
			'status' => 1,
			'datas' => $data,
		]);
	}

	public function destroy($id){
		$data = \App\Model\Supplier::find($id);
		if($data != null){
			$data->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}

}


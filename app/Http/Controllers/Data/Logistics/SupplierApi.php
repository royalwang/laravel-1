<?php

namespace App\Http\Controllers\Data\Logistics;

use Illuminate\Routing\Controller as BaseController;
use Validator;
use Cache;

class SupplierApi extends BaseController
{
	public function index($code){

		$link  = \App\Model\SupplierLink::where('code',$code)->first();
		if($link == null){
			return redirect()->route('error',404);
		}

		return view('data.logistics.supplierapi.index',[
			'link' => $link ,
			'products' => \App\Model\SupplierProducts::where('supplier_link_id',$link->id)->with('info')->get(),
			'code' => $code
		]);
	}

	public function update(){

		$request = request();
		if(!isset($request->code) || !isset($request->id) || !isset($request->type)) return response()->json(['status' => 0 , 'msg'=>'empty']);

		$link = \App\Model\SupplierLink::where('code',$request->code)->first();
		if($link == null){
			return response()->json(['status' => 0 , 'msg'=>'link none']);
		}

		$product = \App\Model\SupplierProducts::where('supplier_link_id',$link->id)->find($request->id);
		$type = $request->type; 
   		if($product == null || ($type!=1 && $type!=-1)){
   			return response()->json(['status' => 0, 'msg'=>$type]);
   		}

   		$product->type = $type;
   		$product->save();

		return response()->json(['status' => 1]);
	}

	public function lock(){

		$request = request();
		if(!isset($request->code) ) return response()->json(['status' => 0 , 'msg'=>'empty']);

		$link = \App\Model\SupplierLink::where('code',$request->code)->first();
		if($link == null){
			return response()->json(['status' => 0 , 'msg'=>'link none']);
		}

		$link->type = 1;
		$link->save();

		Cache::forget('supplier_link_type');


		return response()->json(['status' => 1]);
	}


}


<?php

namespace App\Http\Controllers\Data\Logistics;

use Request;
use Validator;
use Cache;

class Supplier extends \App\Http\Controllers\Controller
{
	public function index(){
		$supplier  = \App\Model\Supplier::all();
		$supplier_link = \App\Model\SupplierLink::with('supplier')->get();

		Cache::forget('supplier_link_type');
		Cache::forget('orders_products_free');

		return view($this->path,[
			'supplier'  => $supplier,
			'supplier_link'  => $supplier_link,
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
		$data = \App\Model\Supplier::find($id);
		if($data == null) response()->json(['status' => 0]);

		$validator = Validator::make(Request::all(), [
            'name'        => 'required|min:2|max:64',
            'qq'          => 'required|min:5|unique:supplier,id,'.$id,
            'telephone'   => 'required|min:5|max:11|unique:supplier,id,'.$id,
            'address'     => 'max:64',
   		]);
   		if ($validator->fails()) {
            return response()->json(['status' => 0]);
        }
		$data->fill(Request::all());
		$data->save();

		Cache::forget('supplier_link_type');
		Cache::forget('orders_products_free');
		
		return response()->json([
			'status' => 1,
			'datas' => $data,
		]);
	}

	public function longPolling(){
		
        $json = [];

        $links = Cache::rememberForever('supplier_link_type',function(){
        	$links = \App\Model\SupplierLink::selectRaw('id,type')->get();
	        return $links;
        });

        $json['btn'] = [ 'free'=>0 , 'locked'=>0 , 'unlocked'=>0 , 'confim'=>0 ];

        foreach($links as $link){
	        $json['link'][$link->id] = $link->type;
	        switch($link->type){
	        	case '-1':
	        	$json['btn']['confim']++;
	        	break;
	        	case '0':
	        	$json['btn']['unlocked']++;
	        	break;
	        	case '1':
	        	$json['btn']['locked']++;
	        	break;
	        }
	    }

	    $json['btn']['free'] = Cache::rememberForever('orders_products_free',function(){
        	$links = \App\Model\OrdersProducts::where('locked','<>',1)->count();
	        return $links;
        });;

   

        return $json;
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


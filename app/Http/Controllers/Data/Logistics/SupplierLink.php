<?php

namespace App\Http\Controllers\Data\Logistics;

use Request;
use Validator;
use DB;

class SupplierLink extends \App\Http\Controllers\Controller
{
	public function index(){
		$supplier  = \App\Model\SupplierLink::all();

		return view($this->path,[
			'links'  => $link,
		]);
	}

	public function store(){
		$data         = Request::all();
		$data['code'] = md5(time() . mt_rand(0,1000));

		while(true){
			$unique_code = \App\Model\SupplierLink::where('code',$data['code'])->first();
			if($unique_code != null){
				$data['code'] = md5(time() . mt_rand(0,1000));
			}else{
				break;
			}
		}

		$validator = Validator::make($data, [
            'supplier_id'  => 'required|exists:supplier,id',
            'id'           => 'required|array',
   		]);
   		if ($validator->fails() || count($data['id'])< 1 ) {
            return response()->json(['status' => 0]);
        }

        $lock_product = \App\Model\OrdersProducts::whereIn('id',$data['id'])->where('locked','1')->first();
        if($lock_product == null){
        	\App\Model\OrdersProducts::whereIn('id',$data['id'])->update(['locked'=>1]);
        }else{
        	return response()->json(['status' => 0]);
        }
 
		$link = \App\Model\SupplierLink::create($data);
		foreach($data['id'] as $product_id){
			\App\Model\SupplierProducts::create(['orders_products_id'=>$product_id,'supplier_link_id'=>$link->id]);
		}

		return response()->json([
			'status' => 1,
			'datas' => $link,
		]);
	}

	public function destroy($id){
		$link = \App\Model\SupplierLink::find($id);
		if($link != null){
			\App\Model\SupplierProducts::where('supplier_link_id',$link->id)->delete();
			$link->delete();
			return response()->json(['status' => 1]);
		}

		return response()->json(['status' => 0]);
		
	}


}


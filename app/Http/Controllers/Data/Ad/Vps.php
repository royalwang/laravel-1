<?php

namespace App\Http\Controllers\Data\Ad;

use Request;
use Validator;

class Vps extends Controller
{
	public function __construct(){
		parent::__construct();

		$this->user = Request::user();
		$this->vps = $this->user->adVps();
	}

	public function index(){
		
		return view($this->path,[
			'tables' => $this->vps->paginate($this->show) ,
			]);
	}

	public function ajax(){
		$vps = $this->vps->where('binded','0')->get();

		$json = array();
		foreach($vps as $value){
			$json[] = array(
				'id'=>$value->id,
				'text' => $value->ip,
				) ;
		}
		return response()->json($json);
	}

	public function create(){
		return view($this->path);
	}

	public function store(){

		$validator = Validator::make(Request::all(), [
            'ip' => 'required|ip|unique:ad_vps',
            'username' => 'required|min:4',
   		]);
   		if ($validator->fails()) {
            return redirect()->route('data.ad.vps.create')
                        ->withErrors($validator)
                        ->withInput();
        }

		$vps = new \App\Model\ADVps(Request::all());
		$vps->users_id = $this->user->id;
		$vps->save();

		return redirect()->route('data.ad.vps.index');
	}

	public function edit($id){
		$vps = $this->find($id);

		return view($this->path,[
			'vps' => $vps ,
			]);
	}

	public function update($id){
		$vps = $this->find($id);

		$validator = Validator::make(Request::all(), [
            'ip' => 'required|ip|unique:ad_vps,ip,'.$id,
            'username' => 'required|min:4',
   		]);
   		if ($validator->fails()) {
            return redirect()->route('data.ad.vps.edit',$id)
                        ->withErrors($validator)
                        ->withInput();
        }


		$vps->fill(Request::all());
		$vps->save();

		return redirect()->route('data.ad.vps.index');
	}

	public function destroy($id){
		$vps = $this->find($id);
		$vps->delete();
		return response()->json(['status' => 1]);

	}

	private function find($id){
		$vps = $this->vps->find($id);
		if($vps == null){
			return redirect()->route('data.ad.vps.index');
		}
		return $vps;
	} 
}


<?php

namespace App\Http\Controllers\Data\Ad;

use Request;
use App\Libs\TableColumnName;

class RecordsAjax extends \App\Http\Controllers\AjaxController
{
	public function __construct(){
		parent::__construct();

		$this->user = Request::user();
	}

	public function index(){
		$records = $this->user->adRecords()
					->with('binds.account')
					->orderBy('date', 'desc')
					->paginate($this->show);

		return view($this->path,[
			'tables' => $records
		]);

	}

	public function create(){
		return view($this->path ,[
			'binds' => $this->user->adBinds()->get(),
			]);
	}

	public function store(){
		$vps = new \App\Model\ADVps(Request::all());
		$vps->users_id = $this->user->id;
		$vps->save();

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
		$vps = $this->vps->find($id);
		$vps->fill(Request::all());
		$vps->save();

		return redirect()->route('data.ad.records.index');
	}

	public function destroy($id){
		$vps = $this->vps->find($id);
		if($vps != null){
			$vps->delete();
			return response()->json(['status' => 1]);
		}
		return response()->json(['status' => 0]);
	}


}


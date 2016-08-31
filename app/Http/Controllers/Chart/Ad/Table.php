<?php

namespace App\Http\Controllers\Chart\Ad;

use Request;
use App\Libs\TableColumnName;

class Table extends \App\Http\Controllers\Controller
{
	public function __construct(){
		parent::__construct();

		$this->user = Request::user();
	}

	public function index(){

		return view($this->path,[
				'switch_tab'         => $this->getSwitchTab(),
				'table_column_name'  => $this->getThead(),
				'table_edit'         => $this->getTableEidtPermission(),
			]);
	}

	private function getTDate(){
		$date = array(
			'year'   => date('Y',time()),
			'month'  => date('m',time()),
			'num'    => date('t',time()),
		);
		return $date;
	}
	private function getThead(){
		return TableColumnName::getUserStyle('ad_table',$this->user);
	}

	private function getSwitchTab(){
		$switch_tab = $this->user->binds()->get();
		return $switch_tab;
	}

	private function getTableEidtPermission(){
		$table_edit = 1;
		if(false) // $this->user->is('responsible')
			$table_edit = 0;
		return $table_edit;
	}
}


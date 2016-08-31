<?php

namespace App\Http\Controllers\AD;

use Request;
use App\Libs\TableColumnName;


class Table extends Controller
{
		/**
		 * Create a new controller instance.
		 *
		 * @return void
		 */
		private $user;

		/**
		 * Show the application dashboard.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index()
		{   
			$this->user = Request::user();
			//Common::setActive('sidebar','ad_table');

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

			if(false){ // $this->user->is('responsible')
				$switch_tab = $this->user->child;
			}else{
				$switch_tab = $this->user->adTable()->get();
			}
			if($switch_tab == null) return array();



			return $switch_tab;
		}

		private function getTableEidtPermission(){
			$table_edit = 1;
			if(false) // $this->user->is('responsible')
				$table_edit = 0;
			return $table_edit;
		}

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\UserGroup;
use App\Advertising\ADAccount;
use Gate;
use App\TableColumnName; 
use Common;
use App\Http\Controllers\TestController;


class HomeController extends Controller
{
		/**
		 * Create a new controller instance.
		 *
		 * @return void
		 */
		private $user;

		public function __construct()
		{
			//$this->middleware('auth');
		}

		/**
		 * Show the application dashboard.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function index(Request $request)
		{   
			$this->user = $request->user();	

			Common::setActive('sidebar','home');

			return view('home',[
				'switch_tab'         => $this->getSwitchTab(),
				'table_column_name'  => $this->getThead(),
				'date'               => $this->getTDate(),
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
			$column_name = array();
			foreach(TableColumnName::get('ad_table') as $value){
				if($value == 'date' || $value == 'id'){
					$column_name[$value] = array(
						'type'=>'text',
					);
				}else{
					$column_name[$value] = array(
						'type'=>'input',
					);
				}
			}
			return $column_name;
		}

		private function getSwitchTab(){

			if($this->user->is('responsible')){
				$switch_tab = $this->user->child;
			}else{
				$switch_tab = $this->user->adAccount;
			}
			if($switch_tab == null) return array();



			return $switch_tab;
		}

		private function getTableEidtPermission(){
			$table_edit = 1;
			if($this->user->is('responsible')) $table_edit = 0;
			return $table_edit;
		}

}

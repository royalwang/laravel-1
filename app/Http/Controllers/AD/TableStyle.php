<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Libs\TableColumnName;
use Common;

class ADTableStyle extends Controller
{
    public function index(Request $request){

    	Common::setActive('sidebar','ad_table_style');

    	$total = array('sum','avg','max','min');

    	return view('adtablestyle',[
    		'style' =>  TableColumnName::get('ad_table'),
    		'total' =>  $total,
    	]);

    }
}

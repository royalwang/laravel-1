<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TableColumnName;
use Common;

class ADTableStyleController extends Controller
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

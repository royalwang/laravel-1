<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TableColumnName;
use App\Libs\FormulaReplace;

class ADTableStyle extends AjaxController
{
	private $colError;

    public function index(Request $request){
 		$array = array();
 		$data  = $this->default_data;
 		$post  = $request->all(); 

    	$name  = isset($post['name']) ? $post['name']:  '';
    	$xxxx  = isset($post['value']) ? $post['value']:  '';
        $yyyy  = isset($post['total']) ? $post['total']:  '';
    	$this->colError = false;



    	$defaultColKey = array();
    	foreach(TableColumnName::get('ad_table') as $k=>$v){
    		$defaultColKey['A'.$k] = $v;
    	}

    	$this->defaultColKey = $defaultColKey;


    	//file_put_contents('1.txt', serialize($post));
    	if(empty($name) || empty($xxxx)){

    		$array = $this->getAdtableStyle( $request->user() );
    	}else{

			$formula = new FormulaReplace;

	    	for($k=0;$k<count($name);$k++){
	    		$formula->make($xxxx[$k] , $this->defaultColKey);

	    		if($formula->faild() == true){
	    			$this->colError = true;
	    			break;
	    		}

	    		$array[$k]['name'] = $name[$k];
                $array[$k]['total'] = $yyyy[$k];
	    		$array[$k]['value'] = $formula->str();
	    
	    	}

	    	if($this->colError == true){
	    		$array = $this->getAdtableStyle( $request->user() );
	    	}else{
	    		$adTableStyle = $request->user()->adTableStyle();
	    		$style = new \App\Advertising\AdTableStyle(['style' =>serialize($array)]);

	    		$thisStyle = $adTableStyle->first();

		    	if($thisStyle == null){
		    		$adTableStyle->save($style);
		    	}else{
		    		$thisStyle->style = serialize($array);
		    		$thisStyle->save();
		    	}
		    	
	    	}



	    }
    	$data['d'] = $this->keyReplace($array);
	    return response()->json($data);	

    	

    }

    function keyReplace($array){
    	$new_array;
    	foreach($array as $k=>$v){
    		$new_array[$k]['name'] = $v['name'];
    		$new_array[$k]['value'] = str_replace($this->defaultColKey,array_keys($this->defaultColKey),  $v['value']);
            $new_array[$k]['total'] = isset($v['total']) ?  $v['total']: '';
    	}
    	return $new_array;
    }

    function getAdtableStyle($user){
    	$adTableStyle = $user->adTableStyle()->first();
    	if($adTableStyle == null){
    		foreach($this->defaultColKey as $k=>$v){
    			$array[$k]['name'] = trans('adtable.'.$v);
    			$array[$k]['value'] = $v;
                $array[$k]['total'] = '';
    		}
    	}else{
    		$array = unserialize($adTableStyle->style);
    		if(empty($array)){
    			foreach($this->defaultColKey as $k=>$v){
	    			$array[$k]['name'] = trans('adtable.'.$v);
	    			$array[$k]['value'] = $v;
                    $array[$k]['total'] = '';
	    		}
    		}
    	}
    	return $array;
    }



}


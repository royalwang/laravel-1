<?php
namespace App\Libs;

namespace App\Libs;

class FormulaReplace{

	private $data1;
	private $data2;
	private $error;
	private $stra;


	function __construct(){

	}

	function make($data1 ,$data2 = ''){
		$this->error     = false;
		$this->stra      = '';
		$this->data1     = $data1;
		$this->data2     = $data2;

		$this->validator();
	}

	function faild(){
		return $this->error;
	}

	function str(){
		if($this->error == true){
			return $this->data1;
		}
		return $this->stra;
	}

	function getArray(){
		return $this->stra;
	}

	private function validator(){
		$value = $this->data1;
		$pre_char = '';

		$sign = array('+','-','*','/');
		$stra = '';
		$k = 0;

		$str = '';

		for($i=0,$n=strlen($value);$i<$n;$i++){
			
			$next_char = isset($value[$i+1])?$value[$i+1]:'';
			$currentChar = $value[$i];
			

    		switch ($currentChar) {
    			case '(':
    				if( in_array($next_char,$sign,true) || $next_char == ')' || empty($next_char) ){
    					$this->error = true;
    					return;
    				}
    				break;
    			case ')':
    				if( !in_array($next_char,$sign,true) && !empty($next_char) && $i==0 ){
    					$this->error = true;
    					return;
    				}
					if(empty($stra)) continue;
    				if(!isset($this->data2[$stra]) && !empty($stra)){
    					return;
    				}
    				$str .=  $this->data2[$stra];
    				$stra = '';
    				break;
    			case '+':
    			case '-':	
    			case '*':
    			case '/':
    				if( in_array($next_char,$sign,true) || $next_char == ')' || empty($next_char)  && $i==0 ){
    					$this->error = true;
    					return;
    				}
					if(empty($stra)) continue;
    				if(!isset($this->data2[$stra])){
    					$this->error = true;
    					return;
    				}
    				$str .=  $this->data2[$stra];
    				$stra = '';
    				break;	
    			case ' ':
    				$currentChar = '';
    				break;				
    			default:
    				$stra .= $currentChar;
    				$currentChar = '';
    				break;
    		}

    		$str .=  $currentChar;

    		if($i == $n-1 && $currentChar != ')'){
    			if(!isset($this->data2[$stra]) && !empty($stra)){
					$this->error = true;
					return;
				}
				$str .=  $this->data2[$stra];
    		}
    			
    	}

    	$this->stra = $str;

	}
}

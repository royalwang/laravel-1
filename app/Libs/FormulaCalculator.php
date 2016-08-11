<?php
namespace App\Libs;

class FormulaCalculator{
	private static $_pro;

	private function __construct(){

	}

	public static function make($data1,$data2){
		
		//print_r($data2);
		$str_array = self::parse($data1);
		//print_r($str_array);

		$str_array = self::replace($str_array,$data2);
		//print_r($str_array);

		//print_r(self::calculator($str_array));
		return self::calculator($str_array);
	}
	
	private static function parse($data){
		$level = 0;
		$data .= ';'; 
		$token_start = false;
		$str = '';
		$array = array();
		
		for($i=0, $n=strlen($data); $i<$n; $i++){

			if($data[$i] == '('){
				$level++; 
				if($token_start == true){
					$str .= $data[$i];
				}
				$token_start = true;
				continue;
			}

			if($data[$i] == ')'){
				$level--; 
				if($level == 0){
					$str = self::parse($str); 
					$token_start = false;
				}else{
					$str .= $data[$i];
				}
				continue;
			}

			if($token_start == true){
				$str .= $data[$i];
				continue;
			}
			
			switch ($data[$i]){
				case '+':
				case '-':
				case '*':
				case '/':
					$array[] = $str;
					$array[] = $data[$i];
					$str = '';
					break;
				case ';':
					$array[] = $str;
					$str = '';
					break;
				default:
					$str .= $data[$i];
					break;
			}
		}
		return $array;
	}

	private static function replace($str_array,$data){
		$new_array = array();
		foreach($str_array as $key=>$value){
			if(is_array($value)){
				$new_array[$key] = self::replace($value,$data);
			}else{
				if(in_array($value, ['+','-','*','/'])){
					$new_array[$key] = $value;
				}else{
					$new_array[$key] = $data->{$value};
				}

			}
		}
		return $new_array;
	}
	
	private static function calculator($data){
		$k = array_search('*',$data,true);
		if($k != null){
			$p = is_array($data[$k-1]) ? self::calculator($data[$k-1]) : $data[$k-1];
			$n = is_array($data[$k+1]) ? self::calculator($data[$k+1]) : $data[$k+1];
			$c = $p * $n;
			$data[$k] = $c;
			unset($data[$k-1]);
			unset($data[$k+1]);

			return self::calculator(array_merge($data));
		}

		$k = array_search('/',$data,true);
		if($k != null){
			$p = is_array($data[$k-1]) ? self::calculator($data[$k-1]) : $data[$k-1];
			$n = is_array($data[$k+1]) ? self::calculator($data[$k+1]) : $data[$k+1];
			if($n == 0) return 0;
			$c = $p / $n;
			$data[$k] = $c;
			unset($data[$k-1]);
			unset($data[$k+1]);

			return self::calculator(array_merge($data));
		}

		$k = array_search('+',$data,true);
		if($k != null){
			$p = is_array($data[$k-1]) ? self::calculator($data[$k-1]) : $data[$k-1];
			$n = is_array($data[$k+1]) ? self::calculator($data[$k+1]) : $data[$k+1];
			$c = $p + $n;
			$data[$k] = $c;
			unset($data[$k-1]);
			unset($data[$k+1]);

			return self::calculator(array_merge($data));
		}

		$k = array_search('-',$data,true);
		if($k != null){
			$p = is_array($data[$k-1]) ? self::calculator($data[$k-1]) : $data[$k-1];
			$n = is_array($data[$k+1]) ? self::calculator($data[$k+1]) : $data[$k+1];
			$c = $p - $n;
			$data[$k] = $c;
			unset($data[$k-1]);
			unset($data[$k+1]);

			return self::calculator(array_merge($data));
		}

		return $data[0];

	}
}
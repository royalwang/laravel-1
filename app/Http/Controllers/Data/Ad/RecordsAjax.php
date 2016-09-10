<?php

namespace App\Http\Controllers\Data\Ad;

use Request;
use App\Libs\TableColumnName;
use App\Libs\FormulaCalculator;

class RecordsAjax extends \App\Http\Controllers\AjaxController
{
    function index(){
    	$request     = request();
        $data        = ['e' => '0','d'=>[]];
        $account_id  = $request->account_id;
        $date        = str_replace(array(' ','/'), array('','-'), $request->date);
        $num         = date("t",strtotime($date));
        $date_start  = strtotime($date .'-1')-1;
        $date_end    = strtotime($date .'-' . $num)+1;

        if(empty($account_id) || empty($date)) {
            $data['e'] = 1;
            $data['e_msg'] = 'code or month miss!';
            return json_encode($data);
        }   

        $user = $request->user();
        $array = array();

        $array = $user->adRecords()
            ->where('ad_binds_id',$account_id)
            ->where('date','>', $date_start)
            ->where('date','<', $date_end)
            ->get();    


        $col_names = TableColumnName::getUserStyle('ad_table',$user);
        $new_array = array();

        foreach($array as $key=>$table){
            $new_array[$key]['date'] = $table->date;
            $new_array[$key]['id']   = $table->id;
            foreach($col_names as $col_name){
                $new_array[$key][$col_name['key']] = FormulaCalculator::make($col_name['value'],$table);
            }
        }
        
        $bind = $user->adBinds()->find($account_id);
        $data['i']['account'] = $bind->account->code .' - ('.$bind->account->idkey .'@'. $bind->account->username .':'. $bind->account->password .')' ;
        $data['i']['vps'] = $bind->vps->ip .'@'. $bind->vps->username .':'. $bind->vps->password  ;
        $data['i']['site'] = $bind->site->host .' - '. $bind->site->banner->name;
        $data['i']['money'] = $bind->money;

        $data['d'] = $new_array;
        return response()->json($data); 
    }

    private function getTotal($key,$data){
        switch ($key) {
            case 'sum':
                return array_sum($data);
                break;
            case 'avg':
                return ( array_sum($data) / count($data) );
                break;
            case 'max':
                return max($data);
                break;
            case 'min':
                return min($data);
                break;    
            default:
                return '';
                break;
        }
    }

    public function store(){
        $request = request();
        $user = $request->user();
    	$data = ['e' => '0','d'=>[]];

        // data change key To array
        $new_fill_data = array();
        $col_names     = TableColumnName::getUserStyleByKeyValue('ad_table',$user);
        $fill_data     = $request->all();
        
        foreach($fill_data as $key=>$value){
            if(isset($col_names[$key]))
                $new_fill_data[$col_names[$key]] = $value;
        }
        $record = '';
        //add or update
        $bind = $user->adBinds()->find($fill_data['ad_account_id']);
    	if($fill_data['id'] == 0){

			if($bind == null){
				$data['e'] = 1; $data['e_msg'] = 'no account!';
				return response()->json($data);
			}else{
				
				$date = str_replace(array(' ','/'), array('','-'), $fill_data['date']);
                $date = empty($date)? date('Y-m-d'): $date;

                $record = $bind->records()
                    ->where('date',strtotime($date))
                    ->first();

                if($record == null){
                    $record = new \App\Model\ADRecords($new_fill_data);
                    $record->date = strtotime($date);
                    $record->ad_binds_id = $fill_data['ad_account_id'];
                    $record->save();
                }else{
                    $record->fill($new_fill_data)->save();
                }
			}


    	}else{
    		$record = $bind->records()->find($fill_data['id']);

			if($record == null){
				$data['e'] = 1; $data['e_msg'] = 'no table!';
				return response()->json($data);
			}

			$record->fill($new_fill_data)->save();
    	}
   
        //success ,array to key
        $col_names = TableColumnName::getUserStyle('ad_table',$user);
        $new_array = array();
        foreach($col_names as $col_name){
            $new_array['date'] = $record->date;
            $new_array['id']   = $record->id;
            $new_array[$col_name['key']] = FormulaCalculator::make($col_name['value'],$record);
        }
        $data['d'] = $new_array;
        $data['i']['money'] = $user->adBinds()->find($fill_data['ad_account_id'])->money;
    	return response()->json($data);
    }

}


<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\AjaxController;
use App\Http\Requests;
use App\Libs\TableColumnName;
use App\Libs\FormulaCalculator;

class ADTable extends AjaxController
{
    function index(Request $request){

        $data        = $this->default_data;
        $id          = $request->id;
        $date        = str_replace(array(' ','/'), array('','-'), $request->date);
        $num         = date("t",strtotime($date));
        $date_start  = strtotime($date .'-1')-1;
        $date_end    = strtotime($date .'-' . $num)+1;

        if(empty($id) || empty($date)) {
            $data['e'] = 1;
            $data['e_msg'] = 'code or month miss!';
            return json_encode($data);
        }   

        $user = $request->user();
        $array = array();
        if($user->is('responsible')){
          $array = $user->child->find($id)->adTable()
                            ->selectRaw('date,sum(advertising_cost) as advertising_cost, 
                                        sum(click_amount) as click_amount, 
                                        sum(transformation_cost) as transformation_cost, 
                                        sum(trade_money) as trade_money, 
                                        sum(transaction_orders) as transaction_orders, 
                                        sum(change_proportion) as change_proportion,
                                        sum(recharge) as recharge'
                            )
                            ->where('date','>', $date_start)
                            ->where('date','<',$date_end)
                            ->groupBy('date')
                            ->get();
        }else{
            $array = $user->adTable()
                ->where('ad_account_id',$id)
                ->where('date','>', $date_start)
                ->where('date','<', $date_end)
                ->get();    
        }

        $col_names = TableColumnName::getUserStyle('ad_table',$user);
        $new_array = array();
        
        foreach($array as $key=>$table){
            $new_array[$key]['date'] = $table->date;
            $new_array[$key]['id']   = $table->id;
            foreach($col_names as $col_name){
                $new_array[$key][$col_name['key']] = FormulaCalculator::make($col_name['value'],$table);
            }
        }
        
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

    function store(Request $request){
        $user = $request->user();
        if($user->is('responsible')) return response('Unauthorized.', 401);

    	$data = $this->default_data;

        // data change key To array
        $new_fill_data = array();
        $col_names     = TableColumnName::getUserStyleByKeyValue('ad_table',$user);
        $fill_data     = $request->all();
        
        foreach($fill_data as $key=>$value){
            if(isset($col_names[$key]))
                $new_fill_data[$col_names[$key]] = $value;
        }

        $adatable = '';
        $cost  = isset($new_fill_data['advertising_cost']) ? (float)$new_fill_data['advertising_cost'] : false;
        $recharge = isset($new_fill_data['recharge']) ? (float)$new_fill_data['recharge'] : false;

        //add or update
        $account = $user->adAccount()->find($fill_data['ad_account_id']);
    	if($fill_data['id'] == 0){

			if($account == null){
				$data['e'] = 1; $data['e_msg'] = 'no account!';
				return response()->json($data);
			}else{
				
				$date = str_replace(array(' ','/'), array('','-'), $fill_data['date']);
                $date = empty($date)? date('Y-m-d'): $date;

                $adatable = $account->adTable()
                    ->where('date',strtotime($date))
                    ->first();

                if($adatable == null){
                    $adatable = new \App\Model\ADTable($new_fill_data);
                    $adatable->date = strtotime($date);
                    $adatable->ad_account_id = $fill_data['ad_account_id'];
                    $adatable->save();

                    $cost = ($cost === false)? 0 : $cost;
                    $recharge = ($recharge === false)? 0 : $recharge;

                }else{
                    $cost = ($cost === false)? 0 : $cost - (float)$adatable->advertising_cost ;
                    $recharge = ($recharge == false)? 0 : $recharge - (float)$adatable->recharge ;
                    $adatable->fill($new_fill_data)->save();
                }
			}

            if($cost != 0 || $recharge != 0){
                $money = $account->money + $recharge - $cost;
                $account->fill(['money'=>$money])->save();
            }

    	}else{
    		$adatable = $account->adTable()->find($fill_data['id']);

			if($adatable == null){
				$data['e'] = 1; $data['e_msg'] = 'no table!';
				return response()->json($data);
			}

            $cost = ($cost === false) ? 0 : $cost - (float)$adatable->advertising_cost ;
            $recharge = ($recharge === false)? 0 : $recharge - (float)$adatable->recharge ;

            if($cost != 0 || $recharge != 0){
                $money = $account->money + $recharge - $cost;
                $account->fill(['money'=>$money])->save();
            }
			$adatable->fill($new_fill_data)->save();
    	}
   
        //success ,array to key
        $col_names = TableColumnName::getUserStyle('ad_table',$user);
        $new_array = array();
        foreach($col_names as $col_name){
            $new_array['date'] = $adatable->date;
            $new_array['id']   = $adatable->id;
            $new_array[$col_name['key']] = FormulaCalculator::make($col_name['value'],$adatable);
        }
        $data['d'] = $new_array;
    	return response()->json($data);
    }


}

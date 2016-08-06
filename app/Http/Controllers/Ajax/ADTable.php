<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\TableColumnName;

class ADTable extends Controller
{
	protected $default_data = array(
		'e'      => 0,
    	'e_msg'  => '',
    	'd'      => array(),
    );

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
        if($user->is('responsible')){
           $data['d'] = $user->child->find($id)->adTable()
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

            return response()->json($data); 
        }else{
            
            $data['d'] = $user->adTable()
                ->where('ad_account_id',$id)
                ->where('date','>', $date_start)
                ->where('date','<', $date_end)
                ->get();    
     
            return response()->json($data); 
        }


    }

    function update(Request $request){
        if($request->user()->is('responsible')) return response('Unauthorized.', 401);

    	$data = $this->default_data;

    	if($request->id == 0){
			$account = $request->user()->adAccount()->find($request->ad_account_id);

			if($account == null){
				$data['e'] = 1; $data['e_msg'] = 'no account!';
				return response()->json($data);
			}else{
				
				$date = str_replace(array(' ','/'), array('','-'), $request->date);

				$adatable = $account->adTable()
                    ->where('date',strtotime($date))
                    ->first();

				if($adatable == null){
					$table = new \App\Advertising\ADTable($request->all());
					$table->date = strtotime($date);
					$table->ad_account_id = $request->ad_account_id;
					$table->save();
				}else{
					if(!$adatable->fill($request->all())->save()){
						$data['e'] = 1; $data['e_msg'] = 'save faild!';
					}
				}
			}

    	}else{
    		$adatable = $request->user()->adTable()->find($request->id);

			if($adatable == null){
				$data['e'] = 1; $data['e_msg'] = 'no table!';
				return response()->json($data);
			}
			if(!$adatable->fill($request->all())->save()){
				$data['e'] = 1; $data['e_msg'] = 'save faild!';
			}
    	}
    	
    	return response()->json($data);
    }


    
}

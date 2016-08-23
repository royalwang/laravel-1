<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Validator;


class ADAccount extends AjaxController
{

    function index(Request $request){
        $accounts = \App\Advertising\ADAccount::orderBy('created_at','desc')->paginate(30);


        $json = $accounts->toArray();
        $data = array();
        foreach($accounts as $k=>$account){
            $data[$k] = $account->toArray(); 
            $data[$k]['users'] = $account->user->name;
            $data[$k]['status'] = $account->status->name;
        }
        $json['data'] = $data;

        return response()->json($json); 
    }

    function update(Request $request){
        
        if(!isset($request->data) || count($request->data) < 1) return;

        $accounts = $request->user()->adAccount()->get();
        foreach($request->data as $value){
            if(!isset($value['id'])) continue;
            $account = $accounts->find($value['id']);
            if($account == null) continue;
            $account->fill($value);
            $account->save();
        }
        
    }

    function add(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'code' => 'required|max:255|unique:ad_account',
        ]);

        if ($validator->fails()) {
           $data = $this->default_data;
           $data['e'] = 1;
           $data['e_msg'] = 'data error';
           return response()->json($validator->errors()->all());   
        } 
        $account = \App\Advertising\ADAccount::create($data);

        $data = $this->default_data;
        $data['d'][] = $account;
        return response()->json($data); 
        
    }

    
}

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
        return \App\Advertising\ADAccount::orderBy('created_at','desc')->paginate(30);
    }

    function update(Request $request){

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

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
        $data = $this->default_data;

        return response()->json($data); 
    }

    function update(Request $request){

    }

    function add(Request $request){
        $data = $request->all();

        return response()->json($data); 
        
    }

    
}

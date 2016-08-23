<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User;
use Validator;

class Users extends AjaxController
{

    function index(Request $request){
        $data = $this->default_data;
        $user = $request->user();
        $data['d'] = $user->child()->orderBy('updated_at', 'desc')->get();
        return response()->json($data); 
    }

    function update(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'id' => 'required',
            'name' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($this->default_data); 
        } 
        
        $user = $request->user()->child()->find($data['id']);
        if($user != null){
            $user->fill($data);
            $user->save();
        }

        $data = $this->default_data;
        $data['d'][] = $user;

        return response()->json($data); 
    }

    function add(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($this->default_data); 
        } 
        
        $user = new User([
            'name' => $data['name'],
            'password' => bcrypt($data['password']),
        ]);

        $user->parent_id = $request->user()->id;
        $user->users_group_id = 2;
        $user->save();

        $data = $this->default_data;
        $data['d'][] = $user;

        return response()->json($data); 
        
    }

    
}

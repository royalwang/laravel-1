<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class HomeController extends Controller
{
    function index(){
        return redirect()->action(Auth::user()->default_page());
    }
    function create(){

    }
    function store(){

    }
    function show(){

    }
    function edit(){

    }
    function update(){

    }
    function destroy(){

    }

}

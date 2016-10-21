<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;


class Error extends BaseController
{

    public function index($code){
        return $code;
    }


}


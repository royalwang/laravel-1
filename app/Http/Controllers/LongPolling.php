<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class LongPolling extends Controller
{
    function index(){
        if(isset(request()->code))
            return response()->json($this->{request()->code}());
        else
            return response()->json([]);
    }

    private function supplier_link_type(){
        $links = \App\Model\SupplierLink::all();
        $json = [];
        foreach($links as $link){
            $json[$link->id] = $link->type;
        }
        return $json;
    }

    public function __call($name, $arguments){
        return [];
    }

}

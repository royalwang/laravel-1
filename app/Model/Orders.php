<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{


    public $timestamps = false;

    public function type(){
    	return $this->beLongsTo(OrdersType::class,'orders_type_id','id');
    }

}

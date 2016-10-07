<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Express extends Model
{

	protected $table = 'express';
    public $timestamps = false;

    public function products(){
    	return $this->hasMany(OrdersProducts::class,'express_id','id');
    }

    public function type(){
    	return $this->beLongsTo(ExpressType::class,'express_type_id');
    }

}

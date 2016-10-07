<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{


    public $timestamps = false;

    public function type(){
    	return $this->belongsToMany(OrdersType::class,'orders_to_type');
    }

    public function site(){
    	return $this->beLongsTo(Sites::class,'sites_id','id');
    }

    public function products(){
    	return $this->hasMany(OrdersProducts::class,'orders_id');
    }

}

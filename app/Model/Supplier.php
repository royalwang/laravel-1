<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{

	protected $table = 'supplier';
	protected $fillable = [
		'name','address','qq','telephone'
	];
    public $timestamps = false;

    public function products(){
    	return $this->hasMany(OrdersProducts::class,'express_id','id');
    }

    public function type(){
    	return $this->beLongsTo(ExpressType::class,'express_type_id');
    }

}

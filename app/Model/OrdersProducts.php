<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrdersProducts extends Model
{

	protected $table = 'orders_products';
	protected $fillable = array(
		'products_image','products_name','products_quantity'
	);


    public $timestamps = false;


    public function type(){
    	return $this->beLongsTo(OrdersProductsType::class,'orders_products_type_id','id');
    }

    public function express(){
    	return $this->beLongsTo(Express::class,'express_id','id');
    }


}

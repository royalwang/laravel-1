<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrdersProductsType extends Model
{

	protected $table = 'orders_products_type';
	protected $fillable = array(
		'name','code'
	);


    public $timestamps = false;


}

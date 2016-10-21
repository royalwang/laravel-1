<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SupplierProducts extends Model
{

	protected $table = 'supplier_to_products';
	protected $fillable = [
		'orders_products_id','supplier_link_id'
	];
	public $timestamps = false;

    public function supplier(){
        return $this->beLongsTo(Supplier::class);
    }

}

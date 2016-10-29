<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SupplierLink extends Model
{

	protected $table = 'supplier_link';
	protected $fillable = [
		'type','supplier_id','code'
	];

    public function supplier(){
        return $this->beLongsTo(Supplier::class);
    }

    public function products(){
        return $this->hasMany( supplierProducts::class,'supplier_link_id');
    }



}

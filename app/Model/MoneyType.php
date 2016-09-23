<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class MoneyType extends Model
{
	protected $table = 'money_type';
    protected $fillable = array(
        'name','parent_id'
    );

    public $timestamps = false;
    
    public function records(){
    	return $this->hasMany(MoneyRecords::class,'money_type_id');
    }

}


<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ExpressBusiness extends Model
{

	protected $table = 'express_business';
	protected $fillable = [
        'name'
    ];
    public $timestamps = false;


}

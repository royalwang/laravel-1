<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ExpressType extends Model
{

	protected $table = 'express_type';
	protected $fillable = [
        'name'
    ];
    public $timestamps = false;


}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $table = "style";
	protected $fillable = array(
		'name',
		'style',
		'type',
	);
	public $timestamps = false;


}

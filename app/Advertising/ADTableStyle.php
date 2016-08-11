<?php

namespace App\Advertising;

use Illuminate\Database\Eloquent\Model;

class ADTableStyle extends Model
{
    protected $table = "ad_table_style";
	protected $fillable = array(
		'name',
		'style',
	);
	public $timestamps = false;

}

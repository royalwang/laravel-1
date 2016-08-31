<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{

    protected $fillable = [
        'name','code'
    ];

    public $timestamps = false;



}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;



}

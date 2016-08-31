<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PayChannel extends Model
{
    protected $table = "pay_channel";

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;



}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'host','banners_id','pay_channel_id',
    ];
    
    public function banner(){
        return $this->belongsTo(Banners::class,'banners_id');
    }

    public function user(){
    	return $this->belongsTo(Users::class,'users_id');
    }

    public function pay_channel(){
    	return $this->belongsTo(PayChannel::class,'pay_channel_id');
    }

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class ADBinds extends Model
{
	protected $table = 'ad_binds';
    protected $fillable = array(
        'accounts_id',
        'vps_id',
        'sites_id',
        'status' ,
    );

	public function user(){
		return $this->belongsTo(Users::class,'users_id');
	}

    public function account(){
        return $this->belongsTo(ADAccounts::class,'accounts_id');
    }

    public function records(){
        return $this->hasMany(ADRecords::class,'ad_binds_id');
    }  

    public function vps(){
        return $this->belongsTo(ADVps::class,'vps_id');
    }    
  
    public function site(){
        return $this->belongsTo(Sites::class,'sites_id');
    }       


}


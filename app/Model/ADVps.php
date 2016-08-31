<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class ADVps extends Model
{
	protected $table = 'ad_vps';
  protected $fillable = array(
      'ip',
      'username',
      'password',
  );

  public $timestamps = false;

	public function user(){
		return $this->belongsTo(Users::class,'users_id');
	}




}


/*


       user->vps  other->site  other->account 

       user_id account_id vps_id site_id















*/





<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\TableColumnName;

class ADTable extends Model
{
	protected $table = 'ad_table';
	protected $fillable = array(
	);

	public $timestamps = false;

    public function adAccount()
    {
        return $this->hasOne(ADAccounts::class,'ad_account_id');
    }

}

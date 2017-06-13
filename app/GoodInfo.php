<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodInfo extends Model
{
	protected $table='good_info';
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}

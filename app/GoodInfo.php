<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodInfo extends Model
{
	use SoftDeletes;

	protected $table='good_info';

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	protected $dates = ['delete_at'];

	public function getwithTrashedID()
	{
		return $this->withTrashed()->id;
	}
}

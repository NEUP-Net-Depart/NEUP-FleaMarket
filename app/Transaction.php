<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table='transactions';

    public function good()
    {
        return $this->belongsTo('App\GoodInfo');
    }

    public function buyer()
    {
        return $this->belongsTo('App\User', 'buyer_id');
    }

    public function getSellerIdAttribute()
    {
        return $this->good->user_id;
    }

    public function seller()
    {
        return $this->belongsTo('App\User', 'seller_id');
    }

	public function feedback()
	{
		return $this->hasOne('App\Ticket', 'trans_id');
	}

}

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
}

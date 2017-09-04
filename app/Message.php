<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    protected $table = 'message';
    protected $dates = ['deleted_at'];

    public function receiver()
    {
        return $this->belongsTo('App\User', 'receiver_id');
    }

    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

}

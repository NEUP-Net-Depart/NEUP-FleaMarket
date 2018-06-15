<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageContact extends Model
{
    protected $fillable = ['user_id', 'contact_id', 'unread_count'];

    public function contact()
    {
        return $this->belongsTo('App\User', 'contact_id');
    }
}

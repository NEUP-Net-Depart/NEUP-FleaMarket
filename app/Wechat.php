<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{
    public $incrementing = false;
    protected $fillable = ['open_id'];
    protected $primaryKey = 'open_id';
}

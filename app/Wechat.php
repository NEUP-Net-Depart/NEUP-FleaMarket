<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wechat extends Model
{
    protected $fillable = ['open_id'];
    protected $primaryKey = 'open_id';
    public $incrementing = false;
}

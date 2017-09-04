<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodCat extends Model
{
    protected $table = 'good_cat';

    public function tags()
    {
        return $this->hasMany('App\Tag', 'good_cat_id', 'id');
    }
}

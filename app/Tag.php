<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['tag_name', 'good_cat_id'];

    public function goods()
    {
        return $this->belongsToMany('App\GoodInfo', 'good_tags', 'tag_id', 'good_id');
    }
}

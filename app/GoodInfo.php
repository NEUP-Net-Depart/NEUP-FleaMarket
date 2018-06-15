<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodInfo extends Model
{

    use SoftDeletes;

    protected $table = 'good_info';
    protected $dates = ['delete_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function cat()
    {
        return $this->belongsTo('App\GoodCat');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'good_tags', 'good_id', 'tag_id');
    }

    public function getwithTrashedID()
    {
        return $this->withTrashed()->id;
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodInfo extends Model
{
	protected $table = 'good_info';
	public function user()
	{
		return $this->belongsTo('App\User');
	}

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'good_tags', 'good_id', 'tag_id');
    }
}

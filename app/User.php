<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class User extends Model
{
    protected $table = 'users';

    public function user_infos()
    {
        return $this->hasMany('App\UserInfo');
    }

    public function registerCompletion()
    {
        if ($this->nickname == null || !Storage::exists('avatar/' . $this->id)) {
            return 2;
        } else if (count($this->user_infos) == 0) {
            return 3;
        } else
            return 0;
    }

    public function trans()
    {
        return $this->hasManyThrough('App\Transaction', 'App\GoodInfo', 'user_id', 'good_id', 'id');
    }

    public function getNotNullNicknameAttribute()
    {
        return $this->nickname != "" ? $this->nickname : "一位先锋市场用户";
    }

    public function wechat()
    {
        return $this->belongsTo('App\Wechat', "wechat_open_id", "open_id");
    }

}

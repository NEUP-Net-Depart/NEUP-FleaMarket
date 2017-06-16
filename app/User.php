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

	public function getcoding()
	{
		$len=strlen($this->stuid);
		$ans = "";
		$ans = $ans . ($this->stuid)[0];
		for($i=1; $i<($len-1); $i++) $ans = $ans . '*';
		$ans = $ans . ($this->stuid)[$len-1];
		return $ans;
	}

}

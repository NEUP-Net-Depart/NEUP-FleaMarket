<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = ['last_get_new_message_time', 'last_send_email_time'];

    public function user_infos()
    {
        return $this->hasMany('App\UserInfo');
    }

    public function registerCompletion($force = false)
    {
        if (!$force && ($this->nickname == null || !Storage::exists('avatar/' . $this->id))) {
            return 2;
        } else if ($this->email == null && $this->wechat_open_id == null) {
            return 3;
        } else if (!$force && count($this->user_infos) == 0) {
            return 4;
        }
        else
            return 0;
    }

/*    public function trans()
    {
        return $this->hasManyThrough('App\Transaction', 'App\GoodInfo', 'user_id', 'good_id', 'id');
    }
 */

    public function getNotNullNicknameAttribute()
    {
        return $this->nickname != "" ? $this->nickname : "一位先锋市场用户";
    }

    public function wechat()
    {
        return $this->belongsTo('App\Wechat', "wechat_open_id", "open_id");
    }

	public function getcoding()
	{
		$len=strlen($this->stuid);
		$ans = "";
		$ans = $ans . substr($this->stuid, 0, 1);
		for($i=1; $i<($len-1); $i++) $ans = $ans . '*';
		$ans = $ans . substr($this->stuid, -1);
		return $ans;
	}

}

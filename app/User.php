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
        if($force) {
            if ($this->email == null && $this->wechat_open_id == null && $this->tel == null) {
                return 3;
            } else
                return 0;
        } else {
            if ($this->nickname == null || !Storage::exists('avatar/' . $this->id)) {
                return 2;
            } else if ($this->wechat_open_id == null && $this->tel == null) {
                return 3;
            } // 4 will be never returned unless he skip 3
            else
                return 0;
        }

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

    public function getUserRankAttribute()
    {
        if (!$this->stuid)
            return "None";
        else if (strlen($this->stuid) == 8) {
            if (2000 + env('FRESH_YEAR') - intval(substr($this->stuid, 0, 4)) == 0 )
                return "Freshman";
            else if (2000 + env('FRESH_YEAR') - intval(substr($this->stuid, 0, 4)) == 1 )
                return "Sophomore";
            else if (2000 + env('FRESH_YEAR') - intval(substr($this->stuid, 0, 4)) == 2 )
                return "Junior";
            else if (2000 + env('FRESH_YEAR') - intval(substr($this->stuid, 0, 4)) == 3 )
                return "Senior";
            else
                return "Undergraduate";
        } else if(strlen($this->stuid) == 7) {
            if ($this->stuid[2] == '1' && env('FRESH_YEAR') - intval(substr($this->stuid, 0, 2)) < 5 )
                return "Doctor";
            else if(($this->stuid[2] == '0' || $this->stuid[2] == '7') && env('FRESH_YEAR') - intval(substr($this->stuid, 0, 2)) < 2 )
                return "Master";
            else
                return "Graduate";
        } else if(strlen($this->stuid) == 5) {
            return "Staff";
        } else {
            return "Unknown";
        }
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

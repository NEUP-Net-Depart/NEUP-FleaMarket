<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class User extends Model
{
    protected $table = 'users';

    public function registerCompletion()
    {
        if ($this->nickname == null || !Storage::exists('avatar/' . $this->id)) {
            return 2;
        } else if (false) {
            return 3;
        } else
            return 0;
    }
}

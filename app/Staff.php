<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public function boss()
    {
        return $this->hasOne('App\Staff', 'id', 'up_num');
    }

    public function subject()
    {
        return $this->hasMany('App\Staff', 'up_num', 'id');
    }
}

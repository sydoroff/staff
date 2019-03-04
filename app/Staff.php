<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function PHPSTORM_META\map;

class Staff extends Model
{
    protected $dates = ['employment'];
    /**
     * @return App/Staff Возвращает начальника
     */
    public function boss()
    {
        return $this->belongsTo('App\Staff', 'up_num', 'id');
    }

    /**
     * @return App/Staff Возвращает подчиненных
     */
    public function subject()
    {
        return $this->hasMany('App\Staff', 'up_num', 'id');
    }

    /**
     * @param $id - начальник
     * @return App/Staff с числом подчененных.
     */
    static function childTreeJS($id){

        return self::withCount('subject')->where('up_num',$id)->get();

    }
}

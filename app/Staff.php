<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{

    protected $hidden = ['created_at','updated_at'];

    public function scopeMake_Search($query,$param)
    {
        foreach ($param as $row => $item)
        {
            if(in_array($row,['full_name','position','boss_name'])&&strlen(trim($item))>1){
                $query = $query->where('staff.'.$row, 'like',
                    '%' . str_replace(' ', '%%', $item ) . '%');
            }
            if (in_array($row,['id_from','employment_from','pay_from'])&&!empty(trim($item))){
                $query = $query->where('staff.'.str_replace('_from','',$row), '>', $item);
            }
            if (in_array($row,['id_to','employment_to','pay_to'])&&!empty(trim($item))>1){
                $query = $query->where('staff.'.str_replace('_to','',$row), '<',$item);
            }
        }
        return $query;
    }

    public function scopeMake_Sort($query,$param)
    {
        if (isset($param['sort'])&&isset($param['set']))
            $query = $query->orderBy('staff.'.$param['sort'],$param['set']);

        return $query;
    }

    public function getValidAttribute($value)
    {
        return [
            'id_from' => 'nullable|digits_between:1,8',
            'id_to' => 'nullable|digits_between:1,8',
            'full_name' => 'nullable|string|max:150',
            'position' => 'nullable|string|max:150',
            'employment_from' => 'nullable|date',
            'employment_to' => 'nullable|date',
            'pay_from' => 'nullable|digits_between:1,8',
            'pay_to' => 'nullable|digits_between:1,8',
            'boss_name' => 'nullable|string|max:150',
            'sort'=>'in:id,full_name,position,employment,pay,boss_name',
            'set'=>'in:asc,desc',
        ];
    }


    /**
     * @return App/Staff Возвращает начальника
     */
    public function boss()
    {
        return $this->belongsTo(self::class, 'up_num', 'id');
    }

    /**
     * @return App/Staff Возвращает подчиненных
     */
    public function subject()
    {
        return $this->hasMany(self::class, 'up_num', 'id');
    }

    /**
     * @param $id - начальник
     * @return App/Staff с числом подчененных.
     */
    static function childTreeJS($id){

        return self::withCount('subject')->where('up_num',$id)->get();

    }

}

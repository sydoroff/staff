<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Staff extends Model
{
    protected $hidden = ['created_at','updated_at'];
    protected $fillable = ['full_name', 'position', 'employment', 'pay', 'up_num'];
    protected $appends = ['photo'];

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
            if (in_array($row,['id_to','employment_to','pay_to'])&&!empty(trim($item))){
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

    public function validSave(){
        return [
            'full_name' => 'required|max:155',
            'position' => 'required|max:155',
            'employment' => 'required|date|max:155',
            'pay' => 'required|numeric',
            'up_num' => 'required|numeric'
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

    public function getPhotoAttribute()
    {
        return file_exists(public_path().'\image\s\\'.$this->id.'.jpg');
    }

    public function getBranchAttribute()
    {

        if ($this->up_num==0) return collect([]);

        $staff = $this->boss()->get();

        while($staff[$staff->count()-1]->up_num>0){
            $col = $staff[$staff->count()-1]->boss()->get();
            $staff->push($col[0]);
        }

        $staff = $staff->reverse();

        return $staff;
    }

    public function inBranch($id){

        if ($this->id==$id) return false;

        $branch = self::find($id)->branch->map(function ($item, $key) {
            return $item->id;
        });

        return is_int($branch->search($id));

    }


}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;

class StaffController extends Controller
{

    public function index(Request $request){

        $request->validate([
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
        ]);

        $sort = $request->get('sort');
        $set = $request->get('set');

        $staff = new Staff();

        //============ Делаем разные поиски =============//

        if ($request->has('search')) {

            if (!empty(trim($request->get('id_from'))))
                $staff = $staff->where('staff.id', '>', $request->get('id_from'));
            if (!empty(trim($request->get('id_to'))))
                $staff = $staff->where('staff.id', '<', $request->get('id_to'));
            if (strlen(trim($request->get('full_name')))>1)
                $staff = $staff->where('staff.full_name', 'like', '%' . str_replace(' ', '%%', trim($request->get('full_name'))) . '%');
            if (strlen(trim($request->get('position')))>1)
                $staff = $staff->where('staff.position', 'like', '%' . str_replace(' ', '%%', trim($request->get('position'))) . '%');
            if (!empty(trim($request->get('employment_from'))))
                $staff = $staff->whereDate('staff.employment', '>', $request->get('employment_from'));
            if (!empty(trim($request->get('employment_to'))))
                $staff = $staff->whereDate('staff.employment', '<', $request->get('employment_to'));
            if (!empty(trim($request->get('pay_from'))))
                $staff = $staff->where('staff.pay', '>', $request->get('pay_from'));
            if (!empty(trim($request->get('pay_to'))))
                $staff = $staff->where('staff.pay', '<', $request->get('pay_to'));
            if (strlen(trim($request->get('boss_name')))>1)
                $staff = $staff->where('staff.boss_name', 'like', '%' . str_replace(' ', '%%', trim($request->get('boss_name'))) . '%');

        }

        //================ Делаем сортировки ===============//

            if(!empty($sort)&&!empty($set)&&$sort!='boss')
                $staff=$staff->orderBy('staff.'.$sort,$set);

        //==================================================//

        $staff=$staff->paginate(50);

        $staff=$staff->appends($request->except(['page']));

        return view('table',[
            'staff'=> $staff,
            'sort'=>$this->iconAndUrl($sort,$set,$request->except(['sort','set','page'])),
            'form_input'=>$request->except(['sort','set','page']),
            'form_url'=>$request->only(['sort','set'])
        ]);
    }

    /**
     * @param $sort - поле сортировки
     * @param $set - asc desc
     * @param $sl - search links - ссылки поиска
     * @return array - массив на отправку в блейд иконки и всякие урлы
     */
    public function iconAndUrl($sort,$set,$sl)
    {

        $icon=NULL;
        if($set == 'asc' ) $icon='&#9660;';
        if($set == 'desc') $icon='&#9650;';

        $sort_set=[
            'id' =>         ['ico'=>Null,'a_d'=>'asc','url'=>''],
            'full_name' =>  ['ico'=>Null,'a_d'=>'asc','url'=>''],
            'position' =>   ['ico'=>Null,'a_d'=>'asc','url'=>''],
            'employment' => ['ico'=>Null,'a_d'=>'asc','url'=>''],
            'pay' =>        ['ico'=>Null,'a_d'=>'asc','url'=>''],
            'boss_name' =>       ['ico'=>Null,'a_d'=>'asc','url'=>'']
        ];

        if ($set=='asc')
            $sort_set[$sort]['a_d'] = 'desc';

        foreach ($sort_set as $item => &$row){
            $arr=array_merge(['sort'=> $item,'set'=>$row['a_d']],$sl);
            $row['url']=route('staff',$arr);
        }

        $sort_set[$sort]['ico']=$icon;

        return $sort_set;
    }
}


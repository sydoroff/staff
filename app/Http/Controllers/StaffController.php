<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;

class StaffController extends Controller
{

    public function index(Request $request){

        $staff = new Staff();
        $request->validate($staff->valid);
        $staff = $staff->make_search($request->only(['full_name','position','boss_name',
                                                     'id_from','employment_from','pay_from',
                                                     'id_to','employment_to','pay_to']));
        $staff = $staff->make_sort($request->only(['sort','set']));
        $staff = $staff->paginate(50);
        $staff = $staff->appends($request->except(['page']));

        return view('table',[
            'staff'=> $staff,
            'sort'=>$this->iconAndUrl($sort = $request->get('sort'),
                                      $set = $request->get('set'),
                                      $request->except(['sort','set','page'])),
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


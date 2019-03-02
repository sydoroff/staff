<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use function PHPSTORM_META\map;

class StaffController extends Controller
{
    public function index(Request $request){

        //===Разбираемся с кнопками и ссылками===//
        $sort = $request->get('sort');
        $set = $request->get('set');

        $icon=NULL;
        if($request->get('set')=='asc') $icon='&#9660;';
        if($request->get('set')=='desc') $icon='&#9650;';

        $sort_set=[
            'id'=>Null,
            'full_name'=>Null,
            'position'=>Null,
            'employment'=>Null,
            'pay'=>Null,
            'boss'=>Null
        ];

        $sort_id=[
            'id'=>'asc',
            'full_name'=>'asc',
            'position'=>'asc',
            'employment'=>'asc',
            'pay'=>'asc',
            'boss'=>'asc'
        ];

        if ($set=='asc')
            $sort_id[$sort] = 'desc';

        foreach ($sort_id as $item => &$row)
            $row=route('staff',['sort'=> $item,'set'=>$row]);

        $sort_set[$sort]=$icon;

        //===========================================//

        //============ Достаём модели ===============//

        if ($sort==='boss'){

            $pages=Staff::select('id')->orderBy('full_name',$set)->paginate(50);

            $staff_a=$pages->map(function ($q){return $q->id;})->toArray();

            $staff=Staff::with('boss')->whereIn('up_num',$staff_a)->get();

        }else{
            $staff=Staff::with('boss');

            if(!empty($sort)&&!empty($set))
                $staff=$staff->orderBy($sort,$set);

            $staff=$staff->paginate(50);

            $pages=$staff;
        }

        if(!empty($sort)&&!empty($set))
            $pages=$pages->appends(['sort' => $sort,'set'=>$set]);

        //===========================================//

        return view('table',[
            'staff'=> $staff,
            'sort'=>$sort_id,
            'set'=>$sort_set,
            'pages'=>$pages
        ]);
    }
}


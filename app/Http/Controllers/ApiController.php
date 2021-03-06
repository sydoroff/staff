<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{
    public function home(Request $request){

        $request->validate([
            'id' => 'required|integer',
        ]);

        $staff=Staff::with('subject','subject.subject')
            ->where('up_num',$request->get('id'))
            ->get()
            ->map(function ($item, $key){
                $arr = $item->subject->map(function ($item, $key){
                           return  [
                               'id'=>$item->id,
                               'text'=> view('tree-item',['item' => $item])->render(),
                               'children' => ($item->subject->count()>0)
                           ];
                        })->toArray();
                   return  [
                       'id'=>$item->id,
                       'text'=> view('tree-item',['item' => $item])->render(),
                       'children' => $arr
                   ];
        });

        return Response::json($staff->toArray());
    }

    public function worker($id){
        $staff = Staff::with('subject')->findOrFail($id);

        return Response::json($staff->toArray());
    }

    public function nameTree(Request $request){

        $request->validate([
            'id' => 'required|integer',
        ]);

        $staff=Staff::withCount('subject')
            ->where('up_num',$request->get('id'))
            ->get()
            ->map(function ($item, $key){
            return [
                'id'=>$item->id,
                'text'=> $item->full_name,
                'children' => ($item->subject_count>0)
            ];
        });

        return Response::json($staff->toArray());
    }


    public function table(Request $request){

        $staff = new Staff();
        $request->validate($staff->valid);
        $staff = $staff->make_search($request->only(['full_name','position','boss_name',
                                                     'id_from','employment_from','pay_from',
                                                     'id_to','employment_to','pay_to']));

        $staff = $staff->make_sort($request->only(['sort','set']));
        $staff = $staff->paginate(50);
        $staff = $staff->appends($request->except(['page']));
        $staff = $staff->toArray();
        $staff['search_sort_param'] = $request->except(['page']);

        return  Response::json($staff);
    }

    public function move(Request $request){
        $request->validate([
            'id' => 'required|integer',
            'up_num' => 'required|integer',
        ]);

        $staff = Staff::findOrFail($request->get('id'));

        if($staff->inBranch($request->get('up_num'))) abort(404);

        $staff->up_num = $request->get('up_num');
        $staff = $staff->save();

        if ($staff)
            return  Response::json($staff,200);
        else
            abort(404);
    }
}

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

        $id = $request->get('id');

        $staff=Staff::childTreeJS($id)->map(function ($item, $key){
            $child = ($item->subject_count>0) ? [true,'<sup> sub.'.$item->subject_count.'</sup>']: [false,''];
            return [
                'id'=>$item->id,
                'text'=>'<b>'.$item->full_name.'</b>. <span class="text-success">Post: </span><i><u>'.
                        $item->position.'</u></i>'.$child[1].'. <span class="text-success">Working start:</span> '.
                        $item->employment.'. <span class="text-success">Pay:</span> '.$item->pay.'$',
                'children' => $child[0]
            ];
        });

        return Response::json($staff->toArray());
    }
}

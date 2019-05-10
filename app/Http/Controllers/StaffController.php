<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Staff;
use Intervention\Image\Facades\Image as ImageInt;
class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','iconAndUrl']);
    }

    public function create(){
        return view('staff');
    }

    public function store(Request $request){
        $staff = new Staff();
        $request->validate($staff->validSave());
        $staff->fill($request->only($staff->getFillable()));
        $staff->save();
        return redirect()->route('staff.edit',['id' => $staff->id])->with('status', 'Save success! '.$request->get("full_name").' added.');
    }

    public function edit($id){
        $staff = Staff::findOrFail($id);
        return view('staff',['staff' => $staff]);
    }

    public function update(Request $request,$id){

        $request->validate($staff->validSave());

        $staff = Staff::findOrFail($id);
        if ($staff->inBranch($request->get('up_num')))
            return back()->withErrors('This moving forbidden')->withInput();

        $staff->fill($request->only($staff->getFillable()));
        $staff->save();

        return redirect()->route('staff.edit',['id'=>$id])->with('status', 'Save success!');
    }

    public function destroy($id){

        $staff = Staff::findOrFail($id);
        $staff->subject()->update(['up_num'=>$staff->up_num]);
        $staff->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function subordinate(Request $request){
        $request->validate([
            'up_num' => 'required|integer',
            'subject' => 'required|array'
        ]);

        $branch = Staff::findOrFail($request->get('up_num'));
        $branch = $branch->branch->map(function ($item, $key) {
            return $item->id;
        });
        $branch = $branch->push($request->get('up_num'));

        $redir = redirect()->route('staff.edit',['id' => $request->get('up_num')]);

        $staff = new Staff();

        $moved = [];

        foreach ($request->get('subject') as $row){
            if(is_int($branch->search($row))){
                $redir = $redir->with('error', "Can't move: ".Staff::find($row)->full_name);
            }else{
                $staff = $staff->orWhere('id',$row);
                $moved[] = $row;
            }
        }
        if (count($moved)>0)
            $staff->update(['up_num'=>$request->get('up_num')]);

        return $redir->with('new',$moved);
    }

    public function image(Request $request,$id){
        $request->validate(['file' => 'file|image']);
        $path =public_path().'\image\\';
        $file = $request->file();
        foreach ($file as $f) {
            $img = ImageInt::make($f);
            $img->resize(150,200)->save($path . 'b\\' . $id . '.jpg');
            $img->resize(50,66)->save($path . 's\\' . $id . '.jpg');
        }
        return response()->json([
            'url' => asset('image/b/' . $id . '.jpg')
        ]);
    }

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

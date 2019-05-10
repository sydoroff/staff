@extends('app')

@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <div class="container">

        @include('branch')

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (!empty($staff))
                <div class="card">
                    <div class="card-header">Change photo</div>
                    <div class="card-body">
                        @if($staff->photo)
                            <img src="{{asset('image/b/' . $staff->id . '.jpg')}}" class="img-thumbnail" width="150" height="200" id="prof_img">
                        @else
                            <img src="/image/default_b.jpg" width="150" height="200" id="prof_img">
                        @endif
                    </div>
                    <div class="card-footer">
                        <form action="#" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" class="form-control-file border" id="customFile">
                            <button id="but_upload" value="{{route('staff.image',['id'=>$staff->id])}}"
                                    class="btn btn-outline-primary" type="button" disabled>Save image</button>
                        </form>
                    </div>
                </div>

            <script src="/js/staff_image.js"></script>

        <hr>
        @endif

    <div class="card">
        <div class="card-header">{{!empty($staff) ? "Change main info" : "New worker"}}</div>
        <div class="card-body">
        <form action="{{!empty($staff) ? route('staff.update',['id'=>$staff->id]) : route('staff.store')}}" method="post">
            @csrf
            {{!empty($staff->full_name) ? method_field('PUT') : '' }}
            <div class="form-group">
                <label for="full_name">Full name</label>
                <input type="text" class="form-control" name="full_name" id="full_name" value="{{!empty($staff->full_name) ? $staff->full_name : ''}}" required>
            </div>
            <div class="form-group">
                <label for="position">Job Title</label>
                <input type="text" class="form-control" name="position" id="position" value="{{!empty($staff->position) ? $staff->position : ''}}" required>
            </div>
            <div class="form-group">
                <label for="employment">Star at</label>
                <input type="date" class="form-control" name="employment" id="employment" value="{{!empty($staff->employment) ? $staff->employment : ''}}" required>
            </div>
            <div class="form-group">
                <label for="pay">Pay</label>
                <input type="number" class="form-control" name="pay" id="pay" value="{{!empty($staff->pay) ? $staff->pay : ''}}" required>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Boss</span>
                </div>
                <input type="text" class="form-control" id="boss_name" value="{{!empty($staff->boss_name) ? $staff->boss_name : 'none - CEO'}}" readonly>
                <input type="hidden" class="form-control" name="up_num" id="up_num" value="{{!empty($staff->up_num) ? $staff->up_num : '0'}}">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#myModal"
                            onclick="{{!empty($staff) ? "tree_init(".$staff->id.",true, '".route('api.names')."')" : "tree_init(0,false, '".route('api.names')."')"}};boss_tree();">Select</button>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" onclick="$('#up_num').val(0);$('#boss_name').val('none - CEO');">CEO</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
    </div>

        <hr>
        @if (!empty($staff))
        @if(count($staff->subject)>0)
           <div class="card">
               <div class="card-header">Change subordinate</div>
               <div class="card-body">
                    <form id="subForm" action="{{route('staff.subordinate')}}" method="post" >
                        @csrf
                            @foreach($staff->subject as $row)
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="subject[]" class="form-check-input" value="{{$row->id}}">
                                            <a href="{{route('staff.edit',['id'=>$row->id])}}">{{$row->full_name}}</a>
                                            @if (session('new'))
                                                @if(in_array($row->id,session('new')))
                                                    <sup><span class="badge badge-pill badge-success">New</span></sup>
                                                @endif
                                            @endif
                                        </label>
                                    </div>
                            @endforeach
                        <input type="hidden" name="up_num" id="forwardUpNum">
                        <br>
                        <button type="button" class="btn btn-primary" onclick="tree_init(0,false,'{{route('api.names')}}');sub_tree(event);">Forward</button>
                    </form>
               </div>
           </div>
        @endif
        @endif



    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Select worker</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body" id="modal-body">
                    <div id="tree">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.7/themes/default/style.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.7/jstree.min.js"></script>
    <script src="/js/staff_edit.js"></script>
@endsection
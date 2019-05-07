@extends('app')

@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <div class="container">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{!empty($staff->full_name) ? route('staff.update',['id'=>$staff->id]) : route('staff.store')}}" method="post">
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
                    <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#myModal">Select</button>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="button" onclick="$('#up_num').val(0);$('#boss_name').val('none - CEO');">CEO</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Modal Heading</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div id="tree">
                    </div>
                    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.7/themes/default/style.min.css" />
                    <script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.7/jstree.min.js"></script>
                    <script>
                        $(function() {
                            $('#tree').jstree({
                                'core' : {
                                    'data' : {
                                        "url" : "{{route('api.names')}}",
                                        "data" : function (node) {
                                            if (node.id!='#')
                                                return { "id" : node.id };
                                            else
                                                return { 'id' : 0};
                                        }
                                    }
                                }
                            });
                        });

                        $("#tree").on("select_node.jstree",
                            function(evt, data){
                                $("#up_num").val(data.node.id);
                                $("#boss_name").val(data.node.text);
                                $("#myModal").modal('hide');
                            }
                        );
                    </script>
                </div>
            </div>
        </div>
    </div>

@endsection
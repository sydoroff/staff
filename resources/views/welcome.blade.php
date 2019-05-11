@extends('app')

@section('content')

    <div id="tree">
    </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.7/themes/default/style.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.7/jstree.min.js"></script>
    <script>
        $(function() {
            $('#tree').jstree({
                'core' : {
                    'data' : {
                        "url" : "{{route('api.home')}}",
                        "data" : function (node) {
                            if (node.id!='#')
                                return { "id" : node.id };
                            else
                                return { 'id' : 0};
                        }
                    },
                    "check_callback" : true
                },
                plugins : ['dnd']
            });

            var token = $("meta[name='csrf-token']").attr("content");

            $(document).on({
                'dnd_stop.vakata':
                    function(evt, data){
                        node = data.data.origin.get_node(data.data.nodes[0]);
                        (node.parent == '#') ? parent = '0' : parent = node.parent;
                        $.post( "{{route('api.staff.move')}}", { 'id': node.id, 'up_num': parent, "_token": token })
                            .fail(function() {
                                alert( "Error" );
                                $('#tree').jstree(true).refresh();
                            })
                            .done(function() {
                                alert( "Save success" );
                            });
                        }
            });
        });
    </script>
@endsection
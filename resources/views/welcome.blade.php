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
                    }
                }
            }).on("load_node.jstree",
                function(evt, data){
                    var myTree = this
                    if(data.node.parents.length%2==0)
                        $.each(data.node.children,function( key, value ){
                            $(myTree).jstree(true).toggle_node(value);
                        });
                }
            );
        });
    </script>
@endsection
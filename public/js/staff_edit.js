function tree_init(id = 0,safe = true,url) {
    $('#tree').remove();
    $('#modal-body').append('<div id="tree"></div>');
    $('#tree').jstree({
        'core' : {
            'data' : {
                "url" : url,
                "data" : function (node) {

                    if (node.id!='#'){

                        if (node.id==id && safe) return false;

                        return { "id" : node.id };}
                    else
                        return { 'id' : 0};
                }
            }
        }
    });
}

function boss_tree(){
    $("#tree").off("select_node.jstree");
    $("#tree").on("select_node.jstree",
        function(evt, data){
            $("#up_num").val(data.node.id);
            $("#boss_name").val(data.node.text);
            $("#myModal").modal('hide');
        }
    );}

function sub_tree(e) {
    $("#tree").off("select_node.jstree");
    $("#tree").on("select_node.jstree",
        function(evt, data){
            $("#forwardUpNum").val(data.node.id);
            $("#myModal").modal('hide');
            if(confirm("Forward selected workers to " + data.node.text + "?")) {
                $("#subForm").submit();
            }
        }
    );
    $("#myModal").modal('show');

    return false;
}
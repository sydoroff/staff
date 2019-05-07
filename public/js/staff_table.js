function show_table( page = 1, sort = [] ){

    var url = '/api/table/';

    $('.my-new-tbody').remove();

    $( "<tbody/>", {
        "class": "my-new-tbody",
        html: "<div class=\"spinner-border text-secondary m-5\" role=\"status\">\n" +
        "  <span class=\"sr-only\">Loading...</span>\n" +
        "</div>"
    }).appendTo( "table" );

    var parametr = new Array();
    parametr = parametr.concat($("form").serializeArray(),[{name: 'page' , 'value' : page}],sort);

    $.getJSON( url, parametr).fail(function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
    }).done(function( data ) {
        var items = [];
        $.each( data.data, function( key, val ) {
            items.push( "<tr id='st" + val.id + "'>"+
                "<td><a href='/staff/"+ val.id +"/edit'>" + val.id + "</a></td>" +
                "<td>" + val.full_name + "</td>" +
                "<td>" + val.position + "</td>" +
                "<td>" + val.employment + "</td>" +
                "<td>" + val.pay + "</td>" +
                "<td>" + (val.boss_name ? val.boss_name : ' - - - ' ) + "</td>" +
                "<td><button class=\"deleteRecord btn btn-danger btn-sm\" data-id=\""+val.id+"\" >Delete</button></td>"+
                "</tr>" );
        });

        $.each(data.search_sort_param,function( key, val ) {
            $("form input[name="+key+"]").val(val);
            $("table a[id="+key.replace(/_to|_from/,'')+"]").off("click").click(function() {
                show_table(1,[{'name':'sort','value':key.replace(/_to|_from/,'')},{'name':'set','value':(data.search_sort_param.sort==key.replace(/_to|_from/,'') && data.search_sort_param.set=='asc' ? 'desc' : 'asc')}]);
            });
        });

        render_pagination(data,'#pages');

        $("#sort_set").remove();
        $("table a[id="+data.search_sort_param.sort+"]").append($(data.search_sort_param.set=='desc' ? '<span id="sort_set">&#9650;</span>' : '<span id="sort_set">&#9660;</span>'));

        $('.my-new-tbody').remove();

        $( "<tbody/>", {
            "class": "my-new-tbody",
            html: items.join( "" )
        }).appendTo( "table" );

        render_del_link();
    });
}

function render_del_link() {
    $(".deleteRecord").click(function(){

        var id = $(this).data("id");
        var token = $("meta[name='csrf-token']").attr("content");

        if (confirm("Delete item: "+id+"?"))
        $.ajax(
            {
                url: "/staff/"+id,
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (){
                    $('tr#st'+id).remove();
                }
            });

    });
}


function render_pagination(data,ins){

    $(ins).html('');

    if (data.current_page-3>1){
        $('<a>',{
            "class":"btn btn-light",
            text: 1,
            click:function() {
                show_table(1,(data.search_sort_param.sort && data.search_sort_param.set ?
                    [{'name':'sort','value':data.search_sort_param.sort},{'name':'set','value':data.search_sort_param.set}]:
                    []));
            }}).appendTo(ins);
        if (data.current_page-4>1) {
            $(ins).append(' ... ');
            $('<a>',{
                "class":"btn btn-light",
                text: '<<',
                click:function() {
                    show_table(data.current_page-1,(data.search_sort_param.sort && data.search_sort_param.set ?
                        [{'name':'sort','value':data.search_sort_param.sort},{'name':'set','value':data.search_sort_param.set}]:
                        []));
                }}).appendTo(ins);
            $(ins).append(' .. ');
        }
    }

    for(let i = (data.current_page-3>1 ? data.current_page-3 : 1); i < (data.current_page+3<data.last_page ? data.current_page+4 : data.last_page+1);i++){
        $('<a>',{
            "class":"btn " + (data.current_page==i ? "btn-secondary text-light disabled" : "btn-light" ),
            text: i,
            click:function() {
                show_table(i,(data.search_sort_param.sort && data.search_sort_param.set ?
                    [{'name':'sort','value':data.search_sort_param.sort},{'name':'set','value':data.search_sort_param.set}]:
                    []));
            }}).appendTo(ins);
    }
    if (data.current_page+3<data.last_page){
        if (data.current_page+4<data.last_page){
            $(ins).append(' .. ');
            $('<a>',{
                "class":"btn btn-light",
                text: '>>',
                click:function() {
                    show_table(data.current_page+1,(data.search_sort_param.sort && data.search_sort_param.set ?
                        [{'name':'sort','value':data.search_sort_param.sort},{'name':'set','value':data.search_sort_param.set}]:
                        []));
                }}).appendTo(ins);
            $(ins).append(' ... ');
        }
        $('<a>',{
            "class":"btn btn-light",
            text: data.last_page,
            click:function() {
                show_table(data.last_page,(data.search_sort_param.sort && data.search_sort_param.set ?
                    [{'name':'sort','value':data.search_sort_param.sort},{'name':'set','value':data.search_sort_param.set}]:
                    []));
            }}).appendTo(ins);}
}
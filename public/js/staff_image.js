$(document).ready(function(){

    $("#but_upload").click(function(){

        $("#but_upload").attr('disabled',true);
        var fd = new FormData();
        var files = $('#customFile')[0].files[0];
        var url_val = this.value;
        fd.append('file',files);
        fd.append('_token',$("meta[name='csrf-token']").attr("content"));

        $.ajax({
            url: url_val,
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(data){
                $("#prof_img").attr("src",data.url);
                $("prof_img").show();
                alert('Image saved.');
            },
            error:function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            },
        });
    });
});

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#prof_img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#customFile").change(function() {
    readURL(this);
    $("#but_upload").attr('disabled',false);
});
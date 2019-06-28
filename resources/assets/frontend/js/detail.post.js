
$('.action_public').click(function(){
    let btn_text =  $('#btn_public').text();
    let btn_value =   $('#btn_public').attr('value');
    $('#btn_public').text($(this).text());
    $('#btn_public').attr('value', $(this).attr('value'));
    $(this).text(btn_text);
    $(this).attr('value',btn_value);
});
$('.action_post').click(function(){
    let btn_text =  $('#btn_approve').text();
    let btn_value =   $('#btn_approve').attr('value');
    $('#btn_approve').text($(this).text());
    $('#btn_approve').attr('value', $(this).attr('value'));
    $(this).text(btn_text);
    $(this).attr('value',btn_value);
    if($('#btn_approve').attr('value') == -1){
        $('#save_action').prop('disabled',true);
    }else{
        $('#save_action').prop('disabled',false);
    }
});
if($('#btn_approve').attr('value') == -1){
    $('#save_action').prop('disabled',true);
}else{
    $('#save_action').prop('disabled',false);
}



// {{--Gửi request ajax khi ấn nút lưu--}}

$('#save_action').click(function(){
    var is_public=$('#btn_public').attr("value");
    var is_approve = $('#btn_approve').attr("value");
    var id_post = $('#btn-route').attr("value");
    var route = $('#btn-route').attr("name");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method:"POST",
        url: route,
        data: {is_public : is_public,is_approve : is_approve,id_post : id_post},
    dataType: 'json',

        success: function(data)
    {
            location.reload();
    }
});

});

$('#save_all_action').click(function(){
    var is_public = 1;
    var is_approve = 1;
    var id_post = $('#btn-route').attr("value");
    var route = $('#btn-route').attr("name");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method:"POST",
        url: route,
        data: {is_public : is_public,is_approve : is_approve,id_post : id_post},
        dataType: 'json',

        success: function(data)
        {
            location.reload();
        }
    });

});

// fix image larger than screen
var data = $('.card-post-detail .card-body p');
data.each(function () {
    if($(this).has("img").length != 0){
        if($(this).find("img").width() > $('.card.card-post-detail').width()){
            console.log('nam');
            $(this).addClass('img-fit-screen');
        }
    }
});

//category_sidebar
var height_sidebar = $(window).height();
if($('.card-post-detail').height() < $(window).height()){
    height_sidebar = $('.card-post-detail').height() ;
}
$('.list-menu-left').height(height_sidebar);

$('#sidebar_post').click(function(){
    $('#sidebar_content_post').addClass('sidebar-left-show');
    $('.overlay').addClass('active');
    $('#close_sidebar').addClass('d-block');

});
$('.overlay,#close_sidebar').click(function(){
    $('#sidebar_content_post').removeClass('sidebar-left-show');
    $('#close_sidebar').removeClass('d-block');
    $('.overlay').removeClass('active');
})
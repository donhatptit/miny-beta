$('.category-move').click(function(e){
    e.preventDefault();
    move_link = $(this).attr('data-link');
    $.get(move_link, '', function(data){
        if(data.movable){
            bootbox.dialog({
                title: data.move_title,
                message: data.message,
                buttons: {
                    cancel: {
                        label: 'Hủy',
                        callback: {}
                    },
                    yes: {
                        label: 'Đồng ý',
                        callback: function(){
                            sendRequest(data.move_link);
                        }
                    }
                }
            }).show();
        }else{
            bootbox.alert({
                title: data.move_title,
                message: data.message
            });
        }

    },'json');
    return false;
});
$('.category-delete').click(function(e){
    e.preventDefault();
    del_link = $(this).attr('data-link');
    bootbox.dialog({
        title: 'Xóa danh mục',
        message: 'Bạn có muốn xóa danh mục',
        buttons: {
            cancel: {
                label: 'Hủy',
                callback: {}
            },
            yes: {
                label: 'Đồng ý',
                callback: function(){
                    sendRequest(del_link);
                }
            }
        }
    }).show();
    return false;
});
function sendRequest(move_link){
    $.ajax({
        url: move_link,
        method:"GET",
        success : function(data){
            bootbox.alert({
                title : data.title,
                message:data.message,
                callback: function(){
                location.reload();
            }

        });
        }
    });
}


// phan loc theo lớp , môn
$( document ).ready(function() {

    $('.select2').select2();
    var cate_root =  $('#category_root').val();
    if(cate_root !=''){
        changeSelectCategory();
    }
    $('#category_root').on('change', function () {
        changeSelectCategory();
    });
    function changeSelectCategory(){
        var id_cate =  $('#category_root').val();
        var url = $('#category_root').attr('data-link');
        $.ajax({
            method: 'POST',
            data: {id_cate: id_cate},
            url: url,
            success: function (data) {
                let id_cate_one = $('#category_one').val();
                $('#category_one').find('option')
                    .remove()
                    .end()
                    .append('<option value= "" selected>Chọn môn</option>');
                for (let i = 0; i < data.length; i++) {

                    $('#category_one').append($('<option>',
                        {
                            value: data[i].id,
                            text: data[i].name,
                        }));
                    if (data[i].id == id_cate_one) {
                        $('#category_one').val(id_cate_one).trigger('change.select2');
                    }
                }
            }


        });
    }
});
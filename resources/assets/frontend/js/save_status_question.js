$('#approve_question').change(function () {
    if( $('#approve_question').val() == -1){
        $('#reason').modal('show');
    }

});
    $('.save_status').click(function(e){
        e.preventDefault();
        var is_public=$('#public_question').val();
        var is_approve = $('#approve_question').val();
        var id_cate = $(this).attr("value");
        var route = $(this).attr("data-link");
        var comment = $('#comment').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method:"POST",
            url: route,
            data: { is_public : is_public,is_approve : is_approve,id_cate : id_cate, reason : comment},
            dataType: 'json',

            success: function(data)
            {
                location.reload();
            }
        });

    });
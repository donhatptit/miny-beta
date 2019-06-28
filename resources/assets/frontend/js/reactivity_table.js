var i = 0;
$('#extendButton').click(function () {
    i++;
    if (i%2 == 1){
        $(this).html("<i class='fas fa-angle-left'></i>Thu hẹp");
        $('table').css('margin','auto');
        $('.extend').fadeToggle();
        $('.strong-metal').attr('colspan',7);
        $('.average-metal').attr('colspan',9);
        $('.weak-metal').attr('colspan',9);
    }else{
        $(this).html("<i class='fas fa-angle-right'></i>Mở rộng");
        $('table').css('margin-left',0);
        $('.extend').fadeToggle();
        $('.strong-metal').attr('colspan',6);
        $('.average-metal').attr('colspan',5);
        $('.weak-metal').attr('colspan',5);
    }

});
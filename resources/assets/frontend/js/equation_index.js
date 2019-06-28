$('.cate-demo.tohide').hide();
var i = 0;
$('#more').click(function () {
    // $('.cate-demo.tohide').toggleClass('d-none');

    $('.cate-demo.tohide').slideToggle('slow','linear');
    // $('.cate-demo.tohide').fadeIn();
    // $("html, body").stop().animate({scrollTop:$(this).offset().top}, 1000, 'linear', function() {});

    i++;
    if ( i %2 == 1){
        $(this).html('Thu gọn');
    }else{
        $(this).html('Xem thêm');
    }
});



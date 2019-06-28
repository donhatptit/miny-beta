$('.periodic-table .chemical').hover(
    function (){
        $(this).parent().addClass('detect');
        $("colgroup").eq($(this).index()).addClass("detect");
    }, function () {
        $(this).parent().removeClass('detect');
        $("colgroup").eq($(this).index()).removeClass("detect");
    });
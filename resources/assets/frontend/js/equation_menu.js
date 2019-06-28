
var j = 0;
var k = 0;
// $('.menu button').click(function(){
//     if ($(window).width() < 992 ){
//         j++;
//         if(j % 2 == 0){
//             $('.wrapper').addClass('d-none');
//         }else{
//             $('.wrapper').removeClass('d-none');
//         }
//     }
// });
if ($(window).width() > 992 ) {
    $('#list-tool, #list-category').hover(function () {
        $(this).removeClass('d-none')
    }, function () {
        $(this).addClass('d-none');
    });
    $('button.category').hover(function () {
        $('#list-category').removeClass('d-none')
    }, function () {
        $('#list-category').addClass('d-none');
    });
    $('button.tool').hover(function () {
        $('#list-tool').removeClass('d-none')
    }, function () {
        $('#list-tool').addClass('d-none');
    });
}
// click menu
$('html,body').click(function () {
    $('.list-category').addClass('d-none');
});
$('button.category').click(function(event){
    if ($(window).width() < 992 ){
        event.stopPropagation();
        $('#list-tool').addClass('d-none');
        // j++;
        if(!$('#list-category').hasClass('d-none')){
            $('#list-category').addClass('d-none');
        }else{
            $('#list-category').removeClass('d-none');
        }
    }
});
$('button.tool').click(function(event){
    if ($(window).width() < 992 ){
        event.stopPropagation();
        $('#list-category').addClass('d-none');
        // k++;
        // if(k % 2 == 0){
        if(!$('#list-tool').hasClass('d-none')){
            $('#list-tool').addClass('d-none');
        }else{
            $('#list-tool').removeClass('d-none');
        }
    }
});
suggestSearchEquation();
function suggestSearchEquation(){
    $(".search-equation").each(function () {
        var input = $(this);
        var before = '';
        var to_show = '';
        var name = input.attr('name');
        $(this).autoComplete({
            minChars: 0,
            delay: 150,
            cache: 1,
            source: function (term, suggest) {
                term = term.toLowerCase();
                name == 'chat_tham_gia' ? $.getJSON("/suggestequation/ajax/left", {chat_tham_gia: term}, function (data) {
                        suggest(data);
                    }) :
                    $.getJSON("/suggestequation/ajax/right", {chat_san_pham: term}, function (data) {
                        suggest(data);
                    });
            },
            renderItem: function (item, search) {
                return '<div class="autocomplete-suggestion custom py-1" data-symbol="' + item[0] + '" data-name_vi="' + item[1] + '" data-val="' + search + '">' + item[0] + ' (' + item[1] + ')</div>';
            },
            onSelect: function (e, term, item) {
                before = input.val();
                if (before.lastIndexOf(" ") != -1){
                    to_show = before.substring(0,before.lastIndexOf(" "))+" "+item.data('symbol')+" ";
                }else{
                    to_show = item.data('symbol')+" ";
                }
                input.val(to_show);
                if ($(window).width() > 992 ){
                    $('.search').one('submit', function(e) {
                        e.preventDefault();
                        $(this).submit();
                    });
                }
            }
        });
    });
}
suggestSearchChemical();
function suggestSearchChemical(){
    $('.search-chemical').autoComplete({
        minChars: 0,
        delay: 150,
        cache: 1,
        source: function (term, suggest) {
            term = term.toLowerCase();
            $.getJSON("/suggestchemical/ajax", {chat_hoa_hoc: term}, function (data) {
                suggest(data);
            });
        },
        renderItem: function (item, search) {
            return '<div class="autocomplete-suggestion custom py-1" data-symbol="' + item[0] + '" data-name_vi="' + item[1] + '" data-val="' + search + '">' + item[0] + ' (' + item[1] + ')</div>';
        },
        onSelect: function (e, term, item) {
            $('.search-chemical').val(item.data('symbol'));
            if ($(window).width() > 992 ) {
                $('.search').one('submit', function (e) {
                    e.preventDefault();
                    $(this).submit();
                });
            }
        }
    });
}
var count = 0;
$('.show-header').click(function () {
    if ($(window).width() < 768 ){
        count++;
        $('.equation-heading').slideToggle();
        if (count % 2 == 1){
            $(this).html("<i class='fa fa-angle-down'></i>");
            $('#toshow').html("<i class='fa fa-angle-up'></i>");
        }else{
            $(this).html("<i class='fa fa-angle-up'></i>");
            $('#toshow').html("<i class='fa fa-angle-down'></i>");
        }
    }
});
$('#show-real').focus(function () {
    $('.fake-search').fadeOut(100);
    $('.real-search').removeClass('d-none');
    $('.real-search').slideDown();
    $('.left.search-equation').focus();
});
$('.fake-submit').click(function () {
    $('.fake-search').fadeOut(100);
    $('.real-search').removeClass('d-none');
    $('.real-search').slideDown();
    $('.left.search-equation').focus();
});
// tooltip js for all chemical equation page
$('[data-toggle="tooltip"]').tooltip();
$('ul.pagination li.active')
    .prev().addClass('show-mobile')
    .prev().addClass('show-mobile');
$('ul.pagination li.active')
    .next().addClass('show-mobile')
    .next().addClass('show-mobile');
$('ul.pagination')
    .find('li:first-child, li:last-child, li.active')
    .addClass('show-mobile');

if ($(window).width() < 992 ){
    $('ul.pagination li:not(.show-mobile)').css('display','none');
}

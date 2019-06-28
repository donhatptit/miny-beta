
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');

// window.Vue = require('vue');
//
// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
//
// Vue.component('example-component', require('./components/ExampleComponent.vue'));
//
// const app = new Vue({
//     el: '#app'
// });
//applying arrows that indicates nested items
$('#mm-toggle > ul > li').has("ul").addClass("has-sub");
$('#mm-toggle ul li:not(.has-sub)').has("ul").addClass("has-inner-sub");

// required only for mobile version
$('#mm-toggle li.has-inner-sub, #mm-toggle li.has-sub').on('click', function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).children('ul').toggleClass('show');
});

if ($(window).width() <= 768) {
    var chemical_equation_dom = "<li><a class='class-link d-inline-block' href='/danh-muc/phuong-trinh-hoa-hoc'style='width:100%;'>Phương trình hóa học</a></li>";
    $('#sidebar .list-unstyled.components').prepend(chemical_equation_dom);
    // $(chemical_equation_dom).insertAfter('#sidebar .list-unstyled p');
    // $('#sidebar .list-unstyled.components li').eq(-1).remove();
}

// remake menu

$('#dismiss, .overlay').on('click', function () {
    // hide sidebar
    $('#sidebar').removeClass('active');
    // hide overlay
    $('.overlay').removeClass('active');
    if($('#sidebar').hasClass('active')){
        $('html, body').addClass('frozen-scoll');
    }else{
        $('html, body').removeClass('frozen-scoll');
    }
});

$('#sidebarCollapse').on('click', function () {
    // open sidebar
    $('#sidebar').addClass('active');
    // fade in the overlay
    $('.overlay').addClass('active');
    $('.collapse.in').toggleClass('in');
    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
    if($('#sidebar').hasClass('active')){
        $('html, body').addClass('frozen-scoll');
    }else{
        $('html, body').removeClass('frozen-scoll');
    }
});
$('.show-submenu').click(function(){
    if($(this).next().hasClass('show')){
        $(this).find('i').attr('class','fas fa-plus');
    }else{
        $(this).find('i').attr('class','fas fa-minus');
    }
});
$(".menu-header li.nav-item.child-one").on('mouseenter mouseleave', function (e) {
    if ($('ul', this).length) {
        // submenu'width:
        var elm = $('ul:first', this);
        var w = elm.width();
        // item position:
        var l = $(this).offset().left
        var docW = $(window).width();

        var isEntirelyVisible = (l + w <= docW);

        if (!isEntirelyVisible) {
            $(this).addClass('edge');
        } else {
            $(this).removeClass('edge');
        }
    }
});
var lastScrollTop = 0;
var h1 = $('.top-head').height();
var h2 = $('.nav-desktop').height();
var h = h1 + h2;
function scrollup_desktop(position,h) {
    // handlle scroll up event
    if (position > lastScrollTop && position > h) {
        $('.nav-desktop').addClass('d-none');
        $('.nav-desktop').removeClass('menu-animation');
    }else if ( position < lastScrollTop && position > h) {
        $('.nav-desktop').addClass('menu-animation');
        $('.nav-desktop').removeClass('d-none');
    }
    lastScrollTop = position;
}
function scrollup_mobile(position){
    if (position > lastScrollTop && position > 50) {
        $('.main-content').addClass('main-padding');
        $('.navbar').addClass('d-none ');
        $('#custom-search-form').removeClass('menu-mobile-change menu-animation2');
        $('.navbar').removeClass('menu-mobile-change menu-animation');
    }else if ( position < lastScrollTop && position > 50) {
        $('#custom-search-form').addClass('menu-mobile-change menu-animation2');
        $('.navbar').addClass('menu-mobile-change menu-animation');
        $('.navbar').removeClass('d-none');
    }
    lastScrollTop = position;
}
$(window).scroll(function(event) {
    var position = $(this).scrollTop(); // tinh vi tri
    if ($(window).width() > 576 ) {
        if ( position > h )  {
            $('.nav-desktop').addClass('menu-change');
            $('.main-content').addClass('bg-margin1');
        }else if (position < h1) {
            $('.nav-desktop').removeClass('menu-change d-none menu-animation');
            $('.main-content').removeClass('bg-margin1');
        }
        scrollup_desktop(position,h);
    }else if ($(window).width() <= 576){
        if (position == 0) {
            $('.navbar').removeClass('menu-mobile-change');
            $('#custom-search-form').removeClass('menu-mobile-change');
            $('.main-content').removeClass('main-padding');
        }
        scrollup_mobile(position);
    }
});
if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}

if ('serviceWorker' in navigator && 'PushManager' in window) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
            // Registration was successful
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
            // registration failed :(
            console.log('ServiceWorker registration failed: ', err);
        });
    });
}
// js muc luc trang chi tiet bai viet
$('#toggle').click(function(){
    $(".widget-toc ol").toggleClass('wiget-toc-display');
    if($(".widget-toc ol").hasClass('wiget-toc-display')){
        $(this).text('+');
    }else{
        $(this).text('-');
    }
});
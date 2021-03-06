<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="fb:app_id" content="{{ config('app.fb_app_id') }}" />
    {!! SEO::generate() !!}
    @yield('css')
    <link rel="shortcut icon" type="image/png" href="{{ url('/favicon.png') }}"/>
    @if(!empty(config('app.google_ga')))
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-121780380-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '{{ config('app.google_ga') }}');
        </script>
    @endif
</head>
<body>
<div id="fb-root"></div>
<div class="fb-customerchat" attribution=setup_tool page_id="473332793174039"
     greeting_dialog_display="hide"
     logged_in_greeting="Chúng mình có thể giúp gì cho bạn ?"
     logged_out_greeting="Chúng mình có thể giúp gì cho bạn ?">
</div>
<div>
    <div style="background: #f1f1f1">
        {{--@include('frontend.includes.header')--}}
        <div class="head-wrapper">
            <header style="background: #fff">
                <div class="container">
                    <nav class="navbar navbar-expand-lg navbar-light bg-white top-head" style="padding: 0rem;">
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img style="height: 50px;" src="{{ url(config('app.logo')) }}">
                        </a>
                        <div class="navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                            </ul>
                            <div class="input-append span12 d-none d-sm-block">
                                <gcse:search enableAutoComplete="true"></gcse:search>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="menu-header nav-desktop">
                    <div class="container">
                        <nav class="navbar navbar-expand-xl navbar-light">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse navbar-menu-content" id="navbarNav">
                                <ul class="navbar-nav nav nav-pills nav-fill root-category" style="width: 100%">
                                    @foreach($header_categories as $key=> $category)
                                        <li class="nav-item active child-one">
                                            @if(count($category->children) > 0)
                                                <a class="nav-link" href="{{ $category->link }}" id="child_list_item{{ $category->id }}" role="button" data-toggle="dropdown"
                                                   aria-haspopup="false" aria-expanded="true">
                                                    {{ $category->name }}
                                                </a>
                                                <div class="dropdown-menu list-columns" aria-labelledby="child_list_item{{ $category->id }}" >
                                                    <ul class="list-unstyled">
                                                        @foreach($category->children as $child)
                                                            <li><a class="dropdown-item" href="{{ $child->link }}">{{ $child->name }}</a> </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <a class="nav-link" href="{{ $category->link }}">{{ $category->name }}</a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </header>
            <!-- Sidebar -->
            <nav id="sidebar" class="nav-mobile">

                <div id="dismiss">
                    <i class="fas fa-arrow-left"></i>
                </div>
                <div class="sidebar-header">
                    {{--<h3>Cùng học vui</h3>--}}
                    <a href="{{ url('/') }}">
                        <img style="height: 55px;" src="{{ url(config('app.logo')) }}">
                    </a>
                </div>
                <p>Danh mục</p>
                <ul class="list-unstyled components">

                    @foreach($header_categories as $key=> $category)
                        <li >
                            @if(count($category->children) > 0)

                                <a class="class-link d-inline-block" href="{{ $category->link }}" >{{ $category->name }}
                                </a>
                                <span class="show-submenu float-right" href="#child{{$key}}" data-toggle="collapse" aria-expanded="false">
                                <i class="fas fa-plus"></i>
                            </span>
                                <ul class="collapse list-unstyled sub-menu" id="child{{$key}}">
                                    @foreach($category->children as $child)
                                        <li>
                                            <a href="{{ $child->link }}">{{ $child->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <a style="width: 100%;" class="class-link d-inline-block" href="{{ $category->link }}">{{ $category->name }}</a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
            <!-- Page Content -->
            <div id="menu-navbar" class="nav-mobile">
                <nav class="navbar navbar-expand-lg" style="width: 100%;z-index: 2;">
                    <button type="button" id="sidebarCollapse" class="btn show-sidebar-btn">
                        <span style="color:white;">&#9776;</span>
                    </button>
                    <form style="margin-right: 15px;" id="custom-search-form" class="form-search form-horizontal d-sm-none d-xs-block" action="https://cse.google.com/cse">
                        <div class="input-append span12">
                            <input value="015306605513871036558:rq9yjooac5w" name="cx" type="hidden"/>
                            <input value="FORID:11" name="cof" type="hidden"/>
                            <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                            <input id="q" type="text" class="search-query mac-style" placeholder="Tìm kiếm câu hỏi" name="q">
                        </div>
                    </form>
                </nav>
            </div>
            <!-- Dark Overlay element -->
            <div class="overlay nav-mobile"></div>

        </div>

        <section class="main-content">
            @yield('content')
        </section>
        <a href="#" id="back-to-top" title="Back to top">&uarr;</a>
        {{--        @include('frontend.includes.footer')--}}

        <footer id="footer">
            <div class="container">
                <div class="text-center footer-1">
                    <a href="{{ url('/') }}" rel="nofollow">
                        <img style="height: 55px;" src="{{ url(config('app.logo')) }}">
                    </a>
                </div>
                <div class="footer-2 d-none d-md-block">
                    <div class="d-flex bd-highlight footer-menu">
                        @foreach($footer_categories as $category)
                            <div class="flex-fill bd-highlight text-center menu-item">
                                <a href="{{ $category->link }}">{{ $category->name }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="text-center footer-3">
                    Copyright &copy; 2018 CungHocVui
                </div>
            </div>
        </footer>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
{{--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>--}}
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script src="{{ url('frontend/js/app.js') }}"></script>
<script src="{{ url('frontend/plugins/autocomplete/jquery.auto-complete.min.js') }}"></script>

<noscript id="css-after"><link rel="stylesheet" href="{{ url('frontend/css/app_equation.css') }}?<?php echo date('l jS \of F Y h:i:s A'); ?>" type="text/css" /></noscript>
{{--<noscript class="css-after"><link rel="stylesheet" href="{{ url('frontend/plugins/autocomplete/jquery.auto-complete.css') }}" type="text/css" /></noscript>--}}
<script>
    var loadDeferredStyles = function() {
        var addStylesNode = document.getElementById("css-after");
        var replacement = document.createElement("div");
        replacement.innerHTML = addStylesNode.textContent;
        document.body.appendChild(replacement)
        addStylesNode.parentElement.removeChild(addStylesNode);
    };
    var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
        window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
    if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
    else window.addEventListener('load', loadDeferredStyles);
</script>
<script> var facebook_app_id = {{ config('app.fb_app_id') }};</script>
@yield('after-scripts')
<script>
    $('.nav-item').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(0).fadeIn(0);
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(0).fadeOut(0);
    });
    $('.nav-link').click(function() {
        location.href = this.href;
    });
</script>

</body>
</html>
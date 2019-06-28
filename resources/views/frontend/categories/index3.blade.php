@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/cate_index3.css")) !!}
         {!! file_get_contents(public_path("frontend/css/category_sidebar.css")) !!}

        .read-more {
            font-weight: 500;
            float: right;
            min-width: 65px;
            padding: 0.3em 0.4em 0.25em;
            font-size: 82%;
            text-align: right;
            color:#14A9E3;
        }
        .read-more:hover {
            color : #188ebb;
        }
        @media only screen and (max-width: 991px) {
            .section-content {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .sidebar-left {
                margin-top: 0px !important;
            }
        }
        .sidebar-left{
            margin-top:15px;
        }
        .section-content{
         padding-left:30px !important;
        }
        .px-15{
            padding-left: 15px;
            padding-right:15px;
        }

    </style>
@endsection
@section('content')
    <div class="post-heading" style="margin-bottom: 25px;">
        <div class="container">
            @if($category_current->depth == 1)
                @php
                    $breadcrumbs_render = Breadcrumbs::render('category-subject', $category_current);
                @endphp
            @else
                @php
                    $breadcrumbs_render = Breadcrumbs::render('category-lesson', $category_current, $parent_category);
                @endphp
            @endif
            {{ $breadcrumbs_render or ''}}
            <div class="text-center">
                <h1 class="post-title">{{ $title or "Chưa có tiêu đề"}}</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <p class="text-dark px-15">{!! $category_current->description_top !!}</p>
            </div>
            <div class="col-lg-9 col-sm-12 row section-content">
                @if(count($categories_sidebar) > 2)
                <div class="col-lg-4">
                    <aside class="sidebar-left" id="sidebar_content_post">
                        <div id="close_sidebar">
                            <span class="btn-close-side-right">
                                <i class="fas fas-times"></i>
                            </span>
                        </div>
                        <ul class="list-menu-left">
                            @foreach($categories_sidebar as $cate_sidebar)
                                <a href="{{ route('frontend.category.index', ['slug' => $cate_sidebar->slug]) }}" class="{{ $cate_sidebar->slug == $category_current->slug ? "sidebar-active" : "" }}"><li class="{{ $cate_sidebar->depth <= 2 ? "cate-heading" : "cate-child" }} {{ $cate_sidebar->depth == 1 ? "subject-heading" : "" }} " > {{ $cate_sidebar->name }}</li></a>
                            @endforeach
                        </ul>
                    </aside>
                </div>
                @endif
                <div class="{{ count($categories_sidebar) < 2 ? "col-lg-12" : "col-lg-8" }}">
                    <div class="row body">
                        @if(count($posts) > 0)
                            @foreach($posts as $post)
                                <div class="col-lg-12">
                                    <a class="card card-post smooth" href="{{ route('frontend.post.detail', [
                                                                'slug' => $post->slug
                                                            ], false) }}" class="card-link"
                                       @if($post->is_public != 1)
                                       rel="nofollow"
                                            @endif
                                    >
                                        <div class="card-body">
                                            <h2 class="card-title">
                                                {{ $post->title }}
                                            </h2>
                                            <div class="d-flex bd-highlight mb-3 post-info">
                                                <div class="mr-auto bd-highlight">
                                                </div>
                                                <div class="bd-highlight" style="color: #999999; font-size: 13px;">
                                                </div>
                                            </div>

                                            <p class="card-text mb-2
                                            @if($subject == 'ngu-van')
                                                    article text-description-box block-with-text" style="display:block;height:44px
                                            @endif">
                                                {{ $post->description }}
                                            </p>
                                            <p class="card-text mb-2 article-check text-description-box block-with-text" style="display:none;">
                                                {{ $post->description }}
                                            </p>
                                            @if($subject == 'ngu-van')
                                                <span class='read-more'>Xem thêm</span>
                                                <div class="d-flex bd-highlight mb-0 post-info">
                                                    <div class="mr-auto bd-highlight" style="font-size:16px">
                                                        <span class="badge badge-pill badge-success" style=" font-weight:500;padding:5px 7px;background-color:#7088a9">{{ number_format($post->count_word) }} từ</span>
                                                        @foreach($post->kinds as $kind)
                                                            <span class="badge badge-pill" style=" font-weight:500;padding:5px 7px; background-color:{{ $kind->color }};color:white;">{{ $kind->name }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                        </div>

                                    </a>
                                </div>
                            @endforeach
                        @else
                            Đang hoàn thiện
                        @endif
                    </div>
                    <div class="mt-2">{{ $posts->links('frontend.includes.view_paginator') }}</div>
                </div>
            </div>
            <div class="col-lg-3 mt-3" style="padding-right:0">
                <div class="card card-post-right">
                    <div class="card-header">
                        Bài liên quan
                        <div class="heading-line"></div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($category_siblings as $category)
                            <li class="list-group-item">
                                <a href="{{$category->link}}" class="card-link">
                                <h3 style="font-weight: 400;">{{ $category->name }}</h3>
                                </a>
                            </li>

                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-lg-12 mt-3">
                <p class="text-dark px-15">{!! $category_current->description_bottom !!}</p>
            </div>
        </div>
        <div class="col-lg-4">
            {{--<img src="{{ url('default/img/ads.png') }}">--}}
        </div>

    </div>
    </div>

@endsection
@section('after-scripts')
    @if($subject == 'ngu-van')
    <script>
        $('.read-more').click(function(event){
            var height_full = $(this).parent().children('.article-check').height();
            var before_height = "44px";
            event.preventDefault();
            if($(this).attr('check') == 'true'){
                $(this).attr('check','false');
                $(this).html('Xem thêm');
                $(this).parent().children('.article').css('height',before_height);
                $(this).parent().children('.article').addClass('block-with-text');
            }else{
                $(this).parent().children('.article').css('height',height_full);
                $(this).attr('check','true');
                $(this).html('Thu nhỏ');
                $(this).parent().children('.article').removeClass('block-with-text');
            }


        });
    </script>
    @endif
    <script>
        var height_sidebar = $(window).height();
        if($('.section-content').height() < $(window).height()){
            height_sidebar = $('.section-content').height() ;
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
        });
    </script>
    @endsection
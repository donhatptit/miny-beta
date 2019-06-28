@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/university_news.css")) !!}
    </style>
@endsection

@section('content')
    <div class="post-heading" style="margin-bottom: 0px;">
        <div class="container">

            @php
                $breadcrumbs_render = Breadcrumbs::render('thong-tin-truong', $university, 'Tin tức tuyển sinh');
            @endphp
            {{ $breadcrumbs_render or ''}}
            <div class="text-center">
                <h1 class="post-title" style="margin-bottom:0">Tổng hợp tin tức tuyến sinh về trường {{ $university->vi_name }}</h1>
            </div>
        </div>
    </div>

    @include('frontend.admissions.filter')
    <div class="heading">
        <div class="container d-flex intro-university" >
            <div class="image-university">
                <img src="{!! App\Core\MyStorage::get_image_link("public", $university->avatar,'medium') !!}" alt="" width="100%" height="100%">
                <div class="ribbon featured-circle">
                    <span>{{ $university->keyword }}</span>
                </div>
            </div>
            <div class="text-heading ml-3">
                <h2>{{ $university->vi_name }} - {{ $university->en_name }} ({{ $university->keyword }}) <span><i class="icon-check-circle" style="color:#14a9e3; font-size:17px"></i></span></h2>
            </div>
        </div>

    </div>
    <div class="university-heading" style="background-color:white">
        <nav class="nav-info">
            <div class="container p-0 menu">
                <div class="col-md-8 ml-auto">
                    <ul class="list-unstyled list-inline list-menu text-center">
                        <li class="list-inline-item list-item"><a href="{{ route('university.index', ['slug' => $university->slug ])}}">Thông tin tuyển sinh</a></li>
                        <li class="list-inline-item list-item"><a href="{{ route('university.score', ['slug' => $university->slug]) }}">Điểm chuẩn</a></li>
                        <li class="list-inline-item item-active"><a href="{{ route('university.news', ['slug' => $university->slug]) }}">Tin tức</a></li>
                        <li class="list-inline-item list-item"><a href="{{ route('university.show_image', ['slug' => $university->slug]) }}">Hình ảnh</a></li>
                    </ul>
                </div>

            </div>
        </nav>
    </div>
    <div class="container">
        <div class="row detail-content">
            <div class="col-lg-4">
                <div class="card card-post-right mb-3">
                    <div class="card-header text-center">
                        Thông tin chung
                        <div class="mb-1"></div>
                        <div class="horizontal"></div>
                        {{--<div class="heading-line"></div>--}}
                    </div>
                    <div class="card-body info-university" style="color: black ">
                        <p class="item"><span>Mã trường: </span> {{ $university->code }}</p>
                        <p class="item"><span>Địa chỉ: </span><a href="#">{{ $university->address }}</a></p>
                        <p class="item"><span>Điện thoại: </span> {{ $university->phone }}</p>
                        <p class="item"><span>Ngày thành lập: </span>{{ $university->established }}</p>
                        <p class="item"><span>Loại hình: </span>{{ $university->type == 0 ? "Công lập" : "Dân lập" }}</p>
                        <p class="item"><span>Trực thuộc: </span>{{ $university->organization }}</p>
                        <p class="item"><span>Quy mô: </span> {{ $university->scale }}</p>
                        <p class="item"><span>Website: </span> <a href="http://{{ $university->website }}" target="_blank" rel="nofollow">{{ $university->website }}</a></p>
                        @if(!empty($university->google_map))
                            <div class="google_maps">
                                {!! $university->google_map !!}
                            </div>
                        @endif
                    </div>
                </div>
                @if(count($images) > 0)
                <div class="card card-post-right card-image">
                    <div class="row card-body">
                        @foreach( $images as $key => $image)
                            @if($key < 2 && count($images) >= 2)
                                <div class="col-md-6 mb-2 col-sm-4">
                                    <img src="{!! App\Core\MyStorage::get_image_link("public", $image->path,'sidebar_small') !!}" alt="{{ $image->title }}" width="100%" height="100%">
                                </div>
                            @else
                                <div class="col-md-12 col-sm-4"><img src="{!! App\Core\MyStorage::get_image_link("public", $image->path,'sidebar_large') !!}" alt="{{ $image->title }}" width="100%"></div>
                            @endif
                        @endforeach
                        <div class="text-center col-md-12 my-2 ">
                            <a href="{{ route('university.show_image', ['slug' => $university->slug]) }}">Xem thêm</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-lg-8">
                @foreach($posts as $post)
                <div class="col-lg-12 px-0" >
                    <a class="card card-post" href="{{ route('admission.university.post', ['slug' => $post->slug], false) }}" class="card-link" style="text-decoration: none; margin-top:0">
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

                            <p class="card-text mb-2">
                                {{ $post->description }}
                            </p>

                        </div>

                    </a>
                </div>
                    @endforeach
                <div class="mt-2">{{ $posts->links('frontend.includes.view_paginator') }}</div>
            </div>
            <div class="col-lg-8 ml-auto">
                <p class="text-dark">Hi vọng nội dung trên đây sẽ trở nên hữu ích cho các bạn!
                    <br><b>Cảm ơn các bạn đã theo dõi và ủng hộ!</b></p>
            </div>
        </div>
    </div>
    <div class="container list-posts-bottom">
        <div class="list-posts">
            <div class="heading d-flex">
                <div class="heading-title" style="margin-right: 60px">
                    <h2>Có thể bạn quan tâm</h2>
                </div>
            </div>
            <div class="horizontal"></div>
            <div class="heading-line"></div>
            <div class="mb-2"></div>

            <div class="row body">
                @if(count($bottom_posts) > 0)
                    @foreach($bottom_posts->chunk(2) as $desk)
                        <div class="col-lg-12">
                            <div class="card-deck">
                                @foreach($desk as $post)
                                    <a href="{{ route('admission.university.post', ['slug' => $post->slug], false) }}" class="card card-post smooth col-lg-6"
                                       @if($post->is_public != 1)
                                       rel="nofollow"
                                            @endif
                                    >
                                        <div class="card-body">
                                            <h2 class="card-title">
                                                {{ $post->title }}
                                            </h2>
                                            <div class="pb-1"></div>

                                            <p class="card-text">
                                                {{ $post->description }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                                @if($desk->count() < 2)
                                    <div class="col-sm-6"></div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                @else
                    Không có bài viết nào
                @endif
            </div>
        </div>
    </div>
    {{--</div>--}}

@endsection
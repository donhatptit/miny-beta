@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/admission_list_news.css")) !!}
    </style>
@endsection
@section('content')
    <div class="post-heading" style="margin-bottom: 25px;">
        <div class="container">

                @php
                    $breadcrumbs_render = Breadcrumbs::render('tin-tuyen-sinh');
                @endphp
            {{ $breadcrumbs_render or ''}}
            <div class="text-center">
                <h1 class="post-title">Tổng hợp những tin tức tuyển sinh mới nhất năm 2019</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="text-dark"><b><i>Loạt tin tức tuyển sinh 2019</i></b> được <b>Cunghocvui</b> sưu tầm và tổng hợp lại với mục đích giúp các bạn nắm được những thông tin cần thiết trước khi bước vào kì thi quan trọng trọng quãng đời học sinh. <br><i>Chúc các bạn sẽ có 1 kì thi suôn sẻ!</i></p>
            </div>
            <div class="col-lg-8">
                <div class="row body">
                    @if(count($posts) > 0)
                        @foreach($posts as $post)
                            <div class="col-lg-12">
                                <a class="card card-post smooth" href="{{ route('admission.university.post', ['slug' => $post->slug], false) }}" class="card-link">
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
                        @else
                        <p>Chưa có bài viết</p>
                        @endif
                </div>
                <div class="mt-2">{{ $posts->links('frontend.includes.view_paginator') }}</div>
            </div>
            <div class="col-lg-4 mt-3">
                <div class="card card-post-right">
                    <div class="card-header text-center">
                        Được quan tâm nhất
                        {{--<div class="heading-line"></div>--}}
                        <div class="horizontal"></div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="{{ route('admission.university.search') }}" class="card-link">
                                        <h3 style="font-weight: 400;">Điểm chuẩn các trường ĐH, CĐ 2010 - 2019</h3>
                                    </a>
                                </li>
                            <li class="list-group-item">
                                <a href="{{ route('admission.university.list') }}" class="card-link">
                                    <h3 style="font-weight: 400;">Thông tin tuyển sinh các trường ĐH, CĐ</h3>
                                </a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('admission.university.advice') }}" class="card-link">
                                    <h3 style="font-weight: 400;">Tư vấn tuyển sinh ĐH, CĐ 2019</h3>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card card-post-right mt-3">
                    <div class="card-header text-center">
                        Tin tức các trường
                        <div class="horizontal"></div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($universities as $university)
                            <li class="list-group-item">
                                <a href="{{ route('university.index', ['slug' => $university->slug]) }}" class="link-university">
                                    <h3 style="font-weight: 400;"><i class="icon-hand-point-right mr-2" style="color : #188ebb;"></i>{{ $university->vi_name }}</h3>
                                </a>
                            </li>
                                @endforeach
                        </ul>
                        <p class="text-right mb-0" style="font-size :15px"><a href="{{ route('admission.university.list') }}" class="link-university">Xem thêm <i class="fas fa-angle-double-right"></i></a></p>
                    </div>

                </div>
            </div>
            <div class="col-lg-12 mt-3">
                <p class="text-dark">Hi vọng những thông tin trên đây sẽ giúp ích cho các bạn.
                    <br><b>Cảm ơn các bạn đã theo dõi và ủng hộ!</b></p>
            </div>
        </div>
        <div class="col-lg-4">
            {{--<img src="{{ url('default/img/ads.png') }}">--}}
        </div>

    </div>
    </div>

@endsection
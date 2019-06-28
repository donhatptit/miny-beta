@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/admission_news_topic.css")) !!}
    </style>
@endsection
@section('content')
    <div class="post-heading" style="margin-bottom: 25px;">
        <div class="container">

            @php
                $breadcrumbs_render = Breadcrumbs::render('nganh-hoc', $topic);
            @endphp
            {{ $breadcrumbs_render or ''}}
            <div class="text-center">
                <h1 class="post-title">Tư vấn tuyển sinh ngành {{ $topic->name }}</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="text-dark"><b>Ngành {{ $topic->name }}</b> là một ngành đang được các bạn trẻ yêu thích hiện nay. Hãy cùng <b>Cunghocvui</b> tìm hiểu tất tần tật về ngành <b>{{ $topic->name }}</b> để có những lựa chọn chính xác nhất bạn nhé! </p>
            </div>
            <div class="col-lg-8">
                <div class="row body">
                    @if(count($posts) > 0)
                        @foreach($posts as $post)
                            <div class="col-lg-12">
                                <a class="card card-post smooth" href="{{ route('admission.university.post', ['slug' => $post->slug]) }}" class="card-link" rel="nofollow">
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
                    <div class="card-body" id="topic-right">
                        <ul class="list-group">
                            @foreach($topics_right as $topic)
                                <li class="list-group-item">
                                    <a href="{{ route('adminssion.university.topic', ['slug' => $topic['slug']]) }}" class="link-university">
                                        <h3 style="font-weight: 400;"><i class="icon-hand-point-right mr-2" style="color : #188ebb;"></i>{{ $topic->name }}</h3>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        @if(count($topics_right) >= 10)
                            <p class="text-right mb-0" style="font-size :15px"><a href="#" class="link-university" id="more-topic">Xem thêm <i class="fas fa-angle-double-right"></i></a></p>
                        @endif
                    </div>

                </div>
            </div>
            <div class="col-lg-12">
                <p class="text-dark">Rất mong sau khi tham khảo các bài viết về ngành <b>{{ $topic->name }}</b> của chúng tôi, các bạn sẽ có thêm những hiểu biết quan trọng về ngành này.
                    <br><b>Cảm ơn các bạn đã theo dõi và ủng hộ!</b></p>
            </div>
        </div>
        <div class="col-lg-4">
            {{--<img src="{{ url('default/img/ads.png') }}">--}}
        </div>

    </div>
    </div>

@endsection
@section('after-scripts')
    <script>
        $('#more-topic').click(function(e){
            $('#more-topic').hide(0);
            e.preventDefault();
            $("#topic-right").addClass('topic-scroll');
            $.get('{{ route('admission.load_more_topic') }}', '', function(data){
                console.log(data);
                for(i = 0; i < data.length; i ++){
                    $('#topic-right ul').append("<li class='list-group-item'><a href='" + data[i].link +"' class='link-university'><h3 style='font-weight: 400;'><i class='icon-hand-point-right mr-2' style='color : #188ebb;'></i>" + data[i].name + "</h3></a> </li>");
                }

            });
        });
    </script>
@endsection
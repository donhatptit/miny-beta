@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/admission_advice.css")) !!}


    </style>
@endsection
@section('content')
    <div class="post-heading" style="margin-bottom: 25px;">
        <div class="container">

            @php
                $breadcrumbs_render = Breadcrumbs::render('tu-van-tuyen-sinh');
            @endphp
            {{ $breadcrumbs_render or ''}}
            <div class="text-center">
                <h1 class="post-title">Đinh hướng ngành nghề - Tư vấn tuyển sinh Đại học Cao đẳng</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p class="text-dark">Quyết định chọn trường Đại học Cao đẳng nào theo học là 1 quyết định vô cùng quan trọng đối với những học sinh cuối cấp. Trên thực tế rất nhiều bạn học sinh còn băn khoăn chưa xác định được cho mình ngôi trường muốn theo học nhất. Biết được điều đó, <b>Cunghocvui</b> chúng tôi đã đem tâm huyết và kinh nghiệm của mình để dành tới cho các bạn những bài viết <b><i>tư vấn, định hướng ngành nghề</i></b>. Hi vọng sẽ giúp các bạn có được 1 sự lựa chọn chính xác! </p>
            </div>
            <div class="col-lg-8">
                <div class="row body">
                    @if(count($posts) > 0)
                        @foreach($posts as $post)
                            <div class="col-lg-12">
                                <a class="card card-post smooth" href="{{ route('admission.university.post', ['slug' => $post->slug], false) }}" class="card-link" rel="nofollow">
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
                                <a href="{{ route('admission.university.news') }}" class="card-link">
                                    <h3 style="font-weight: 400;">Tin tức tuyển sinh 2019</h3>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card card-post-right mt-3">
                    <div class="card-header text-center">
                        Các ngành Đại học, Cao đẳng
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
                <p class="text-dark">Rất mong sau khi tham khảo các bài viết của chúng tôi, các bạn sẽ rút ra cho mình một sự lựa chọn chính xác nhất!
                    <br><b>Cảm ơn các bạn đã theo dõi và ủng hộ!</b></p>
            </div>
        </div>
        <div class="col-lg-4">
            {{--<img src="{{ url('default/img/ads.png') }}">--}}
        </div>

    </div>
    <div class="container list-posts-bottom">
        @php
            if (!isset($col)){
                $col = 6;
            }

            $list_title = 'Có thể bạn quan tâm';
        @endphp
        <div class="list-posts">
            <div class="heading d-flex">
                <div class="heading-title" style="margin-right: 60px">
                    <h2>{{ $list_title or ''}}</h2>
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
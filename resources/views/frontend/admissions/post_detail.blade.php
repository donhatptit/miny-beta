@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/admission_post_detail.css")) !!}
        .topic-scroll{
            max-height:475px;
            overflow:hidden;
            overflow-y:scroll;
        }
    </style>
@endsection
@section('content')
    <div class="post-heading">
        <div class="container">
            @php
                $breadcrumbs_render = Breadcrumbs::render('bai-viet', $post);
            @endphp
            {{ $breadcrumbs_render or ''}}
            <div class="mt-1"></div>
            <div class="text-center">
                <h1 class="post-title">{{ $post->title or 'Chưa có title' }}</h1>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="row detail-content">
                <div class="col-lg-8">
                    <div class="card card-post-detail">

                        <div class="card-header">

                            <div class="d-flex bd-highlight mb-3 post-info">
                                <div class="bd-highlight" style="font-size:18px">
                                </div>
                            </div>


                        </div>

                        <div class="card-body">

                            {!! $post->content !!}
                        </div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="card card-post-right">
                        <div class="card-header text-center">
                            Bài viết liên quan
                            {{--<div class="heading-line"></div>--}}
                            <div class="horizontal"></div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="" class="card-link">
                                        <h3 style="font-weight: 400;">Điểm chuẩn các trường ĐH, CĐ 2010 - 2019</h3>
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
    </div>
@endsection

@section('after-scripts')
    <script type="text/x-mathjax-config">
    MathJax.Hub.Config({
      CommonHTML: { linebreaks: { automatic: true } },
      "HTML-CSS": { linebreaks: { automatic: true } },
             SVG: { linebreaks: { automatic: true } }
    });
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-MML-AM_CHTML' async></script>
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
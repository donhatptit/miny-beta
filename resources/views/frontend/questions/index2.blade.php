@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/flash_question_index2.css")) !!}
    </style>
@endsection
@section('content')
    @include('frontend.includes.title_header', [
        'title' => $title,
        'breadcrumbs_render' => Breadcrumbs::render('question-flash-two', $current_category),
        ])
    <div>
        <div class="container">
            <div class="row detail-content">
                <div class="col-lg-8">
                    <div class="card card-post-detail">
                        <div class="card-header">
                            <div class="d-flex bd-highlight mb-3 post-info">
                                {{--<div class="mr-auto bd-highlight">--}}
                                {{--<a href="#" class="card-link card-username">--}}
                                {{--{{ $post->user->name or 'Ẩn danh'}}--}}
                                {{--</a>--}}
                                {{--</div>--}}
                                {{--<div class="bd-highlights" style="color: #999999; font-size: 15px;">--}}
                                {{--@include('frontend.posts.post_info_number')--}}
                                {{--</div>--}}
                                @role('Administrator')
                                <div class="bd-highlights" style="color: #999999; font-size: 15px;">

                                    {{--@include('frontend.posts.status_question')--}}
                                </div>
                                @endrole

                            </div>
                        </div>
                        <div class="card-body">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 style="color:#FFA000;font-weight: 400;"class="py-2">{{ $question->question }}</h5>
                                        </div>
                                        <div class="card-footer text-muted bg-light ">
                                            <a class="btn btn-link p-0 w-100 click_advance " data-toggle="collapse" data-target="#collapseExample{{ $question->id }}" aria-expanded="true" aria-controls="collapseExample{{ $question->id }}" style="color:#00B28B"><span class="float-left" style="color: #13a9e3;"><i class="fas fa-search result"></i> Đáp án</span><span class="float-right"><i class="fas fa-chevron-down"></i></span></a>

                                        </div>
                                        <div class="collapse" id="collapseExample{{ $question->id }}">
                                            <div class="card card-body border-0">
                                                {{ $question->answer }}
                                            </div>
                                        </div>
                                    </div>
                        </div>
                        <div class="card-footer text-muted">
                            @if(isset($question_preview))
                            <div class="float-left">
                                <a href="{{route('frontend.question.detail', ['code'=>$question_preview->code,'slug' => $question_preview->slug])}}" class="card-link"><span class="text-primary"><i class="fas fa-angle-double-left"></i></i> Câu trước</span></a>
                            </div>
                            @endif
                            @if(isset($question_next))
                            <div class="float-right">
                                <a href="{{route('frontend.question.detail', ['code'=>$question_next->code,'slug' => $question_next->slug])}}" class="card-link"><span class="text-primary">Câu tiếp <i class="fas fa-angle-double-right"></i></span></a>
                            </div>
                                @endif

                        </div>

                    </div>
                    <div class="col-lg-12">
                        <div class="fb-comments" data-href="{{ route('frontend.question.detail',['code'=>$question->code,'slug'=>$question->slug]) }}" data-numposts="3" width="100%"></div>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="card card-post-right">
                        <div class="card-header">
                            Bạn muốn xem thêm với
                            <div class="heading-line"></div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($more_question as $question)
                                    <li class="list-group-item">
                                        <a href="{{ route('frontend.question.detail',['code'=>$question->code,'slug'=>$question->slug]) }}" class="card-link">
                                            <h3>{{ $question->question }}</h3>
                                        </a>
                                    </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="d-none d-md-block">
                        {{--<img src="{{ url('default/img/ads.png') }}" width="100%" style="margin-top: 50px">--}}
                    </div>
                </div>

            </div>
        </div>
        <div class="container list-posts-bottom">
            {{--@include('frontend.includes.list_posts', ['list_title' => 'Có thể bạn quan tâm', 'list_posts' =>''])--}}
        </div>
    </div>

@endsection


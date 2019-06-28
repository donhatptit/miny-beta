@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/flash_question_index1.css")) !!}
    </style>
@endsection
@section('content')
    @if($current_category->isRoot())
        @include('frontend.includes.title_header', [
            'title' => $title,
            'breadcrumbs_render' => Breadcrumbs::render('question-flash', $current_category),
            ])
    @elseif($current_category->depth == 1)

        @include('frontend.includes.title_header', [
          'title' => $title,
          'breadcrumbs_render' => Breadcrumbs::render('question-flash-one', $current_category),
          ])
    @else
        @include('frontend.includes.title_header', [
        'title' => $title,
        'breadcrumbs_render' => Breadcrumbs::render('question-flash-two', $current_category),
        ])
    @endif
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

                                    @include('frontend.questions.status_question')
                                </div>
                                @endrole

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <p>{!! $first_content !!} </p>
                                <ul class="list-unstyled">
                                    @foreach($list_category as $category)
                                        @if($current_category->isLeaf())
                                            <li class="my-1"><a href="{{ route('frontend.question.detail',['code'=>$category->code,'slug'=>$category->slug]) }}" class="link-item-post"><b style="font-weight: 500;">{{ $title_content . $category->question  }}</b></a></li>
                                            @else
                                            <li class="my-1"><a href="{{route('frontend.question', ['code'=>$category->code,'slug' => $category->slug])}}" class="link-item-post"><b style="font-weight: 500;">{{ $title_content }}{{  $category->name  }}</b></a></li>
                                        @endif
                                    @endforeach
                                </ul>
                                <p> {!! $end_content !!}</p>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-12">
                        <div class="fb-comments" data-href="{{ route('frontend.question.detail',['code'=>$current_category->code,'slug'=>$current_category->slug]) }}" data-numposts="3" width="100%"></div>
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
                                @foreach($list_category_right as $category)
                                    <li class="list-group-item">
                                        <a href="{{ route('frontend.question',['code'=>$category->code,'slug'=>$category->slug]) }}" class="card-link">
                                            <h3>{{ $title_right . $category->name }}</h3>
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
@section('after-scripts')
    <script src="{{ url('frontend/js/save_status_question.js') }}"></script>
@endsection


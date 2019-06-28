@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/search_result.css")) !!}
    </style>
@endsection
@section('content')
    @include('frontend.includes.title_header', [
        'title' => /*$count_post.*/' KẾT QUẢ CHO TỪ KHÓA '."\"".$key."\"",
        'breadcrumbs_render' => Breadcrumbs::render('result-search', $key),
        ])
    <div class="container" style="margin-bottom: 50px">
        <div class="row">
            <div class="col-lg-8">
                {{--@include('frontend.includes.list_posts', [--}}
                    {{--'list_title' => 'Kết quả tìm kiếm',--}}
                    {{--'list_posts' => $cate_posts,--}}
                    {{--'col' => 12--}}
                {{--])--}}
                <div class="list-posts">
                    <div class="heading d-flex">
                        <div class="heading-title" style="margin-right: 60px">
                            <h2>Kết quả tìm kiếm</h2>
                        </div>
                        <div class="watch-all-btn ml-auto p-2">
                            <a href="#">
                                Xem tất cả <i class="fas fa-caret-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="heading-line"></div>
                    <div class="row body">
                        @if(count($cate_posts) > 0)
                            @foreach($cate_posts as $post)
                                <div class="
                                        col-lg-12
                                        ">
                                    {{--@include('frontend.includes.post_item', ['$post' => $post])--}}
                                    <div class="card card-post">
                                        <div class="card-body">
                                            <h2 class="card-title">
                                                <a href="{{ route('frontend.post.detail', [
                                                        'slug' => $post->slug
                                                    ], false) }}" class="card-link">
                                                    {{ $post->title }}
                                                </a>
                                            </h2>
                                            <div class="d-flex bd-highlight mb-3 post-info">
                                                <div class="mr-auto bd-highlight">
                                                </div>
                                                <div class="bd-highlight" style="color: #999999; font-size: 13px;">
                                                </div>
                                            </div>

                                            <p class="card-text">
                                                {{ $post->description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            Không có bài viết nào
                        @endif
                    </div>
                </div>
                <div class="d-block mx-auto">
                </div>
            </div>
                <div class="col-lg-4 mt-3">
                    <div class="card card-post-right">
                        <div class="card-header">
                            Bạn muốn tìm thêm với
                            <div class="heading-line"></div>
                        </div>
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            <div class="col-lg-4 d-none d-md-block">
            </div>
        </div>
    </div>
@endsection
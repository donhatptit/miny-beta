@extends('frontend.layouts.master')
@section('content')
    <div class="post-heading" style="margin-bottom: 25px;">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Library</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data</li>
                </ol>
            </nav>
            {{ Breadcrumbs::render('home1') }}
            <div class="text-center">
                <h1 class="post-title">{{ $title or 'Chưa có title' }}</h1>
            </div>
        </div>
    </div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-post-detail">
                        <div class="card-header">
                            <div class="d-flex bd-highlight mb-3 post-info">
                                <div class="mr-auto bd-highlight">
                                    <a href="#" class="card-link card-username">
                                        {{ $post->user->name }}
                                    </a>
                                </div>
                                <div class="bd-highlight" style="color: #999999; font-size: 13px;">
                                    @include('frontend.includes.post_info_number')
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
                        <div class="card-header">
                            Bạn muốn xem thêm với
                            <div class="heading-line"></div>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($right_posts as $post)
                                    <li class="list-group-item">
                                        <a href="" class="card-link">
                                            {{ $post->title }}
                                        </a>
                                    </li>

                            @endforeach

                        </div>
                    </div>
                    <div>
                        <img src="{{ url('default/img/ads.png') }}" width="100%" style="margin-top: 50px">
                    </div>
                </div>
                <div class="" style="margin-bottom: 90px; margin-top: 30px">
                    @include('frontend.includes.list_posts', ['list_title' => 'Có thể bạn quan tâm', 'list_posts' => $bottom_posts])
                </div>
            </div>
        </div>

        @endsection

        @section('after-scripts')
            <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-MML-AM_CHTML' async></script>
@endsection
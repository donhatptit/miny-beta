@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/home.css")) !!}
    </style>
@endsection
@section('content')
    <div style="background: #f1f1f1">
        <div class="container" style="margin-bottom: 50px;">
            <div class="d-none d-lg-block">
                <a href="{{ config('app.app_mobile.link') }}">
                    <img style="width:100%;" src="{{ url('default/img/banner_app.png') }}" alt="Tải app CungHocVui miễn phí để xem offline">
                </a>
            </div>
            <div class="d-block d-lg-none" style="position: relative" >
                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ config('app.app_mobile.link') }}">
                        <img style="width:100%;" src="{{ url('default/img/banner_app_2.png') }}">
                    </a>
                </div>
            </div>
            @include('frontend.home.news')
            @include('frontend.home.university')
            @foreach($cates_posts as $cate_posts)
                <div class="list-posts">
                    <div class="heading d-flex">
                        <div class="heading-title" style="margin-right: 60px">
                            <h2>{{ $cate_posts['category']->name or ''}}</h2>
                        </div>
                        <div class="hedding-button d-none d-md-block">
                            <?php $i = 0; ?>
                            @foreach($cate_posts['category']->children as $child)
                                @if($i > 3)
                                    @break
                                @endif
                                <a href="{{ $child->link }}" class="btn  btn-outline-category">
                                    {{ $child->name }}
                                    <?php $i++; ?>
                                </a>

                            @endforeach
                        </div>
                        <div class="watch-all-btn ml-auto p-2">
                            <a href="{{ $cate_posts['category']->link or '#' }}">
                                Xem tất cả <i class="fa fa-caret-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="horizontal"></div>
                    <div class="heading-line"></div>
                    <div class="row body">
                        @if(count($cate_posts['posts']) > 0)
                            @foreach($cate_posts['posts']->chunk(2) as $desk)
                                <div class="col-lg-12">
                                <div class="card-deck">
                                    @foreach($desk as $post)
                                        <a href="{{ route('frontend.post.detail', ['slug' => $post->slug
                                                    ], false) }}" class="card card-post smooth col-lg-6" >
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
                                </div>
                            </div>
                            @endforeach
                        @else
                            Không có bài viết nào
                        @endif
                    </div>
                    <div class="mb-3"></div>
                </div>
            @endforeach
        </div>
    </div>
<div id="intro" class="d-none d-md-block">
    <div class="container">
        <div class="heading text-center">
            <h2>Chúng tôi cung cấp cho bạn</h2>
        </div>
        <div class="row">
            <div class="col-xs-4 col-sm-4">
                <div class="intro-item text-center">
                    <div class="image">
                        <img class="" src="{{ url('default/img/intro_free.png') }}" alt="Card image cap">
                    </div>
                    <h5 class="intro-heading">Tài nguyên học tập miễn phí</h5>
                    <p class="intro-content">Cung cấp hơn 1 triệu tài nguyên học tập miễn phí trên tất cả các lớp, các môn</p>
                </div>
            </div>
            <div class="col-xs-4 col-sm-4">
                <div class="intro-item text-center">
                    <div class="image">
                        <img class="" src="{{ url('default/img/update.png') }}" alt="Card image cap">
                    </div>
                    <h5 class="intro-heading">Nội dung cập nhật liên tục</h5>
                    <p class="intro-content">
                        Nội dung trên web được cập nhật liên tục hàng ngày bởi đội ngũ giáo viên giỏi
                    </p>
                </div>
            </div>
            <div class="col-xs-4 col-sm-4">
                <div class="intro-item text-center">
                    <div class="image">
                        <img class="" src="{{ url('default/img/intro_friendly.png') }}" alt="Card image cap">
                    </div>
                    <h5 class="intro-heading">Giao diện thân thiện</h5>
                    <p class="intro-content">
                        Trang web luôn lắng nghe góp ý để đổi mới trang web phục vụ bạn đọc cả nước
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('frontend.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ url('frontend/plugins/PhotoSwipe/photoswipe.css') }}">
    <link rel="stylesheet" href="{{ url('frontend/plugins/PhotoSwipe/default-skin/default-skin.css') }}">
    <style>
        {!! file_get_contents(public_path("frontend/css/university_image.css")) !!}
    </style>
    @endsection

@section('content')
    <div class="post-heading" style="margin-bottom: 0px;">
        <div class="container">

            @php
                $breadcrumbs_render = Breadcrumbs::render('thong-tin-truong', $university, 'Hình ảnh');
            @endphp
            {{ $breadcrumbs_render or ''}}
            <div class="text-center">
                <h1 class="post-title" style="margin-bottom:0">Tổng hợp hình ảnh trường {{ $university->vi_name }}</h1>
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
                <div class="col-md-8 col-sm-12 ml-auto">
                    <ul class="list-unstyled list-inline list-menu text-center">
                        <li class="list-inline-item list-item"><a href="{{ route('university.index', ['slug' => $university->slug ])}}">Thông tin tuyển sinh</a></li>
                        <li class="list-inline-item list-item"><a href="{{ route('university.score', ['slug' => $university->slug]) }}">Điểm chuẩn</a></li>
                        <li class="list-inline-item list-item"><a href="{{ route('university.news', ['slug' => $university->slug]) }}">Tin tức</a></li>
                        <li class="list-inline-item item-active"><a href="{{ route('university.show_image', ['slug' => $university->slug]) }}">Hình ảnh</a></li>
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
                <div class="card card-post-right card-image">
                    <div class="row card-body">
                        @foreach( $images as $key => $image)
                            @if($key < 3)
                                @if($key < 2 && count($images) >= 2)
                                    <div class="col-md-6 mb-2 col-sm-4">
                                        <img src="{!! App\Core\MyStorage::get_image_link("public", $image->path,'sidebar_small') !!}" alt="{{ $image->title }}" width="100%" height="100%">
                                    </div>
                                @else
                                    <div class="col-md-12 col-sm-4">
                                        <img src="{!! App\Core\MyStorage::get_image_link("public", $image->path,'sidebar_large') !!}" alt="{{ $image->title }}" width="100%">
                                    </div>
                                @endif
                            @endif
                        @endforeach
                        <div class="text-center col-md-12 my-2 ">
                            <a href="{{ route('university.show_image', ['slug' => $university->slug]) }}">Xem thêm</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-8" style="background-color: white;border:1px solid #d0d0d0; border-radius : 5px">
                <div class="my-gallery row" style="padding:15px">
                    @foreach($images as $image)
                    <figure itemprop="associatedMedia" class="col-sm-6 col-md-4 text-center mt-1 boder-image" >
                        <a href="{{ config('app.url') . '/' . $image->path }}" itemprop="contentUrl" data-size="{{ $image->size }}" class="img-slide">
                            <img src="{!! App\Core\MyStorage::get_image_link("public", $image->path,'image_show_small') !!}" width="220px"; height="200px" style="padding:5px;object-fit :cover ; border-radius: 10px; border:1px solid #e7eaec4f" />
                        </a>
                        <figcaption itemprop="caption description" class="title-img">{{ $image->title }}</figcaption>

                    </figure>
                    @endforeach

                </div>
            </div>
                <!-- Root element of PhotoSwipe. Must have class pswp. -->
                <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="pswp__bg"></div>
                    <div class="pswp__scroll-wrap">
                        <div class="pswp__container">
                            <div class="pswp__item"></div>
                            <div class="pswp__item"></div>
                            <div class="pswp__item"></div>
                        </div>
                        <div class="pswp__ui pswp__ui--hidden">
                            <div class="pswp__top-bar">
                                <div class="pswp__counter"></div>

                                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                                <button class="pswp__button pswp__button--share" title="Share"></button>

                                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                                <div class="pswp__preloader">
                                    <div class="pswp__preloader__icn">
                                        <div class="pswp__preloader__cut">
                                            <div class="pswp__preloader__donut"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                <div class="pswp__share-tooltip"></div>
                            </div>

                            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                            </button>

                            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                            </button>

                            <div class="pswp__caption">
                                <div class="pswp__caption__center"></div>
                            </div>

                        </div>

                    </div>

                </div>
            <!-- End PhotoSwipe . -->
            </div>
        {{--</div>--}}
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
@push('after-scripts')
    <script src="{{ url('frontend/plugins/PhotoSwipe/photoswipe.min.js') }}"></script>
    <script src="{{ url('frontend/plugins/PhotoSwipe/photoswipe-ui-default.min.js') }}"></script>
    <script src="{{ url('frontend/js/slide_image_photoswipe.js')}}"></script>
    @endpush
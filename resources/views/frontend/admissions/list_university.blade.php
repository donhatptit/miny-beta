@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/admission_list_university.css")) !!}
    </style>
@endsection
@section('content')
    <div class="post-heading" style="margin-bottom: 0px;">
        <div class="container">

                @php
                    $breadcrumbs_render = Breadcrumbs::render('danh-sach-truong');
                @endphp
            {{ $breadcrumbs_render or ''}}
            <div class="text-center">
                <h1 class="post-title" style="margin-bottom:0">Thông tin bạn cần biết về các trường đại học cao đẳng trên cả nước</h1>
            </div>
        </div>
    </div>


    @include('frontend.admissions.filter',['locations' => $locations])
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-12">
                <p class="text-dark">Dưới đây là danh sách các trường Đại học Cao đẳng, Học viện, Trung cấp trên cả nước. <b>Cunghocvui</b> đã tổng hợp lại các thông tin về những trường đó.<br> <i>Hãy click vào ngôi trường mà bạn muốn tìm hiểu và theo dõi nhé!</i></p>
            </div>
            <div class="col-lg-8">
                <div class="row body">
                    @foreach($universities as $university)
                            <div class="col-lg-12 card smooth p-3 mb-3">
                                <div class="media " style="min-height:110px">
                                    <div class="mr-3">
                                        <a href="{{ route('university.index', [ 'slug' => $university->slug]) }}"  class="align-self-start border-image " style="background-image: url({!! App\Core\MyStorage::get_image_link("public", $university->avatar,'small') !!});width:120px; height:100px;display:block;background-size:cover; background-position:center" alt="{{ $university->vi_name }})"></a>
                                        <p class="mb-0 mt-1 text-center key-word">{{ $university->keyword }}</p>
                                    </div>

                                    <div class="media-body">
                                        <a href="{{ route('university.index', [ 'slug' => $university->slug]) }}" class="card-link"><h2 class="mt-0 media-title" style="font-size:18px; color:#14a9e3">{{ $university->vi_name }}</h2></a>
                                        <div class="row" style="font-size:14px;color:#353535">
                                            <div class="col-md-7 u-address">
                                                <p class="my-1 media-title"><i class="icon-thumb-tack" style="font-size:10px;margin-right: 5px">&nbsp;</i>{{ $university->address }}</p>
                                                <p class="my-1"><i class="icon-phone" style="font-size:10px; margin-right: 5px">&nbsp</i>{{ $university->phone }}</p>
                                                @if(!empty($university->scale))
                                                <p class="my-1 media-title"> <i class="icon-users" style="margin-right: 5px">&nbsp;</i>{{ $university->scale }}</p>
                                                    @endif
                                            </div>
                                            <div class="col-md-5 u-description">
                                                <p class="description-media m-0">{{ $university->description }}</p>
                                                <a href="{{ route('university.index', [ 'slug' => $university->slug]) }}" class="read-more">Xem thêm <i class="fas fa-angle-double-right" style="font-size:12px"></i></a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
                <div class="mt-2">{{ $universities->appends([
                    'province' => request()->get('province'),
                    'district'  => request()->get('district'),
                    'type'      => request()->get('type'),
                ])->links('frontend.includes.view_paginator') }}</div>
            </div>

            <div class="col-lg-4">
                <div style="text-align: center; margin-bottom: 20px;">
                    <a href="{{ config('app.app_mobile.link') }}">
                        <img width="100%" src="{{ url('default/img/banner_detail.jpg') }}" alt="Tải app CungHocVui miễn phí để xem offline">
                    </a>
                </div>
                <div class="card card-post-right mb-3">
                    <div class="card-header">
                        Được quan tâm nhất
                        <div class="mb-1"></div>
                        <div class="horizontal"></div>
                        <div class="heading-line"></div>
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
                            <li class="list-group-item">
                                <a href="{{ route('admission.university.advice') }}" class="card-link">
                                    <h3 style="font-weight: 400;">Tư vấn tuyển sinh ĐH, CĐ 2019</h3>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-none d-md-block">
                </div>
            </div>
            <div class="col-lg-12 mt-3">
                <p class="text-dark">Hi vọng nội dung trên đây sẽ trở nên hữu ích cho các bạn!<br><b>Cảm ơn các bạn đã theo dõi và ủng hộ!</b></p>
            </div>
        </div>
        <div class="col-lg-4">
            {{--<img src="{{ url('default/img/ads.png') }}">--}}
        </div>

    </div>
    </div>

@endsection
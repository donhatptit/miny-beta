@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/admission_home.css")) !!}
    </style>
    @endsection
@section('content')
    <div class="post-heading" style="margin-bottom:0; min-height:70px">
        <div class="container">
            @php
                $breadcrumbs_render = Breadcrumbs::render('tuyen-sinh');
            @endphp
            {{ $breadcrumbs_render or ''}}

            <div class="text-center">
                <h1 class="post-title" style="padding-bottom:15px">Tổng hợp các thông tin tuyển sinh hữu ích không thể bỏ qua</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12 text-left" style="color: black">
            <p class="my-0">Với sứ mệnh trở thành nơi cung cấp cho các bạn học sinh, sinh viên toàn bộ kiến thức từ tự nhiên tới xã hội, <b>Cunghocvui</b> đã nghiên cứu và tổng hợp lại các thông tin liên quan đến vấn đề <b>tuyển sinh</b> với mong muốn cung cấp cho các bạn những thông tin <b><i>hữu ích và chính xác nhất</i></b>. Giúp các bạn có một sự lựa chọn đúng đắn nhất trong ngưỡng cửa quan trọng của cuộc đời.</p>
        </div>
    </div>

    <div class="container d-flex justify-content-center">
        <div class="col-md-8 row my-3 col-sm-12">
            <div class="col-md-6 p-2">
                <a href="{{ route('admission.university.list') }}" class="admission-item d-flex">
                    <i class="icon-building icon"></i>
                    <span class="number">704</span>
                    <span class="title">THÔNG TIN TRƯỜNG</span>
                </a>
            </div>
            <div class="col-md-6 p-2">
                <a href="{{ route('admission.university.advice') }}" class="admission-item d-flex">
                    <i class="icon-user-graduate icon"></i>
                    <span class="number">204</span>
                    <span class="title">TƯ VẤN TUYỂN SINH</span>
                </a>
            </div>
            <div class="col-md-6 p-2">
                <a href="{{ route('admission.university.search') }}" class="admission-item d-flex" >
                    <i class="icon-award icon"></i>
                    <span class="number">5562</span>
                    <span class="title">ĐIỂM CHUẨN</span>
                </a>
            </div>
            <div class="col-md-6 p-2">
                <a href="{{ route('admission.university.news') }}" class="admission-item d-flex">
                    <i class="icon-pencil-alt icon"></i>
                    <span class="number">1000</span>
                    <span class="title">TIN TỨC TUYỂN SINH</span>
                </a>
            </div>
            </div>
        </div>
    <div class="container pb-2">
        <div class="col-md-12 text-left" style="color: black">
            <p>Hi vọng <b>Cunghocvui</b> sẽ trở thành người bạn đồng hành với bạn trên cả quãng đường chinh phục kiến thức.<br><b>Cảm ơn các bạn đã theo dõi và ủng hộ!</b></p>
        </div>
    </div>
    </div>

    <div id="intro" class="d-none d-md-block" style="margin-top: 30px;">
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
@extends('frontend.layouts.master')
@section('content')
    <div class="post-heading" style="margin-bottom: 25px;">
        <div class="container">
            @php
                $breadcrumbs_render = Breadcrumbs::render('intro');
            @endphp
            {{ $breadcrumbs_render or ''}}
            <div class="text-center">
                <h1 class="post-title">Giới thiệu Cunghocvui</h1>
            </div>
        </div>
    </div>
    <div class="container" style="/*background-color:white;*/ color:black; margin-bottom: 50px;">
        <div class="landing-body">
            <div class="row row-lan">
                <div class="col-md-6">
                    <div class="pic"><img src="http://miny.vn/assets/img/landing/lp_img_01.png" class="img-responsive"></div>
                </div>
                <div class="col-md-6">
                    <div class="content">
                        <h2 class="title">Sứ mệnh</h2>
                        <p>Cunghocvui ra đời với mục đích cung cấp cho các bạn học sinh, sinh viên - những mầm non tương lai của đất nước một nền tảng kiến thức thật vững chắc để đạt kết quả cao trong quá trình học tập, vận dụng tốt vào đời sống xã hội. Chúng tôi đã biên soạn, tổng hợp toàn bộ lời giải các bộ môn từ lớp 2 đến lớp 12, những lời soạn văn hay nhất, lời giải hay nhất và phong phú nhất theo đúng chuẩn và sát với khung đào tạo của Bộ giáo dục và đào tạo. Bên cạnh đó, chúng tôi còn cung cấp tất cả các thông tin liên quan đến học tập, các mẹo học tập để nhớ kiến thức lâu hơn, tổng hợp các đề thi đại học giúp cho các sĩ tử ôn luyện hiệu quả và các thông tin bổ ích khác. Đem đến cho người dùng trải nghiệm tốt nhất với thông tin hữu ích nhất.</p>
                    </div>
                </div>
            </div>
            <div class="row row-lan">
                <div class="col-md-6">
                    <div class="content" style="margin-top : 100px">
                        <h2 class="title">Giá trị cốt lõi</h2>
                        <p> Mong muốn tạo ra một cộng đồng học tập, là nơi mọi kiến thức và thông tin liên quan đến học tập có thể được chia sẻ rộng rãi và hữu ích nhất</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pic"><img src="http://miny.vn/assets/img/landing/lp_img_02.png" class="img-responsive"></div>
                </div>
            </div>
        </div>
    </div>
    @endsection
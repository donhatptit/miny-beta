@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/admission_university.css")) !!}

    </style>
    @endsection
@section('content')
    <div class="post-heading" style="margin-bottom: 0px;">
        <div class="container">

            @php
                $breadcrumbs_render = Breadcrumbs::render('tra-cuu-diem-chuan');
            @endphp
            {{ $breadcrumbs_render or ''}}
            <div class="text-center">
                <h1 class="post-title" style="margin-bottom:0">Tra cứu điểm chuẩn các trường Đại học - Cao đẳng trên cả nước chính xác nhất</h1>
            </div>
        </div>
    </div>

    @include('frontend.admissions.filter')
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-12">
                <p class="text-dark">Tổng hợp điểm chuẩn của các trường trên cả nước qua từng năm <b><i>đầy đủ và chính xác nhất</i></b>. Hãy chọn cho mình 1 ngôi trường yêu thích và cùng chúng tôi xem thông tin điểm chuẩn của trường đó nhé!</p>
            </div>
            <div class="col-lg-8 mb-3">
                <div class="body">
                       <div class="col-lg-12" style="height:560px; overflow:hidden; overflow-y:scroll;background-color:white; border-radius : 10px;border: 1px solid #d0d0d0;" id="style-2">
                       <ul class="list-unstyled" style="padding:15px" >
                           @foreach($universities as $university)
                               <li class="list-university"><a href="{{ route('university.score', ['slug' => $university->slug]) }}">{{ $university->vi_name }} - <span class="keyword" style="font-size:20px !important;">{{ $university->keyword }}</span></a></li>
                               @endforeach
                       </ul>
                   </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div style="text-align: center; margin-bottom: 20px;">
                    <a href="#">
                        <img width="100%" src="{{ url('default/img/banner_detail.jpg') }}" alt="Tải app CungHocVui miễn phí để xem offline">
                    </a>
                </div>
                <div class="card card-post-right">
                    <div class="card-header">
                        Được quan tâm nhất
                        <div class="mb-1"></div>
                        <div class="horizontal"></div>
                        <div class="heading-line"></div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
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
            <div class="col-lg-12">
                <p class="text-dark">Hi vọng nội dung trên đây sẽ trở nên hữu ích cho các bạn!
                    <br><b>Cảm ơn các bạn đã theo dõi và ủng hộ!</b></p>
            </div>
        </div>
        <div class="col-lg-4">
            {{--<img src="{{ url('default/img/ads.png') }}">--}}
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
    {{--</div>--}}

@endsection
@section('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script>
        // thuc hien filter
        $('#province').on('change', function(){
            fillDistrict();

        });


        function fillDistrict(){
            var province_id = $('#province').val();
            $.get('{{ route('admission.university.filter_district') }}',
                { 'province_id' : province_id },
                function(data){
                    old_district = $('#district').attr('old-value');
                    $('#district').find('option')
                        .remove()
                        .end().append('<option value= "" selected>Quận huyện</option>');
                    for (let i = 0; i < data.length; i++) {

                        $('#district').append($('<option>',
                            {
                                value: data[i].id,
                                text: data[i].name,
                            }));
                        if (data[i].id == old_district) {
                            $('#district').val(old_district).trigger('change.select2');
                        }
                    }
                });
        }
    </script>
@endsection
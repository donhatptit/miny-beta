@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/detail_post.css")) !!}
        {!! file_get_contents(public_path("frontend/css/category_sidebar.css")) !!}

    </style>
@endsection
@section('content')
<div class="post-heading">
    <div class="container">
        @php
            $breadcrumbs_render = Breadcrumbs::render('post', $post, $category, $category_subject);
        @endphp
        {{ $breadcrumbs_render or ''}}
        <div class="mt-1"></div>
        <div class="text-center">
            <h1 class="post-title">{{ $post->title or 'Chưa có title' }}</h1>
        </div>
    </div>
</div>
<div>
    <div class="container-fluid">
        <div class="row detail-content">
            <div class="col-lg-9 col-md-12 row post-content">
                @if(!empty($categories_sidebar))
                <div class="col-lg-4" style="padding-right:0">
                    <aside class="sidebar-left" id="sidebar_content_post">
                        <div id="close_sidebar">
                            <span class="btn-close-side-right">
                                <i class="fas fas-times"></i>
                            </span>
                        </div>
                        <ul class="list-menu-left">
                            @foreach($categories_sidebar as $cate_sidebar)
                                <a href="{{ route('frontend.category.index', ['slug' => $cate_sidebar->slug]) }}" class="{{ $cate_sidebar->slug == $category->slug ? "sidebar-active" : "" }}"><li class="{{ $cate_sidebar->depth <= 2 ? "cate-heading" : "cate-child" }} {{ $cate_sidebar->depth == 1 ? "subject-heading" : "" }} " > {{ $cate_sidebar->name }}</li></a>
                            @endforeach
                        </ul>
                    </aside>

                </div>
                @endif

                <div class="{{ empty($categories_sidebar) ? "col-lg-12" : "col-lg-8" }} col-sm-12 section-post">
                    <div class="card card-post-detail">
                        @role('Administrator')
                        <div class="card-header">
                            <div class=" mr-auto bd-highlights" style="color: #999999; font-size: 15px;">
                                <span>ID: {{ $post->id }}</span>
                                <span class="px-3 font-weight-bold">Google : </span>
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown"
                                     name ="{{ route('backend.action.post') }}" value ="{{ $post->id }}" id="btn-route">
                                    <button type="button" class="btn btn-sm btn-primary"
                                            value ="{{  $post->is_public }}" id="btn_public">
                                        {{ $post->is_public == 1 ? 'Đã hiển thị ' : 'Ẩn' }}
                                    </button>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-sm"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                style="background-color: #FFA000">
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="font-size:13px;">
                                            @if($post->is_public ==0)
                                                <a class="dropdown-item action_public" href="#" value = "1" >Hiển thị</a>
                                            @else
                                                <a class="dropdown-item action_public" href="#" value ="0" >Ẩn</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <span class="px-3 font-weight-bold">Trạng thái</span>
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <button type="button" class="btn btn-primary btn-sm" id="btn_approve"
                                            value="{{ $post->is_approve }}">
                                        @if ($post->is_approve == 1)
                                            {{ 'Đã duyệt' }}
                                        @elseif ($post->is_approve == 0)
                                            {{ 'Chưa duyệt' }}
                                        @else
                                            {{'Không duyệt'}}
                                        @endif

                                    </button>
                                    <div class="btn-group" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-sm"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                style="background-color: #FFA000">
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="font-size:13px">
                                            @if($post->is_approve == 0)
                                                <a class="dropdown-item action_post" value ="1" href="#">Duyệt</a>
                                                <a class="dropdown-item " href="#reason" data-toggle="modal" data-target="#reason">
                                                    Không duyệt
                                                </a>
                                            @elseif($post->is_approve == 1)
                                                <a class="dropdown-item action_post" value ="0" href="#" >Bỏ duyệt</a>
                                            @elseif($post->is_approve == -1)
                                                <a class="dropdown-item action_post" value ="1" href="#">Duyệt lại</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-sm btn-info ml-3" id="save_action" disabled="true" data-toggle="modal" data-target="modal">Lưu</button>
                                <button class="btn btn-sm btn-info ml-3" id="save_all_action" data-toggle="modal" data-target="modal">Duyệt hết</button>

                            {{--Hộp thoại popup lý do --}}

                            <!-- Modal -->
                                <div class="modal fade show" id="reason" tabindex="-1" role="dialog" aria-labelledby="reason" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('backend.action.post') }}" method="POST">
                                                {{ csrf_field() }}
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Lý do</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="text" value="-1" name="action" hidden>
                                                        <input type="text" value ="{{ $post->id }}" name="id_post" hidden>
                                                        <textarea class="form-control" rows="5" id="comment" name="reason"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endrole
                        @if($subject == 'ngu-van')
                            <div class="card-header">
                                <div class="bd-highlight" style="font-size:18px">
                                    <span class="badge badge-pill badge-success" style="font-weight:500;padding:5px 7px;background-color:#7088a9">{{ number_format($post->count_word) }} từ</span>
                                    @foreach($post->kinds as $kind)
                                        <span class="badge badge-pill" style=" font-weight:500;padding:5px 7px; background-color:{{ $kind->color }};color:white;">{{ $kind->name }}</span>

                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="card-body">
                            @if( $post->subject )
                                <p style="color: #14a9e3;"><strong>Đề bài</strong></p>
                                {!! $post->subject !!}
                            @endif
                            <p  style="color: #14a9e3;"><strong>Hướng dẫn giải</strong></p>
                            @if(count($post->post_answer) > 0)
                                <p><strong><i>Cách 1:</i></strong></p>
                            @endif
                            {!! $post->content !!}
                            @if(count($post->post_answer) > 0)
                                @foreach($post->post_answer as $k => $p)
                                    <p><strong><i>Cách {{ $k + 2 }}:</i></strong></p>
                                    {!! $p->content !!}
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-12">
                        @include('frontend.social.like_share', ['data_url' => route('frontend.post.detail',['slug'=>$post->slug])])
                        <div class="fb-comments" data-href="{{ route('frontend.post.detail',['slug'=>$post->slug]) }}" data-numposts="3" width="100%"></div>
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
                                                <a href="{{ route('frontend.post.detail', ['slug' => $post->slug
                                                        ], false) }}" class="card card-post smooth col-lg-6"
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
            </div>
            <div class="col-lg-3 sidebar-right">
                <div class="card card-post-right" style="margin-bottom: 20px">
                    <div class="card-header">
                        Bạn muốn xem thêm với
                        <div class="mb-1"></div>
                        <div class="horizontal"></div>
                        <div class="heading-line"></div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($right_posts as $post)
                                <li class="list-group-item">
                                    <a href="{{$post->link}}" class="card-link"
                                       @if($post->is_public != 1)
                                       rel="nofollow"
                                            @endif
                                    >
                                        <h3 style="font-weight: 400;">{{ $post->title }}</h3>
                                    </a>
                                </li>

                        @endforeach

                    </div>
                </div>
                <div style="text-align: center ;margin-bottom: 20px">
                    <a href="{{ config('app.app_mobile.link') }}">
                        <img width="100%" src="{{ url('default/img/banner_detail.jpg') }}" alt="Tải app CungHocVui miễn phí để xem offline">
                    </a>
                </div>
            <div class="d-none d-md-block">
            </div>
        </div>
        </div>
    </div>
</div>
    @endsection

@section('after-scripts')
    <script type="text/x-mathjax-config">
    MathJax.Hub.Config({
      CommonHTML: { linebreaks: { automatic: true } },
      "HTML-CSS": { linebreaks: { automatic: true } },
             SVG: { linebreaks: { automatic: true } }
    });
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-MML-AM_CHTML' async></script>
    <script src="{{ url('frontend/js/detail.post.js') }}"></script>
@endsection
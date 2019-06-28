@extends('frontend.layouts.master_equation')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/list_by_cate.css")) !!}
    </style>
@endsection
@section('content')
    <div class="equation-heading">
        <div class="container text-center">
            <div class="menu">
                <i class="fas fa-caret-left arrow-left d-sm-none d-xs-inline-block"></i>
                <div class="wrap-menu">
                    <button class="category btn py-2 active"><i class="fas fa-bong"></i> Chủ đề</button>
                    <button class="tool btn py-2 "><i class="fas fa-vials"></i> Công cụ hóa học</button>
                    <a href="{{route('frontend.equation.chemical',[],false)}}"><button class="chemical btn py-2"><i class="fas fa-magic"></i>Chất hóa học </button></a>
                </div>
                <i class="fas fa-caret-right arrow-right d-sm-none d-xs-inline-block"></i>
                <div class="list-category d-none" id="list-category">
                    <div class="wrapper">
                        <table class="container-fluid" style="border: none">
                            @foreach (array_chunk($category->toArray(), 4, true) as $array)
                                <tr class="row">
                                    @foreach($array as $one_cate)
                                        <td class="col-sm-3"><a href="{{route('frontend.equation.listEquationbyCate', ['slug'=> $one_cate['slug']], false)}}">{{ $one_cate['name'] }}</a></td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="list-category d-none" id="list-tool">
                    <div class="wrapper">
                        <table class="container-fluid text-center" style="border: none;">
                            <tbody>
                            <tr class="row">
                                <td class="col-sm-3"><a href="{{route('frontend.equation.electrochemicalTable',[],false)}}">Dãy điện hóa</a></td>
                                <td class="col-sm-3"><a href="{{route('frontend.equation.reactivityseriesTable',[],false)}}">Dãy hoạt động của kim loại</a></td>
                                <td class="col-sm-3"><a href="{{route('frontend.equation.dissolubilityTable',[],false)}}">Bảng tính tan</a></td>
                                <td class="col-sm-3"><a href="{{route('frontend.equation.periodicTable',[],false)}}">Bảng tuần hoàn</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="title">
                <h1 class="big-title mb-0">Tổng hợp {{$category_name}} - {{$category_name}} đầy đủ và chi tiết nhất</h1>
                <h3 class="description pt-1">Các phương trình {{$category_name}} được Cunghocvui tổng hợp lại đầy đủ dưới đây. Mời các bạn cùng xem</h3>
                <div class="pb-3"></div>
            </div>
            <div class="search real-search d-none d-sm-block" style="display: none;">
                <form action="{{route('frontend.equation.searchEquation')}}" method="get">
                    <div class="wrap real">
                        <input type="text" data-toggle="tooltip" data-html="true" data-placement="bottom" title="Nhập các chất tham gia phản ứng, cách nhau bởi dấu cách" placeholder="Chất tham gia" class="left search-equation" name="chat_tham_gia">
                    </div>
                    <div class="wrap real wrap-right">
                        <input type="text" data-toggle="tooltip" data-html="true" data-placement="bottom" title="Nhập các chất sản phẩm của phản ứng, cách nhau bởi dấu cách" placeholder="Chất sản phẩm" class="right search-equation" name="chat_san_pham">
                    </div>

                    <button id="submit-search" type="submit" class="real-submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="search d-xs-block d-sm-none fake-search">
                <div class="wrap wrap-right" style="width: 85%" >
                    <input type="text" placeholder="Tìm kiếm phương trình" class="right search-equation" id="show-real">
                </div>
                <button id="submit-search" class="fake-submit" style="width: 15%" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>
    <section class="container equation-main">
        <div class="intro">
            <h4 class="intro-title" style="color: #1695c5">{{$category_name}}</h4>
            @if(request('page') == null || request('page') == '1')
                <p class="mb-0 text-justify">{!! $define_cate !!}</p>
                <div class="pb-sm-3"></div>
            @endif
        </div>
        <div class="cate-demo">
            <div class="row demo">
                <div class="col-12">
                    @foreach($equation_data_one_page as $equation_slug => $one_equation)
                    <div class="card-deck-wrapper">
                        <div class="card-deck">
                            <a class="card" href='{{route('frontend.equation.equationDetail', ['slug'=> $equation_slug])}}'>
                                <div class="card-block text-center">
                                    <table style="border: none" class="table-responsive">
                                        <tr class="chemical-equation">
                                            @foreach($one_equation[0] as $symbol)
                                                @if( $symbol == '&#8652;')
                                                    <td class="px-md-2">{!! $symbol !!}</td>
                                                @else
                                                    <td class="px-md-1">{!! $symbol !!}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        <tr class="state ">
                                            @foreach($one_equation[1] as $state)
                                                <td class="px-md-1">{{$state}}</td>
                                                <td></td>
                                            @endforeach
                                        </tr>
                                        <tr class="color-smell">
                                            @foreach($one_equation[2] as $color_smell)
                                                <td class="px-md-1">{{$color_smell}}</td>
                                                <td></td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-3"></div>
            {{--{{$one_page_equation->links()}}--}}

            @if ($one_page_equation->hasPages())
                <ul class="pagination pagination">
                    {{-- Previous Page Link --}}
                    @if ($one_page_equation->onFirstPage())
                        <li class="disabled"><span>«</span></li>
                    @else
                        <li><a href="{{ $one_page_equation->previousPageUrl() }}" rel="prev">«</a></li>
                    @endif
                    @foreach(range(1, $one_page_equation->lastPage()) as $i)
                        @if($i >= $one_page_equation->currentPage() - 2 && $i <= $one_page_equation->currentPage() + 2)
                            @if ($i == $one_page_equation->currentPage())
                                <li class="active"><span>{{ $i }}</span></li>
                            @else
                                <li><a href="{{ $one_page_equation->url($i) }}">{{ $i }}</a></li>
                            @endif
                        @endif
                    @endforeach
                    {{-- Next Page Link --}}
                    @if ($one_page_equation->hasMorePages())
                        <li><a href="{{ $one_page_equation->nextPageUrl() }}" rel="next">»</a></li>
                    @else
                        <li class="disabled"><span>»</span></li>
                    @endif
                </ul>
            @endif

        </div>
    </section>
    <div class="pt-3"></div>
    <p class="last-content text-center pb-0 mb-1">Tổng hợp {{$category_name}} chi tiết nhất!
        Nếu thấy hay, hãy ủng hộ và chia sẻ nhé!
    </p>
    <div class="container pb-3">
        <div class="fb-like d-inline-block" style="margin-left: 50%;transform: translateX(-50%);" data-href="<?php echo url()->current(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
    </div>
@endsection
@section('after-scripts')
    <script src="{{ url('frontend/js/equation_menu.js') }}"></script>
    <script src="{{ url('frontend/js/social_button.js') }}"></script>

@endsection
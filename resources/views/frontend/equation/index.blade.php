@extends('frontend.layouts.master_equation')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/index.css")) !!}
        #equation_content img{
            max-width: 100%;
        }
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
                <h1 class="big-title mb-0">Tìm kiếm phương trình hóa học nhanh nhất</h1>
                <h3 class="description pb-3 pt-1">Tìm kiếm phương trình hóa học đơn giản và nhanh nhất tại Cunghocvui. Học Hóa không còn là nỗi lo với Chuyên mục Phương trình hóa học của chúng tôi</h3>
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
        <div class="intro d-none d-md-block">
            @if(empty($equation_category->description_top))
            <h4 class="intro-title">Phản ứng hóa học là gì</h4>
            <p class="intro-content">Phản ứng hóa học là một quá trình dẫn đến biến đổi một tập hợp các chất này thành một tập hợp các chất khác. Theo cách cổ điển phản ứng hóa học bao gồm toàn bộ các chuyển đổi chỉ liên quan đến vị trí của các electron Phản ứng hóa học là một quá trình dẫn đến biến đổi một tập hợp các chất này thành một tập hợp các chất khác. Theo cách cổ điển phản ứng hóa học bao gồm toàn bộ các chuyển đổi chỉ liên quan đến vị trí của các electron</p>
                @else
                <div id="equation_content">
                    {!! $equation_category->description_top !!}
                </div>
            @endif
        </div>

        @foreach($equation_demo as $cate => $one_cate_demo)
        @if($cate < 11)
            <div class="cate-demo">
        @else
            <div class="cate-demo tohide">
        @endif
            <h4 class="cate-name"><a href='{{route('frontend.equation.listEquationbyCate', ['slug'=> $category[$cate]->slug], false)}}'>{{$category[$cate]->name}}</a></h4>
            <div class="horizontal-line"></div>
            <div class="row demo">
                <div class="col-12">
                    @foreach (array_chunk($one_cate_demo, 2, true) as $array)
                    <div class="card-deck-wrapper">
                        <div class="card-deck">
                            @foreach($array as $equation_slug => $one_equation)
                                <a class="card col-sm-6 p-0" href='{{ route('frontend.equation.equationDetail', ['slug'=> $equation_slug], false) }}'>
                                <div class="card-block text-center">
                                    <table class="table-responsive" style="border: none">
                                        <tr class="chemical-equation">
                                        @foreach($one_equation[0] as $symbol)
                                            <td class="px-md-1">{!! $symbol !!}</td>
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
                            @endforeach
                            @if(count($array) < 2)
                                <div class="col-sm-6"></div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
                    @if(empty($equation_category->description_bottom))
                        <p class="last-content text-center pb-0">Gặp bài Hóa khó, đã có Cunghocvui!
                            Chúng tôi đã tổng hợp lại đầy đủ tất cả các Phương trình hóa học, phục vụ cho quá trình học tập và nghiên cứu của các bạn.
                            Nếu thấy hay, hãy ủng hộ và chia sẻ nhé! </p>
                    @else
                        <div id="equation_content">
                            {!! $equation_category->description_bottom !!}
                        </div>
                    @endif
    </section>

@endsection
@section('after-scripts')
    <script src="{{ url('frontend/js/equation_menu.js') }}"></script>
    <script src="{{ url('frontend/js/equation_index.js') }}"></script>
    <script src="{{ url('frontend/js/social_button.js') }}"></script>
    <script type="text/x-mathjax-config">
    MathJax.Hub.Config({
      CommonHTML: { linebreaks: { automatic: true } },
      "HTML-CSS": { linebreaks: { automatic: true } },
             SVG: { linebreaks: { automatic: true } }
    });
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-MML-AM_CHTML' async></script>
@endsection

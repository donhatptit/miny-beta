@extends('frontend.layouts.master_equation')
@section('css')
<style>
    {!! file_get_contents(public_path("frontend/css/list_product.css")) !!}
</style>
@endsection
@section('content')
    {{--<button class="show-header w-100 d-sm-block d-md-none" id="toshow"><i class="fa fa-angle-down"></i> </button>--}}
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
            <div class="pt-1"></div>
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
            <h1 class="text-center">Các phương trình điều chế {{$keyword}}</h1>
            <h3 class="intro-title mb-3" style="color: #14a9e3;"> Tìm thấy {{$total}} phương trình điều chế {{$keyword}}</h3>
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
                                                @foreach($one_equation[0] as $pos => $symbol)
                                                    @if($symbol == '+' || $symbol == '&#x27F6;' || $symbol == '&#8652;')
                                                        <td class="px-md-2">{{$symbol}}</td>
                                                    @else
                                                        <?php
//                                                        $check_color = false;
//                                                        $i = 0;
//                                                        foreach($array_chemical_input as $one_chemical_input){
//                                                            if( (strpos(strtolower($symbol),$one_chemical_input) !== false)
//                                                                && (substr(strtolower($symbol), -strlen($one_chemical_input)) == $one_chemical_input)
//                                                                && (is_numeric(substr(strtolower($symbol),0,strlen($symbol) - strlen($one_chemical_input))) || substr(strtolower($symbol),0,strlen($symbol) - strlen($one_chemical_input)) == '') ){
//                                                                $i++;
//                                                            }
//                                                        }
//                                                        if($i != 0){ $check_color = true;}

                                                        $arrow_pos = array_search('&#x27F6;',$one_equation[0]);
                                                        if($arrow_pos == false){
                                                            $arrow_pos = array_search('&#8652;',$one_equation[0]);
                                                        }
                                                        $check_color = false;
                                                        $i = 0;
                                                        $symbol_factor = $one_equation[4][$pos/2].$one_equation[3][$pos/2];

                                                        if ( $pos > $arrow_pos ){
                                                            if( (strpos(strtolower($symbol_factor),strtolower($keyword)) !== false)
                                                                && (substr(strtolower($symbol_factor), -strlen(strtolower($keyword))) == strtolower($keyword))
                                                                && (is_numeric(substr(strtolower($symbol_factor),0,strlen($symbol_factor) - strlen(strtolower($keyword))))
                                                                    || substr(strtolower($symbol_factor),0,strlen($symbol_factor) - strlen(strtolower($keyword))) == '')
                                                                    || strpos(strtolower($symbol_factor), ".") !== false ){
                                                                $i++;
                                                            }
                                                        }

                                                        if($i != 0){ $check_color = true;}
                                                        ?>
                                                        @if($check_color == true)
                                                            <td class="px-md-1" style="color: #d8950e;font-weight:500;">{!! $symbol !!}</td>
                                                        @else
                                                            <td class="px-md-1">{!! $symbol !!}</td>
                                                        @endif
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
            {{--{{ $data->links() }}--}}

            @if ($data->hasPages())
                <ul class="pagination pagination">
                    {{-- Previous Page Link --}}
                    @if ($data->onFirstPage())
                        <li class="disabled"><span>«</span></li>
                    @else
                        <li><a href="{{ $data->previousPageUrl() }}" rel="prev">«</a></li>
                    @endif
                    @foreach(range(1, $data->lastPage()) as $i)
                        @if($i >= $data->currentPage() - 2 && $i <= $data->currentPage() + 2)
                            @if ($i == $data->currentPage())
                                <li class="active"><span>{{ $i }}</span></li>
                            @else
                                <li><a href="{{ $data->url($i) }}">{{ $i }}</a></li>
                            @endif
                        @endif
                    @endforeach
                    {{-- Next Page Link --}}
                    @if ($data->hasMorePages())
                        <li><a href="{{ $data->nextPageUrl() }}" rel="next">»</a></li>
                    @else
                        <li class="disabled"><span>»</span></li>
                    @endif
                </ul>
            @endif

        </div>
        <div class="container pb-3">
            <div class="fb-like d-inline-block" style="margin-left: 50%;transform: translateX(-50%);" data-href="<?php echo url()->current(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
        </div>
    </section>
@endsection
@section('after-scripts')
    <script src="{{ url('frontend/js/equation_menu.js') }}"></script>
    <script src="{{ url('frontend/js/social_button.js') }}"></script>
@endsection
@extends('frontend.layouts.master_equation')
@section('css')
    <style>
    {!! file_get_contents(public_path("frontend/css/equation_detail.css")) !!}
    </style>
@endsection
@section('content')
    {{--{{ Breadcrumbs::render('equation', $one_equation) }}--}}
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
    <section class="container chemicalequaiton">
        <div class="title text-center pt-4">
            <h1>{{$header_title}}</h1>
        </div>
        <div class="equation-detail">
            <h3 class="intro pb-0">Chi tiết phương trình</h3>
            <div class="card">
                <div class="card-body">
                    <table style="border: none" class="text-center table-responsive padding-detail">
                        <tr class="chemical-equation" style="font-weight: 700">
                            @foreach($equation_detail[0] as $number => $symbol)
                                @if($symbol == '&#x27F6;' || $symbol == '&#8652;')
                                    <td class="px-md-2 " style="font-weight: 400">{!! $symbol !!}</td>
                                @elseif($symbol != '+')
                                    <td class="px-md-2 ">
                                        @if(array_key_exists($equation_detail[3][$number/2],$info_chemical_in_equation))
                                        <a style="white-space: pre-line;" data-toggle="tooltip" data-html="true" data-placement="bottom"
                                           title="{{$info_chemical_in_equation[$equation_detail[3][$number/2]]['name_vi']}}<br>{{trim($info_chemical_in_equation[$equation_detail[3][$number/2]]['g_mol'])}} (g/mol)"
                                            href="{{route('frontend.equation.chemicalDetail',
                                            ['symbol'=>$equation_detail[3][$number/2]], false)}}">{!! $symbol !!}
                                        </a>
                                        @else
                                            <a style="white-space: pre-line;" data-toggle="tooltip" data-placement="bottom" data-html="true" title="">{!! $symbol !!}
                                            </a>
                                        @endif
                                    </td>
                                @else
                                    <td class="px-md-2 ">{!! $symbol !!}
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                        <tr class="state ">
                            @foreach($equation_detail[1] as $state)
                                <td class="px-md-2">{{$state}}</td>
                                <td></td>
                            @endforeach
                        </tr>
                        <tr class="color-smell">
                            @foreach($equation_detail[2] as $color_smell)
                                <td class="px-md-2">{{$color_smell}}</td>
                                <td></td>
                            @endforeach
                        </tr>
                        <tr class="cal" id="g_mol">
                            @foreach($equation_detail[3] as $number => $chemical)
                                @if(array_key_exists($equation_detail[3][$number],$info_chemical_in_equation))
                                    <td><input type="text" class="form-control" disabled="disabled" value="{{$info_chemical_in_equation[$chemical]['g_mol']}}"></td>
                                @else
                                    <td><input type="text" class="form-control" ></td>
                                @endif
                                    <td></td>
                            @endforeach
                            <td style="width: 210px"><div class="d-none d-md-inline-block">Nguyên tử-Phân tử khối</div> (g/mol)</td>
                        </tr>
                        <tr class="cal" id="mol">
                            @foreach($equation_detail[3] as $one)
                                <td><input type="number" class="form-control" style="text-align:center;"></td>
                                <td></td>
                            @endforeach
                            <td style="width: 210px"><div class="d-none d-md-inline-block" >Số</div> mol</td>
                        </tr>
                        <tr class="cal" id="g">
                            @foreach($equation_detail[3] as $one)
                                <td><input type="number" class="form-control" style="text-align:center;"></td>
                                <td></td>
                            @endforeach
                            <td style="width: 210px"><div class="d-none d-md-inline-block">Khối lượng</div> (g)</td>
                        </tr>
                        <tr class="cal d-none" id="factor">
                            @foreach($chemical_factors as $factor)
                                <td><input type="text" class="form-control" style="text-align:center;" value="{{$factor}}"></td>
                                <td></td>
                            @endforeach
                        </tr>
                    </table>
                    <h6 class="pt-3" >Thông tin thêm</h6>
                    <div class="info">
                        <p></p>
                        @if($one_equation->condition != "")
                            <p class="condition"><b>Điều kiện:</b> {{$one_equation->condition}}</p>
                        @endif
                        @if($one_equation->execute != "")
                            <p class="execute"><b>Cách thực hiện:</b> {{$one_equation->execute}}</p>
                            @endif
                        @if($one_equation->phenomenon != "")
                            <p class="phenomenon"><b>Hiện tượng:</b> {{$one_equation->phenomenon}}</p>
                            @endif
                        @if($one_equation->extra != "")
                            <p class="extra"><b>Bạn có biết:</b> {{$one_equation->extra}}</p>
                            @endif
                    </div>
                    <button title="Tính nhanh số mol và khối lượng các chất" class="btn btn-sm calculate mb-2"><i class="fas fa-calculator mr-1"></i> Tính khối lượng</button>
                    <div class="cate">
                        @foreach($one_equation->equation_tags as $one_cate)
                            @if($one_cate->name != '0')
                                <button class="btn btn-sm mt-2"><a style="text-decoration: none;" href='{{route('frontend.equation.listEquationbyCate', ['slug'=>$one_cate['slug']], false)}}'>{{$one_cate->name}}</a></button>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="fb-like" data-href="<?php echo url()->current(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
        <div class="pb-3"></div>
    </section>

    <section class="container equation-main">
    @foreach($data_equation_make_chemical as $number => $equation_to_one)
        <div class="pt-sm-4"></div>
        <div class="cate-demo">
{{--        <h5 class="title ">Phương trình điều chế <b><a style="color: #23c5a5;" href="{{route('frontend.equation.chemicalDetail',['symbol'=>$equation_detail[3][$number]])}}">{{$equation_detail[3][$number]}}</a></b><a href="{{route('frontend.equation.searchEquation',['chat_tham_gia'=> null,'chat_san_pham'=>$equation_detail[3][$number]])}}"><button class="btn btn-success ml-sm-2">Xem tất cả</button></a></h5>--}}
        <h5 class="title ">Phương trình điều chế <b><a style="color: #14a9e3;" href="{{route('frontend.equation.chemicalDetail',['symbol'=>$equation_detail[3][$number]], false)}}">{{$equation_detail[3][$number]}}</a></b><a href="{{route('frontend.equation.chemicalProductEquation',['symbol'=>$equation_detail[3][$number]], false)}}"><button class="btn btn-success ml-sm-2">Xem tất cả</button></a></h5>
        <div class="horizontal-line"></div>
        <div class="row demo">
            <div class="col-12">
                @foreach (array_chunk($equation_to_one, 2, true) as $array)
                    <div class="card-deck-wrapper">
                        <div class="card-deck">
                            @foreach($array as $equation_slug => $one_equation)
                                <a class="card col-sm-6 p-0" href='{{route('frontend.equation.equationDetail', ['slug'=> $equation_slug], false)}}'>
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
    </section>
    <div class="pb-5"></div>
    <p class="last-content text-center">Nếu thấy hay, hãy ủng hộ và chia sẻ nhé!
    </p>
@endsection
@section('after-scripts')
    <script src="{{ url('frontend/js/equation_menu.js') }}"></script>
    <script src="{{ url('frontend/js/equation_detail.js') }}"></script>
    <script src="{{ url('frontend/js/social_button.js') }}"></script>
@endsection

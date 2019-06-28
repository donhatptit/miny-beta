@extends('frontend.layouts.master_equation')
@section('css')
<style>
    {!! file_get_contents(public_path("frontend/css/chemical_detail.css")) !!}
</style>
@endsection
@section('content')
    {{--{{ Breadcrumbs::render('chemicaldetail', $symbol) }}--}}
    <div class="equation-heading">
        <div class="container text-center">
            <div class="menu">
                <i class="fas fa-caret-left arrow-left d-sm-none d-xs-inline-block"></i>
                <div class="wrap-menu">
                    <button class="category btn py-2"><i class="fas fa-bong"></i> Chủ đề</button>
                    <button class="tool btn py-2 "><i class="fas fa-vials"></i> Công cụ hóa học</button>
                    <a href="{{route('frontend.equation.chemical',[],false)}}"><button class="chemical btn py-2 active"><i class="fas fa-magic"></i>Chất hóa học </button></a>
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
            <div class="title d-none">
                <h3 class="description pb-3 pt-0" style="font-weight:400">Cùng tìm kiếm các chất hóa học nhanh nhất tại Cunghocvui</h3>
            </div>
            <div class="search">
                <form action="{{route('frontend.equation.searchChemical')}}" method="get">
                    <div class="wrap" id="chemical-search">
                        <input type="text" placeholder="H2 hoặc hidro" class="left search-chemical" name="chat_hoa_hoc">
                    </div>
                    <button type="submit" id="btn-chemical-search" ><i class="fas fa-search"></i></button>
                </form>
            </div>

        </div>
    </div>

    <section class="container equation-main">
        <div class="intro text-center" >
            <h1 class="big-title mb-3" style="font-weight:400"> Thông tin về {!! $data_chemical[0]->symbol !!} ({!! trim($data_chemical[0]->name_vi) !!})</h1>
        </div>
        <div class="cate-demo">
            <div class="row demo">
                <div class="col-12">
                    @foreach($data_chemical as $one_chemical)
                        <div class="card-deck-wrapper">
                            <div class="card-deck">
                                <a class="card" id="card-chemical">
                                    <div class="card-block py-md-3 px-md-4 py-xs-1 px-xs-2">
                                        <h4 class="symbol d-inline-block">{{$one_chemical->symbol}}</h4>
                                        @if($one_chemical->name_vi != "")
                                            <?php $name_vi = trim($one_chemical->name_vi); ?>
                                            <h4 class="name-vi d-inline-block"> ({{$name_vi}})</h4>
                                        @endif
                                        @if($one_chemical->name_eng != "")
                                            <p class="name-eng mb-0"><span style="font-weight: 600">Tên Tiếng Anh:</span> {!! $one_chemical->name_eng !!} </p>
                                        @endif
                                        @if($one_chemical->color != "")
                                            <p class="name-eng mb-0"><span style="font-weight: 600">Màu sắc:</span> {{$one_chemical->color}} </p>
                                        @endif
                                        @if($one_chemical->state != "")
                                            <p class="g_m mb-0"><span style="font-weight: 600">Trạng thái thông thường:</span> {{$one_chemical->state}}</p>
                                        @endif
                                        @if($one_chemical->g_mol != "")
                                            <p class="g_m mb-0"><span style="font-weight: 600">Nguyên tử / Phân tử khối (g/mol):</span> {{$one_chemical->g_mol}}</p>
                                        @endif
                                        @if($one_chemical->kg_m3 != "")
                                            <p class="g_m mb-0"><span style="font-weight: 600">Khối lượng riêng (kg/m3):</span> {{$one_chemical->kg_m3}}</p>
                                        @endif
                                        @if($one_chemical->boiling_point != "")
                                            <p class="g_m mb-0"><span style="font-weight: 600">Nhiệt độ sôi:</span> {{$one_chemical->boiling_point}}</p>
                                        @endif
                                        @if($one_chemical->melting_point != "")
                                            <p class="g_m mb-0"><span style="font-weight: 600">Nhiệt độ tan chảy:</span> {{$one_chemical->melting_point}}</p>
                                        @endif
                                        @if($one_chemical->electronegativity != "")
                                            <p class="g_m mb-0"><span style="font-weight: 600">Độ âm điện:</span> {{$one_chemical->electronegativity}}</p>
                                        @endif
                                        @if($one_chemical->ionization_energy != "")
                                            <p class="g_m mb-0"><span style="font-weight: 600">Năng lượng ion hóa thứ nhất:</span> {{$one_chemical->ionization_energy}}</p>
                                        @endif

                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="fb-like" data-href="<?php echo url()->current(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
    </section>
    <section class="container equation-main">
        @foreach($data_equation_chemical as $name => $equation_to_one)
            <div class="pt-sm-4"></div>
            <div class="cate-demo">
                @if($name == 'reactant')
                    <h5  class="title">Phương trình có <b>{{$one_chemical->symbol}}</b> là chất tham  gia phản ứng: <a href="{{route('frontend.equation.chemicalReactantEquation',['symbol'=>$one_chemical->symbol], false)}}"><button class="btn btn-success ml-sm-3">Xem tất cả</button></a></h5>
                @elseif($name == 'product')
                    <h5  class="title">Phương trình có <b>{{$one_chemical->symbol}}</b> là chất sản phẩm: <a href="{{route('frontend.equation.chemicalProductEquation',['symbol'=>$one_chemical->symbol], false)}}"><button class="btn btn-success ml-sm-3">Xem tất cả</button></a></h5>
                @endif
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
            <div class="pb-3"></div>
            <p class="last-content text-center">Nếu thấy hay, hãy ủng hộ và chia sẻ nhé! </p>
    </section>

@endsection
@section('after-scripts')
    <script src="{{ url('frontend/js/equation_menu.js') }}"></script>
    <script src="{{ url('frontend/js/social_button.js') }}"></script>
@endsection
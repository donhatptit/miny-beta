@extends('frontend.layouts.master_equation')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/chemical.css")) !!}
    </style>
@endsection
@section('content')
    {{--{{ Breadcrumbs::render('chemical') }}--}}
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
            <div class="title">
                <h1 class="big-title mb-0" style="font-weight:400">Tìm kiếm chất hóa học nhanh nhất</h1>
                <h3 class="description pb-3 pt-0" style="font-weight:400">Cùng tìm kiếm các chất hóa học nhanh nhất tại Cunghocvui</h3></div>
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
        @if(request('page') == null || request('page') == '1')
        <div class="intro text-center" >
            <h4 class="intro-title mb-0" style="font-weight:300">Chất hóa học là gì?</h4>
            <p class="pt-0" style="font-weight:300;font-size:17px">Một chất hóa học là một loại vật chất với thành phần và thuộc tính xác định. Một tập hợp các chất được gọi là hỗn hợp. Ví dụ về hỗn hợp là không khí và các hợp kim</p>
        </div>
        @endif
        <div class="cate-demo">
            <div class="row demo">
                <div class="col-12">
                    @foreach($data_chemical as $one_chemical)
                    <div class="card-deck-wrapper">
                        <div class="card-deck">
                            <a class="card" id="card-chemical" href="{{route('frontend.equation.chemicalDetail',['symbol'=>$one_chemical->symbol], false)}}">
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
        <div class="pb-3"></div>

        @if ($data_chemical->hasPages())
            <ul class="pagination pagination">
                {{-- Previous Page Link --}}
                @if ($data_chemical->onFirstPage())
                    <li class="disabled"><span>«</span></li>
                @else
                    <li><a href="{{ $data_chemical->previousPageUrl() }}" rel="prev">«</a></li>
                @endif
                @foreach(range(1, $data_chemical->lastPage()) as $i)
                    @if($i >= $data_chemical->currentPage() - 2 && $i <= $data_chemical->currentPage() + 2)
                        @if ($i == $data_chemical->currentPage())
                            <li class="active"><span>{{ $i }}</span></li>
                        @else
                            <li><a href="{{ $data_chemical->url($i) }}">{{ $i }}</a></li>
                        @endif
                    @endif
                @endforeach
                {{-- Next Page Link --}}
                @if ($data_chemical->hasMorePages())
                    <li><a href="{{ $data_chemical->nextPageUrl() }}" rel="next">»</a></li>
                @else
                    <li class="disabled"><span>»</span></li>
                @endif
            </ul>
        @endif

        <div class="pb-3"></div>
        <p class="last-content text-center mb-0 pb-0">Tổng hợp đầy đủ các chất hóa học tại Cunghocvui.
            Nếu thấy hay, hãy ủng hộ và chia sẻ nhé! </p>
        <div class="container pb-3">
            <div class="fb-like d-inline-block" style="margin-left: 50%;transform: translateX(-50%);" data-href="<?php echo url()->current(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
        </div>
        <div class="pb-2"></div>
    </section>
@endsection
@section('after-scripts')
    <script src="{{ url('frontend/js/equation_menu.js') }}"></script>
    <script src="{{ url('frontend/js/social_button.js') }}"></script>
@endsection
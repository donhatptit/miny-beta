@extends('frontend.layouts.master_equation')
@section('css')
<style>
    {!! file_get_contents(public_path("frontend/css/electrochemical_table_tool.css")) !!}
</style>
@endsection
@section('content')
    <div class="equation-heading">
        <div class="container text-center">
            <div class="menu">
                <i class="fas fa-caret-left arrow-left d-sm-none d-xs-inline-block"></i>
                <div class="wrap-menu">
                    <button class="category btn py-2"><i class="fas fa-bong"></i> Chủ đề</button>
                    <button class="tool btn py-2 active"><i class="fas fa-vials"></i> Công cụ hóa học</button>
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

            <div class="pb-md-3"></div>
        </div>
    </div>

    <section class="container tool-electrochemical">
        <p class="text-center title my-3"> Dãy Điện Hoá</p>
        <div class="card px-sm-3 py-sm-3">
            <div class="card-block">
                <div class="table-responsive">
                    <table class="text-center">
                        <tr>
                            <td style="padding-bottom: 0.5rem" class="des" colspan="30"> <span class="badge" style="float: left;">Độ mạnh tính oxi hóa tăng dần <i class="fas fa-arrow-right"></i> <i class="fas fa-arrow-right"></i> <i class="fas fa-arrow-right"></i> </span></td>
                        </tr>
                        <tr class="chemical">
                            <td><span class="badge">Li <sup>+</sup></span></td>
                            <td><span class="badge">K <sup>+</sup></span></td>
                            <td><span class="badge">Ba <sup>2+</sup></span></td>

                            <td><span class="badge">Ca <sup>2+</sup></span></td>
                            <td><span class="badge">Na <sup>+</sup></span></td>
                            <td><span class="badge">Mg <sup>2+</sup></span></td>

                            <td><span class="badge">Ti <sup>2+</sup></span></td>
                            <td><span class="badge">Al <sup>3+</sup></span></td>
                            <td><span class="badge">Mn <sup>2+</sup></span></td>

                            <td><span class="badge">Zn <sup>2+</sup></span></td>
                            <td><span class="badge">Cr <sup>3+</sup></span></td>
                            <td><span class="badge">Fe <sup>2+</sup></span></td>

                            <td><span class="badge">Cd <sup>2+</sup></span></td>
                            <td><span class="badge">Co <sup>2+</sup></span></td>
                            <td><span class="badge">Ni <sup>2+</sup></span></td>

                            <td><span class="badge">Sn <sup>2+</sup></span></td>
                            <td><span class="badge">Pb <sup>2+</sup></span></td>
                            <td><span class="badge">Fe <sup>3+</sup></span></td>

                            <td class="specical"><span class="badge">2H <sup>+</sup></span></td>
                            <td><span class="badge">Sn <sup>4+</sup></span></td>
                            <td><span class="badge">Sb <sup>3+</sup></span></td>

                            <td><span class="badge">Bi <sup>3+</sup></span></td>
                            <td><span class="badge">Cu <sup>2+</sup></span></td>
                            <td><span class="badge">Fe <sup>3+</sup></span></td>

                            <td><span class="badge">Hg <sup>1+</sup></span></td>
                            <td><span class="badge">Ag <sup>1+</sup></span></td>
                            <td><span class="badge">Hg <sup>2+</sup></span></td>

                            <td><span class="badge">Pt <sup>2+</sup></span></td>
                            <td><span class="badge">Au <sup>3+</sup></span></td>
                        </tr>
                        <tr class="number">
                            <td>...</td>
                            <td>-2,295</td>
                            <td>...</td>
                            <td>-2,866</td>
                            <td>-2,714</td>
                            <td>-2,363</td>
                            <td>-1,750</td>
                            <td>-1,662</td>
                            <td>-1,180</td>
                            <td>-0,763</td>
                            <td>-0,744</td>
                            <td>-0,440</td>
                            <td>-0,403</td>
                            <td>-0,277</td>
                            <td>-0,250</td>
                            <td>-0,136</td>
                            <td>-0,126</td>
                            <td>...</td>
                            <td>0</td>
                            <td>0,050</td>
                            <td>0,250</td>
                            <td>0,230</td>
                            <td>0,337</td>
                            <td>0,77</td>
                            <td>...</td>
                            <td>0,799</td>
                            <td>...</td>
                            <td>1,200</td>
                            <td>1,700</td>
                        </tr>
                        <tr class="chemical">
                            <td> <span class="badge">Li </span> </td>
                            <td><span class="badge">K  </span></td>
                            <td><span class="badge">Ba  </span></td>

                            <td><span class="badge">Ca  </span></td>
                            <td><span class="badge">Na  </span></td>
                            <td><span class="badge">Mg  </span></td>

                            <td><span class="badge">Ti </span></td>
                            <td><span class="badge">Al  </span></td>
                            <td><span class="badge">Mn </span> </td>

                            <td><span class="badge">Zn </span> </td>
                            <td><span class="badge">Cr  </span></td>
                            <td><span class="badge">Fe  </span></td>

                            <td><span class="badge">Cd  </span></td>
                            <td><span class="badge">Co  </span></td>
                            <td><span class="badge">Ni  </span></td>

                            <td><span class="badge">Sn  </span></td>
                            <td><span class="badge">Pb  </span></td>
                            <td><span class="badge">Fe  </span></td>

                            <td class="specical"><span class="badge">H <sub>2</sub> </span></td>
                            <td><span class="badge">Sn  </span></td>
                            <td><span class="badge">Sb  </span></td>

                            <td><span class="badge">Bi  </span></td>
                            <td><span class="badge">Cu  </span></td>
                            <td><span class="badge">Fe  <sup>2+</sup></span></td>

                            <td><span class="badge">Hg </span> </td>
                            <td><span class="badge">Ag  </span></td>
                            <td><span class="badge">Hg  </span></td>

                            <td><span class="badge">Pt  </span></td>
                            <td><span class="badge">Au  </span></td>
                        </tr>
                        <tr>
                            <td style="padding-top: 0.5rem" class="des" colspan="30"><span class="badge" style="float: right;"> Độ mạnh tính khử tăng dần <i class="fas fa-arrow-left"></i> <i class="fas fa-arrow-left"></i> <i class="fas fa-arrow-left"></i> </span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="pt-4"></div>
        <div class="des2 text-justify">
            <h5> Ý nghĩa của dãy điện hoá của kim loại</h5>
            <p class="mb-0"> Dãy điện hoá của kim loại cho phép dự đoán chiều của phản ứng giữa 2 cặp oxi hoá - khử theo quy tắc alpha: Phản ứng giữa 2 cặp oxi hoá - khử sẽ xảy ra theo chiều chất oxi hoá mạnh hơn sẽ oxi hoá chất khử mạnh hơn, sinh ra chất oxi hoá yêu hơn và chất khử yếu hơn.</p>
            <p>1. Từ trái sang phải, độ hoạt động của kim loại giảm dần. <br>
            2. Những kim loại có độ hoạt động mạnh như K, Na, Ca rất ái lực với nước để tạo bazơ kiềm tương ứng và giải phóng Hidro.<br>
            3. Kim loại tác dụng với dung dịch axit cho ra muối và giải phóng khí Hidro với 2 điều kiện:<br>
                &nbsp - Kim loại phải đứng trước Hidro trong dãy hoạt động hóa học<br>
                &nbsp - Dung dịch axit tham gia phải loãng.<br>
            4. Kim loại tác dụng với muối cho ra muối mới và kim loại mới với 3 điều kiện:<br>
                &nbsp - Kim loại của đơn chất phải đứng trước kim loại của hợp chất.<br>
                &nbsp - Trong dãy hoạt động hóa học, dung dịch muối tham gia phải tan.<br>
                &nbsp - Kim loại của đơn chất phải bắt đầu từ Mg trong Dãy điện hóa. </p>
            <div class="pb-1"></div>
        </div>
        <div class="container pb-4">
            <div class="fb-like d-inline-block" style="margin-left: 50%;transform: translateX(-50%);" data-href="<?php echo url()->current(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
        </div>
    </section>
@endsection
@section('after-scripts')
    <script src="{{ url('frontend/js/equation_menu.js') }}"></script>
    <script src="{{ url('frontend/js/periodic_table.js') }}"></script>
    <script src="{{ url('frontend/js/social_button.js') }}"></script>
@endsection

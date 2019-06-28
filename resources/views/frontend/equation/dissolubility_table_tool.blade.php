@extends('frontend.layouts.master_equation')
@section('css')
<style>
    {!! file_get_contents(public_path("frontend/css/dissolubility_table_tool.css")) !!}
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

    <section class="container tool-dissolubility">
        <p class="text-center title my-3"> Bảng tính tan các chất hóa học đầy đủ nhất</p>
        <div class="card px-sm-4 py-sm-4">
            <div class="card-block">
                <table class="dissolubility w-100 text-center table-responsive">
                    <tr style="background-color: #003355" class="table-header">
                        <th rowspan="2" style="width: 10%;border-right:1px solid white;" class="th-left"> Nhóm Hiđroxit gốc axit</th>
                        <th colspan="14" > Hiđro và các kim loại</th>
                    </tr>
                    <tr style="color: black;font-weight: 500;" class="chemicals">
                        <td>H <br> I</td>
                        <td>K <br> I</td>
                        <td>Na <br> I</td>
                        <td>Ag <br> I</td>
                        <td>Mg <br> II</td>
                        <td>Ca <br> II</td>
                        <td>Ba <br> II</td>
                        <td>Zn <br> II</td>
                        <td>Hg <br> II</td>
                        <td>Pb <br> II</td>
                        <td>Cu <br> II</td>
                        <td>Fe <br> II</td>
                        <td>Fe <br> III</td>
                        <td>Al <br> III</td>
                    </tr>
                    <tr >
                        <th style="color: black"> - OH </th>
                        <td> </td>
                        <td class="tan"> t </td>
                        <td class="tan"> t </td>
                        <td class="kotontai"> - </td>
                        <td class="kotan">k </td>
                        <td class="ittan">i </td>
                        <td class="tan"> t </td>
                        <td class="kotan">k </td>
                        <td class="kotontai"> - </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                    </tr>
                    <tr>
                        <th style="color: black"> - Cl </th>
                        <td class="tan-bayhoi">t/b</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="kotan">k </td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                    </tr>
                    <tr>
                        <th style="color: black"> - NO3 </th>
                        <td class="tan-bayhoi">t/b</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                    </tr>
                    <tr>
                        <th style="color: black"> - CH3COO </th>
                        <td class="tan-bayhoi">t/b</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="kotontai"> - </td>
                        <td class="ittan">i </td>
                    </tr>
                    <tr>
                        <th style="color: black"> = S </th>
                        <td class="tan-bayhoi">t/b</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="kotan">k </td>
                        <td class="ittan">i </td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="ittan">i </td>
                    </tr>
                    <tr>
                        <th style="color: black"> = SO3 </th>
                        <td class="tan-bayhoi">t/b</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="ittan">i </td>
                        <td class="ittan">i </td>
                    </tr>
                    <tr>
                        <th style="color: black"> = SO4 </th>
                        <td class="tan-kobayhoi">t/kb</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="ittan">i </td>
                        <td class="tan">t</td>
                        <td class="ittan">i </td>
                        <td class="kotan">k </td>
                        <td class="tan">t</td>
                        <td class="kotontai"> - </td>
                        <td class="kotan">k </td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                    </tr>
                    <tr>
                        <th style="color: black"> = CO3 </th>
                        <td class="tan-bayhoi">t/b</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotontai"> - </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotontai"> - </td>
                        <td class="kotontai"> - </td>
                    </tr>
                    <tr>
                        <th style="color: black"> = SiO3 </th>
                        <td class="kotan-kobayhoi">k/kb</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="kotontai"> - </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotontai"> - </td>
                        <td class="kotan">k </td>
                        <td class="kotontai"> - </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                    </tr>
                    <tr>
                        <th style="color: black"> <div class="dash d-inline-block" style="font-size: 0.7rem;">&#9776;</div> SiO3 </th>
                        <td class="tan-kobayhoi">t/kb</td>
                        <td class="tan">t</td>
                        <td class="tan">t</td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                        <td class="kotan">k </td>
                    </tr>
                </table>
                <p style="color: black;font-size: 15px" class="mt-3 mb-1">* tại 1 atm và nhiệt độ phòng (khoảng 293,15 °K = 25,15 °C)</p>
                <span class="badge" style="background-color:#337ab7">Tan được trong nước</span>
                <span class="badge" style="background-color:#f0ad4e">Không tan được trong nước</span>
                <span class="badge" style="background-color:#5bc0de">Ít tan</span>
                <span class="badge" style="background-color:#777777">Bị phân huỷ hoặc không tồn tại trong nước</span>
                <span class="badge" style="background-color:#9966CC">Bay hơi hoặc dễ bị phân hủy thành khí bay lên</span>
                <span class="badge" style="background-color:#336633">Không bay hơi</span>
            </div>
        </div>
        <div class="pt-5"></div>
        <div class="des text-justify">
            <h5> Ý nghĩa bảng tính tan</h5>
            <p class="mb-0">Bảng tính tan được dùng để biết một số chất có thể tan được trong nước hay không. <br>
            Dùng bảng tính tan là một cách hiệu quả để phân biệt các chất khác nhau bằng phản ứng hóa học. </p>
            <p class="font-weight-bold mb-0">Đặc tính tan của Axit, Bazơ, Muối: </p>
            <p>- Axit: Phần lớn các chất axit tan được trong môi trường nước trừ axit Silixic <br>
            - Bazơ: Hầu hết các bazơ không thể tan trong nước trừ 1 số hợp chất như: KOH, NaOH,... <br>
            - Muối: <br>
                 + Muối Natri, Kali đều tan <br>
                 + Những muối nitrat đều tan <br>
                 + Hầu hết các muối clorua, sunfat đều tan được. Nhưng hầu hết các muối Cacbonat đều không tan. <br>
            Định nghĩa độ tan: <br>
            - Độ tan (kí hiệu là S) của một chất trong nước là số gam chất đó hòa tan trong 100g nước để tạo thành dung dịch bão hòa ở 1 nhiệt độ xác định. <br>
            Những yếu tố ảnh hưởng đến độ tan: <br>
            - Độ tan của chất rắn trong nước phụ thuộc vào nhiệt độ, trong nhiều trường hợp, khi nhiệt độ tăng thì độ tan cũng tăng theo. Số ít trường hợp, nhiệt độ tăng độ tan lại giảm. <br>
                - Độ tan của chất khí trong nước phụ thuộc vào nhiệt độ và áp suất. Độ tan của chất khí trong nước sẽ tăng, nếu ta giảm nhiệt độ và tăng áp suất. </p>
        </div>
        <p class="last-content text-center font-weight-bold">Hãy sử dụng bảng tính tan thật hiệu quả nhé!  </p>
        <div class="container pb-4">
            <div class="fb-like d-inline-block" style="margin-left: 50%;transform: translateX(-50%);" data-href="<?php echo url()->current(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
        </div>
    </section>
@endsection
@section('after-scripts')
    <script src="{{ url('frontend/js/equation_menu.js') }}"></script>
    <script src="{{ url('frontend/js/social_button.js') }}"></script>
@endsection

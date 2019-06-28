@extends('frontend.layouts.master_equation')
@section('css')
<style>
    {!! file_get_contents(public_path("frontend/css/reactivityseries_table_tool.css")) !!}
</style>
@endsection
@section('content')
    <div class="equation-heading">
        <div class="container text-center">
            <div class="menu">
                <i class="fas fa-caret-left arrow-left d-sm-none d-xs-inline-block"></i>
                <div class="wrap-menu">
                    <button class="category btn py-2 "><i class="fas fa-bong"></i> Chủ đề</button>
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

    <section class="container tool-reactivity">
        <p class="text-center title my-3"> Dãy hoạt động kim của loại</p>
        <div class="card px-sm-3 py-sm-3">
            <div class="card-block">
                <div class="table-responsive">
                    <table class="text-center">
                        <tr class="head">
                            <td class="strong-metal" colspan="6"><span class="badge badge-primary">Kim loại mạnh</span></td>
                            <td class="average-metal" colspan="5"><span class="badge badge-info">Kim loại trung bình</span></td>
                            <td colspan="1"></td>
                            <td class="weak-metal" colspan="5"><span class="badge badge-warning">Kim loại yếu</span></td>
                        </tr>
                        <tr>
                            <td class="extend"><span class="badge badge-primary">Li</span></td>
                            <td ><span class="badge badge-primary">K</span></td>
                            <td ><span class="badge badge-primary">Ba</span></td>
                            <td ><span class="badge badge-primary">Ca</span></td>
                            <td ><span class="badge badge-primary">Na</span></td>
                            <td ><span class="badge badge-primary">Mg</span></td>
                            <td ><span class="badge badge-primary">Al</span></td>

                            <td class="extend"><span class="badge badge-info">Mn</span></td>
                            <td ><span class="badge badge-info">Zn</span></td>
                            <td class="extend"><span class="badge badge-info">Cr</span></td>
                            <td ><span class="badge badge-info">Fe <sup>2+</sup></span></td>
                            <td class="extend"><span class="badge badge-info">Co <sup>2+</sup></span></td>
                            <td ><span class="badge badge-info">Ni</span></td>
                            <td ><span class="badge badge-info">Sn</span></td>
                            <td ><span class="badge badge-info">Pb</span></td>
                            <td class="extend"><span class="badge badge-info">Fe <sup>3+</sup>/Fe</span></td>

                            <td ><span class="badge badge-secondary">H</span></td>

                            <td ><span class="badge badge-warning">Cu</span></td>
                            <td class="extend"><span class="badge badge-warning">Fe <sup>3+</sup>/Fe <sup>2+</sup> </span></td>
                            <td><span class="badge badge-warning">Hg <sup>+</sup></span></td>
                            <td><span class="badge badge-warning">Ag</span></td>
                            <td class="extend"><span class="badge badge-warning">Hg <sup>2+</sup></span></td>
                            <td><span class="badge badge-warning">Pt</span></td>
                            <td><span class="badge badge-warning">Au</span></td>

                        </tr>
                        <tr class="trick">
                            <td class="extend"></td>
                            <td>Khi</td>
                            <td>Bà</td>
                            <td>Con</td>
                            <td>Nào</td>
                            <td>Mua</td>
                            <td>Áo</td>
                            <td class="extend" ></td>
                            <td>Giáp</td>
                            <td class="extend"></td>
                            <td>Sắt</td>
                            <td class="extend"></td>
                            <td>Nên</td>
                            <td>Sang</td>
                            <td>Phố</td>
                            <td class="extend"></td>
                            <td>Hỏi</td>
                            <td>Cửa</td>
                            <td class="extend"></td>
                            <td>Hàng</td>
                            <td>Á</td>
                            <td class="extend"></td>
                            <td>Phi</td>
                            <td>Âu</td>
                        </tr>
                    </table>
                    <button class="btn btn-success btn-sm" id="extendButton"><i class="fas fa-angle-right"></i> Mở rộng</button>
                </div>
            </div>
        </div>

        <div class="pt-4"></div>
        <div class="des2">
            <h5>Dãy hoạt động hoá học của kim loại cho biết</h5>
            <ul>
                <li>Mức độ hoạt động hoá học của các kim loại giảm dần trừ trái sang phải</li>
                <li>Kim loại đứng trước <b>Mg</b> phản ứng với nước ở điều kiện thường tạo thành kiềm và giải phóng khí H2</li>
                <li>Kim loại đứng trước <b>H</b> phản ứng với một số dung dịch Axit (HCl, H2SO4 loãng,...) giải phóng khí H2</li>
                <li>Kim loại đứng trước (trừ <b>Na K</b>,...) đẩy kim loại đứng sau ra khỏi dung dịch muối</li>
            </ul>
        </div>
        <div class="container pb-4">
            <div class="fb-like d-inline-block" style="margin-left: 50%;transform: translateX(-50%);" data-href="<?php echo url()->current(); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>
        </div>
    </section>
@endsection
@section('after-scripts')
    <script src="{{ url('frontend/js/equation_menu.js') }}"></script>
    <script src="{{ url('frontend/js/reactivity_table.js') }}"></script>
    <script src="{{ url('frontend/js/social_button.js') }}"></script>
@endsection

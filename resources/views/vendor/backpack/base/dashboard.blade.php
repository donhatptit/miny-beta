@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header">
                    <div class="row">
                        <div class="col-lg-4 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>{{ $count_post_approve }}</h3>

                                    <p>Bài viết được duyệt</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-check-square"></i>
                                </div>
                                <a href="/admin/post" class="small-box-footer">Xem thêm<i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{ $count_post }}</h3>

                                    <p>Tổng số bài viết</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <a href="/admin/post" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{{ $count_user }}</h3>

                                    <p>Tổng số user</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <a href="/admin/user" class="small-box-footer">Xem thêm <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                    </div>


                </div>

            </div>
        </div>
        <div class="col-lg-12">
            <div class="box box-default">
                <div class=" with-border">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Thống kê nhập liệu</h3>
                            <form class="form-inline pull-right" method="GET">
                                <div class="form-group">
                                    <label>Tùy chọn:</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                        <span>
                                          <i class="fa fa-calendar"></i>
                                            @if($date_view)
                                                {{ $date_view }}
                                            @else
                                                {{ 'Toàn thời gian' }}
                                            @endif
                                        </span>
                                            <i class="fa fa-caret-down"></i>
                                            <input type="text" name="date_option" hidden id="date_option">
                                            <input type="text" name ="date_view" hidden id ="date_view">
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="category">
                                        <option selected="selected" value="">---- Chọn danh mục -----</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id == request()->get('category') ? "selected" : "" }}>{{ $category->name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info"> Lọc</button>
                            </form>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Đã duyệt</th>
                                        <th>Chưa duyệt</th>
                                        <th>Tổng số</th>
                                    </tr>
                                    @foreach($count_post_user as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                           {{ $user->count_approve }}
                                        </td>
                                        <td>
                                            {{ $user->count_not_approve }}
                                        </td>
                                        <td>
                                            {{ $user->count_approve + $user->count_not_approve  }}
                                        </td>
                                    </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="box box-default">
                <div class=" with-border">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Câu hỏi</h3>
                            <form class="form-inline pull-right" method="GET">
                                <div class="form-group">
                                    <label>Tùy chọn:</label>
                                    {{--<div class="input-group">--}}
                                        {{--<button type="button" class="btn btn-default pull-right" id="daterange-btn">--}}
                                        {{--<span>--}}
                                          {{--<i class="fa fa-calendar"></i>--}}
                                            {{--@if($date_view)--}}
                                                {{--{{ $date_view }}--}}
                                            {{--@else--}}
                                                {{--{{ 'Toàn thời gian' }}--}}
                                            {{--@endif--}}
                                        {{--</span>--}}
                                            {{--<i class="fa fa-caret-down"></i>--}}
                                            {{--<input type="text" name="date_option" hidden id="date_option">--}}
                                            {{--<input type="text" name ="date_view" hidden id ="date_view">--}}
                                        {{--</button>--}}
                                    {{--</div>--}}
                                </div>
                                <div class="form-group">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="category_question">
                                        <option selected="selected" value="">---- Chọn danh mục -----</option>
                                        @foreach($categories_question as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == request()->get('category') ? "selected" : "" }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info"> Lọc</button>
                            </form>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <th>Sô tập đã duyệt</th>
                                    <th>Số tập chưa duyệt</th>
                                    <th>Tổng số tập</th>
                                    <th>Tổng số câu hỏi</th>
                                </tr>
                                    <tr>
                                        <td> {{ $cate_question_approve }}</td>
                                        <td> {{ $cate_question_not_approve }}</td>
                                        <td>{{ $cate_question_approve + $cate_question_not_approve }}</td>
                                        <td> {{ $count_flash_question }}</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Bài viết mới nhất
                        @if($new_post)
                        <span class="label label-info">{{ $new_post->count() }}</span>
                            @endif
                    </h3>

                    <div class="box-tools">
                        <div class="input-group input-group-sm">
                            <a href="/admin/post" class="small-box-footer btn btn-info" style="font-size:1.6rem">
                                Xem tất cả
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Trạng thái</th>
                                <th>Người tạo</th>
                                <th>Thời gian tạo</th>
                                @role('Administrator')
                                <th>Action</th>
                                @endrole
                            </tr>
                            @foreach($new_post as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td><a href="{{ route('frontend.post.detail',['slug'=>$post->slug]) }}">{{ $post->title }}</a></td>
                                <td>
                                    @if($post->is_approve ==1)
                                    <span class="label label-success">
                                       Đã duyệt
                                    </span>
                                        @else
                                        <span class="label label-warning">
                                         Chưa duyệt
                                        </span>
                                        @endif
                                </td>
                                <td>{{ $post->user->name or 'Không xác định' }}</td>
                                <td>{{ $post->created_at }}</td>
                                @role('Administrator')
                                <td class="text-center">
                                    <a href="/admin/post/{{ $post->id }}/edit" class="btn btn-default">
                                        <i class="fa fa-edit"></i>
                                        &nbsp;Edit
                                    </a>
                                </td>
                                @endrole
                            </tr>
                                @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
@section('before_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
@endsection
@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script>
        $('.select2').select2()
        $('#daterange-btn').daterangepicker(
            {
                ranges   : {
                    'Hôm nay'       : [moment(), moment()],
                    'Hôm qua'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Tháng này'  : [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('D/M/YYYY') + ' - ' + end.format('D/M/YYYY'));
                $('#daterange-btn #date_view').val(start.format('D/M/YYYY') + ' - ' + end.format('D/M/YYYY'));
                $('#daterange-btn #date_option').val(start.format('YYYY-M-D') + ' / ' + end.format('YYYY-M-D'));
            }
        )
    </script>
    @endsection

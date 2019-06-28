@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Quản lý danh mục
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Danh mục</li>
        </ol>
    </section>
@endsection
@section('content')
    <div class="col-lg-12">
        <form action="{{ route('admin.category.post') }}" method="GET">
            {{ csrf_field() }}
        <div class="form-group">
            <label>Lớp</label>
            <select class="form-control select2 " id="category_root" style="width: 25%;" name="category_root" data-link="{{ route('admin.category.post') }}">
                <option selected="selected" value="">Chọn lớp</option>
                @foreach($cate_root as $category)
                <option value = "{{ $category->id }}"
                @if($category->id == request()->get('category_root'))
                selected= "selected"
                @endif
                >{{ $category->name }}</option>
                @endforeach
            </select>
            <label style="padding: 15px">Môn</label>
            <select class="form-control select2" style="width: 25%;" id="category_one" name="category_one"
            >
                <option selected="selected">{{ $name_cate_one  }}</option>
            </select>
            <label style="padding: 15px">Trạng thái</label>
            <select class="form-control select2" style="width: 20%;" id="display_category" name="display_category"
            >
                <option selected="selected" value="">-- Chọn --</option>
                <option value="0" {{ request()->get('display_category') === 0 ? "selected" : '' }} >Chưa chọn </option>
                <option value="1" {{ request()->get('display_category') === 1 ? "selected" : '' }}>Hiển thị trên web</option>
                <option value="2" {{ request()->get('display_category') === 2 ? "selected" : '' }}>Hiển thị App</option>
                <option value="3" {{ request()->get('display_category') === 3 ? "selected" : '' }}>Hiển thị tất cả</option>
                <option value="-1" {{ request()->get('display_category') === -1 ? "selected" : '' }}>Ẩn tất cả </option>


            </select>
            <button class="btn btn-primary" >Lọc</button>
        </div>
        </form>
    </div>
    <div class="col-xs-12 col-lg-12 no-padding">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Quản lý danh mục
                </h3>

                <div class="box-tools">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover table-bordered" id="category_list">
                    <tbody>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Tên</th>
                        <th class="text-center">Loại</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                    @foreach($tree_category as $category)
                        <tr>
                            <td class="text-center">{{ $category->id }}</td>
                            <td>
                                <a href="{{ route('frontend.category.index', $category->slug) }}" target="_blank">
                                    {{ $category->name_parent }}
                                </a>
                            </td>
                            <td>{{ $category->type }}</td>
                            <td>
                                @if($category->status == 1)
                                        {{ 'Web' }}
                                    @elseif($category->status == 2)
                                         {{ "App" }}
                                    @elseif($category->status == 3)
                                        {{ "Hiển thị tất cả" }}
                                    @elseif($category->status == 0)
                                    {{ "Chưa chọn" }}
                                    @else
                                        {{ "Ẩn" }}
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="" class="btn btn-default btn-sm category-move" data-link = "{{ route('backend.category.check_moving',['id'=> $category->id,'direction'=>'left']) }} " data-toggle="tooltip" title="Giảm một cấp"><i class=" fa fa-arrow-left"></i></a>
                                <a href="" class="btn btn-default btn-sm category-move" data-link = "{{ route('backend.category.check_moving',['id'=> $category->id,'direction'=>'up']) }}" data-toggle="tooltip" title="Chuyển lên"><i class=" fa fa-arrow-up"></i></a>
                                <a href="" class="btn btn-default btn-sm category-move" data-link = "{{ route('backend.category.check_moving',['id'=> $category->id,'direction'=>'down']) }}" data-toggle="tooltip" title="Chuyển xuống"><i class=" fa fa-arrow-down"></i></a>
                                <a href="" class="btn btn-default btn-sm category-move" data-link = "{{ route('backend.category.check_moving',['id'=> $category->id,'direction'=>'right']) }}" data-toggle="tooltip" title="Tăng một cấp"><i class=" fa fa-arrow-right"></i></a>
                                <a href="/admin/category/{{ $category->id }}/edit" class="btn btn-default btn-sm" data-toggle="tooltip" title="Chỉnh sửa"><i class=" fa fa-edit "></i></a>
                                <a href="" class="btn btn-default btn-sm bg-red category-delete" data-link = "{{ route('backend.category.delete',['id'=> $category->id]) }}" data-toggle="tooltip" title="Xóa danh mục"><i class=" fa  fa-trash "></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $tree_category->appends(['category_root' => $category_root,'category_one'=>$category_one,'display_category'=>$display_category])->links() }}
                </div>
            </div>
        </div>
    </div>


@endsection

@section('before_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
    @endsection
@section('after_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
    <script src="{{ url('frontend/js/category_manager.js') }}"></script>
    @endsection

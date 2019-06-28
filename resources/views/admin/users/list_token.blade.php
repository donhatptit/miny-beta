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
                        <th class="text-center col-lg-8">Tên</th>
                        <th class="text-center col-lg-8">API Token</th>
                        <th class="text-center col-lg-3">Thao tác</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td class="text-center">{{ $user->id }}</td>
                            <td><a href="">{{ $user->name }}</a></td>
                            <td>{{ $user->api_token }}</td>
                            <td class="text-right">
                                <a href="{{ route('admin.user.token.gen', $user->id) }}" class="btn btn-default btn-sm category-move" data-link = " " data-toggle="tooltip" title="Giảm một cấp">
                                    Gen
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>
                </div>
            </div>
        </div>
    </div>


@endsection

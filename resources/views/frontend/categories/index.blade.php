@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/cate_index1.css")) !!}
    </style>
@endsection
@section('content')
    <div class="post-heading" style="margin-bottom: 25px;">
        <div class="container">
            @php
                $breadcrumbs_render = Breadcrumbs::render('category', $category_current);
            @endphp
            {{ $breadcrumbs_render or ''}}
            <div class="text-center">
                <h1 class="post-title">{{ $title or "Chưa có tiêu đề"}}</h1>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-post-detail card-body">
                    <p class="text-dark">{!! $category_current->description_top !!}</p>
                    <div>
                        <ul class="list-unstyled">
                            @foreach($categories as $category)
                            <li style="padding: 0.2rem 0;"><a class="li-grade" href="{{ route('frontend.category.index', ['slug' => $category->slug],false) }}">{{ $category->name }}</a></li>
                                @endforeach
                        </ul>
                    </div>
                    <p class="text-dark">{!! $category_current->description_bottom !!}</p>
                </div>
            </div>
            <div>
        </div>
    </div>
@endsection
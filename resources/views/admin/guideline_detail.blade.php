@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Hướng dẫn
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">Hướng dẫn</li>
        </ol>
    </section>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12" >
            <div class="article_content" style="background: #ffffff; padding: 20px">
                <h1>{{ $guideline->title }}</h1>
                <p>{!! $guideline->content !!}</p>
                <a href="{{ backpack_url('guideline') }}" role="button" class="btn text-light btn-primary">Trở về</a>
            </div>
        </div>
    </div>
@endsection

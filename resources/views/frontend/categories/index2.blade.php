@extends('frontend.layouts.master')
@section('css')
    <style>
        {!! file_get_contents(public_path("frontend/css/cate_index2.css")) !!}
    </style>
@endsection
@section('content')
    <div class="post-heading" style="margin-bottom: 25px;">
        <div class="container">
            @php
                $breadcrumbs_render = Breadcrumbs::render('category-subject', $category_current);
            @endphp
            {{ $breadcrumbs_render or ''}}
            <div class="text-center">
                <h1 class="post-title">{{ $category_current->name or 'Chưa có title' }}</h1>
            </div>
        </div>
    </div>

    <div class="container" style="margin-bottom: 50px">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-12 text-dark">
                    {!! $category_current->description_top !!}
                </div>
                <div class="col-lg-12 row">
                    @foreach($categories as $category)
                        <div class="col-lg-6">
                            @if(!$category->isLeaf())
                                <h2 class ="text-dark" style ="font-size :1.2rem;font-weight: 400;">{{ $category->name }}</h2>
                                <div style="border-bottom: 2px solid #dddddd"></div>
                            @else
                                <p class ="text-dark"><a style="color: #14a9e3;" href="{{ route('frontend.category.index',['slug' => $category->slug ]) }}">{{ $category->name }}</a></p>
                                <div style="border-bottom: 2px solid #dddddd"></div>
                            @endif
                            <ul class = "list-unstyled ml-3 mt-2">
                                @foreach($category->getDescendants(['parent_id', 'slug', 'name','depth','lft','rgt']) as $child)
                                    @if($child->parent_id == $category->id)
                                        @if($child->isLeaf())
                                    <li class="ml-3"><i class="fa fa-caret-right text-primary" style="font-size: 0.9rem;color: #14a9e3!important;"></i> <a style="font-size: 17px" class="li-grade" href="{{ route('frontend.category.index',['slug' => $child->slug ],false) }}">{{  $child->name }}</a></li>  @else
                                            <h3 class="ml-3 text-dark" style ="font-size :17px">{{  $child->name }}</h3>
                                            @endif
                                    @else
                                    <ul class="list-unstyled ml-3">
                                        <li class="ml-3"><i class="fa fa-caret-right text-primary" style="font-size: 0.9rem;color: #14a9e3!important;"></i> <a class="li-grade" style="font-size: 17px;" href="{{ route('frontend.category.index',['slug' => $child->slug ],false) }}">{{  $child->name }}
                                            </a></li>
                                    </ul>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-12 text-dark">
                    {!! $category_current->description_bottom !!}
                </div>
            </div>
            </div>
            <div class="col-lg-12">
                <div style="margin-top: 10px">
                    @include('frontend.social.like_share', ['data_url' => route('frontend.category.index',['slug'=>$category->slug])])
                </div>

                <div class="fb-comments" data-href="{{ route('frontend.category.index',['slug'=>$category->slug]) }}" data-numposts="3" width="100%"></div>
            </div>
        </div>
    </div>

@endsection
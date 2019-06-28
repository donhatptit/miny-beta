<header style="background: #fff">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-white" style="padding: 0.5rem 0rem;">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ url(config('app.logo')) }}">
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    {{--<li class="nav-item active">--}}
                        {{--<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
                    {{--</li>--}}
                </ul>
                <form id="custom-search-form" class="form-search form-horizontal pull-right" action="{{ route('frontend.search.index') }}" method="get">
                    <div class="input-append span12">
                        <button type="submit" class="btn"><i class="fas fa-search"></i></button>
                        <input type="text" class="search-query mac-style" placeholder="Tìm kiếm câu hỏi" name="q">
                    </div>
                </form>
            </div>
        </nav>
    </div>
    <div class="menu-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse navbar-menu-content" id="navbarNav">
                    <ul class="navbar-nav nav nav-pills nav-fill root-category" style="width: 100%">
                        @foreach($header_categories as $key=> $category)
                            <li class="nav-item active child-one">
                                @if(count($category->children) > 0)
                                    <a class="nav-link" href="{{ $category->link }}" id="child{{ $category->id }}" role="button" data-toggle="dropdown"
                                    aria-haspopup="false" aria-expanded="true">
                                        {{ $category->name }}
                                    </a>
                                    <div class="dropdown-menu list-columns" aria-labelledby="child{{ $category->id }}" >
                                      <ul class="list-unstyled">
                                        @foreach($category->children as $child)
                                        <li><a class="dropdown-item" href="{{ $child->link }}">{{ $child->name }}</a> </li>
                                            @endforeach
                                      </ul>
                                    </div>
                                    @else
                                    <a class="nav-link" href="{{ $category->link }}">{{ $category->name }}</a>
                                @endif
                            </li>
                            @endforeach
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>

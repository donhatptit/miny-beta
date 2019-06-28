<div class="list-posts">
    <div class="heading d-flex">
        <div class="heading-title" style="margin-right: 60px">
            <h2>Thông tin trường đại học</h2>
        </div>
        <div class="hedding-button d-none d-md-block">

        </div>
        <div class="watch-all-btn ml-auto p-2">
            <a href="{{ route('admission.university.list', [], false) }}">
                Xem tất cả <i class="fa fa-caret-right"></i>
            </a>
        </div>
    </div>
    <div class="horizontal"></div>
    <div class="heading-line"></div>
    <div class="row body">
        @if(count($universities) > 0)
            @foreach($universities->chunk(2) as $desk)
                <div class="col-lg-12">
                    <div class="card-deck">
                        @foreach($desk as $university)
                            <a href="{{ route('university.index', [ 'slug' => $university->slug]) }}"
                               class="card card-post smooth col-lg-6">
                                <div class="card-body">
                                    <h2 class="card-title">
                                        {{ $university->vi_name }}
                                    </h2>
                                    <div class="pb-1"></div>

                                    <p class="card-text">
                                        {{ $university->description }}
                                    </p>
                                </div>
                            </a>
                            @endforeach

                    </div>
                </div>
            @endforeach
        @else
            Không có bài viết nào
        @endif
    </div>
    <div class="mb-3"></div>
</div>
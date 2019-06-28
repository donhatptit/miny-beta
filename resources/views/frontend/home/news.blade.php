<div class="list-posts">
    <div class="heading d-flex">
        <div class="heading-title" style="margin-right: 60px">
            <h2>Tin tức tuyển sinh mới nhất</h2>
        </div>
        <div class="hedding-button d-none d-md-block">

        </div>
        <div class="watch-all-btn ml-auto p-2">
            <a href="{{ route('admission.university.news', [], false) }}">
                Xem tất cả <i class="fa fa-caret-right"></i>
            </a>
        </div>
    </div>
    <div class="horizontal"></div>
    <div class="heading-line"></div>
    <div class="row body">
        @if(count($news_posts) > 0)
            @foreach($news_posts->chunk(2) as $desk)
                <div class="col-lg-12">
                    <div class="card-deck">
                        @foreach($desk as $post)
                            <a href="{{ route('admission.university.post', ['slug' => $post->slug], false) }}"
                               class="card card-post smooth col-lg-6">
                                <div class="card-body">
                                    <h2 class="card-title">
                                        {{ $post->title }}
                                    </h2>
                                    <div class="pb-1"></div>

                                    <p class="card-text">
                                        {{ $post->description }}
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
<div class="card card-post">
    <div class="card-body">
        <h2 class="card-title">
            <a href="{{ route('frontend.post.detail', [
                'slug' => $post->slug
            ], false) }}" class="card-link">
                {{ $post->title }}
            </a>
        </h2>
        <div class="d-flex bd-highlight mb-3 post-info">
            <div class="mr-auto bd-highlight">
                {{--<a href="#" class="card-link card-username">--}}
                    {{--{{ $post->user->name or 'Ẩn danh' }}--}}
                {{--</a>--}}
            </div>
            <div class="bd-highlight" style="color: #999999; font-size: 13px;">
{{--                @include('frontend.includes.post_info_number')--}}
            </div>
        </div>

        <p class="card-text">
            {{ $post->description }}
        </p>
    </div>
</div>
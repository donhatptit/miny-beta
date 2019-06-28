@php
    if (!isset($col)){
        $col = 6;
    }
@endphp
<div class="list-posts">
    <div class="heading d-flex">
        <div class="heading-title" style="margin-right: 60px">
            <h2>{{ $list_title or ''}}</h2>
        </div>
        @if(isset($button_display) && $button_display == true)
        <div class="hedding-button d-none d-md-block">
            <?php $i = 0; ?>
            @foreach($list_category->children as $child)
                @if($i > 4)
                    @break
                @endif
                <a href="{{ $child->link }}" class="btn btn-outline-success btn-outline-category">
                    {{ $child->name }}
                    <?php $i++; ?>
                </a>

            @endforeach
        </div>
        @endif
        <div class="ml-auto p-2">
            <a href="{{ $list_category->link or '#' }}">
                Xem tất cả <i class="fas fa-caret-right"></i>
            </a>
        </div>
    </div>
    <div class="heading-line"></div>
    <div class="row body">
        @if(count($list_posts) > 0)
            @foreach($list_posts as $post)
                <div class="
                        @if($col == 6)
                            col-lg-6
                        @elseif($col == 12)
                            col-lg-12
                        @endif
                        ">
                    @include('frontend.includes.post_item', ['$post' => $post])
                </div>
            @endforeach
        @else
            Không có bài viết nào
        @endif
    </div>
</div>
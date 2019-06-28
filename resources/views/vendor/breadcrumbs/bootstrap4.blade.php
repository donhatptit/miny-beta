@if (count($breadcrumbs))

    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)

            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">
                    <a href="{{ $breadcrumb->url }}" itemprop="url">
                        <span itemprop="title">{{ $breadcrumb->title }}</span>
                    </a>
                </li>
            @else
                <li class="breadcrumb-item active" itemscope="itemscope">
                    <span itemprop="title">{{ $breadcrumb->title }}</span>
                </li>
            @endif

        @endforeach
    </ol>

@endif
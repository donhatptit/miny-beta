<footer id="footer">
    <div class="container">
        <div class="text-center footer-1">
            <a href="{{ url('/') }}" rel="nofollow">
                <img src="{{ url(config('app.logo')) }}">
            </a>
        </div>
        <div class="footer-2 d-none d-md-block">
            <div class="d-flex bd-highlight footer-menu">
                @foreach($footer_categories as $category)
                    <div class="flex-fill bd-highlight text-center menu-item">
                        <a href="{{ $category->link }}">{{ $category->name }}</a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="text-center footer-3">
            Copyright &copy; 2018 CungHocVui
        </div>
    </div>
</footer>
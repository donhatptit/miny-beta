@extends('vendor.backpack.base.layout')
@section('after_styles')
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />


    <!-- elFinder CSS (REQUIRED) -->
    <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset($dir.'/css/theme.css') }}">
@endsection

@section('after_scripts')
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <!-- elFinder JS (REQUIRED) -->
    <script src="{{ asset($dir.'/js/elfinder.min.js') }}"></script>
    @if($locale)
        <!-- elFinder translation (OPTIONAL) -->
        <script src="{{ asset($dir."/js/i18n/elfinder.$locale.js") }}"></script>
    @endif
    <!-- elFinder initialization (REQUIRED) -->
    <script type="text/javascript" charset="utf-8">
        /** Documentation for client options: */
        /** https://github.com/Studio-42/elFinder/wiki/Client-configuration-options */
        $().ready(function() {
            $('#elfinder').elfinder({
                /** set your elFinder options here */
                @if($locale)
                lang: '{{ $locale }}',
                @endif
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url : '{{ route("elfinder.connector") }}',
                soundPath: '{{ asset($dir.'/sounds') }}'
            });
        });
    </script>
        @endsection

@section('content')

    <!-- Element where elFinder will be created (REQUIRED) -->
    <div id="elfinder"></div>

@endsection
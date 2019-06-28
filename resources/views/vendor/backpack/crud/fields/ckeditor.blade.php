<!-- CKeditor -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <textarea
            id="ckeditor-{{ $field['name'] }}"
            name="{{ $field['name'] }}"
            @include('crud::inc.field_attributes', ['default_class' => 'form-control'])
    >{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}</textarea>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script src="{{ asset('vendor/backpack/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/backpack/ckeditor/adapters/jquery.js') }}"></script>
    @endpush

@endif

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
    <script>
        jQuery(document).ready(function($) {
            $('#ckeditor-{{ $field['name'] }}').ckeditor({
                "filebrowserBrowseUrl": "{{ url(config('backpack.base.route_prefix').'/elfinder/ckeditor') }}",
                "extraPlugins" : '{{ isset($field['extra_plugins']) ? implode(',', $field['extra_plugins']) : 'justify,oembed,widget,dialog,mathjax,tableresize,contents,font' }}',
                "mathJaxLib" : 'https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.0/MathJax.js?config=TeX-AMS_HTML'
            });
        });
// them rel=nowfollow cho external link
        CKEDITOR.on('instanceReady', function(ev) {
            var editor = ev.editor;
            editor.dataProcessor.htmlFilter.addRules({
                elements : {
                    a : function( element ) {
                        if ( !element.attributes.rel ){
                            //gets content's a href values
                            var url = element.attributes.href;
                            //extract host names from URLs
                            var hostname = (new URL(url)).hostname;
                            if ( hostname !== window.location.host && hostname !=="{{ config('app.url') }}") {
                                element.attributes.rel = 'nofollow';
                            }
                        }
                    }
                }
            });
        })
    </script>
@endpush

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}

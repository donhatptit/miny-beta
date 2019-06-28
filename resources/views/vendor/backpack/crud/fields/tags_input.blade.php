<!-- text input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    @if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
        @if(isset($field['prefix'])) <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
        <input
                type="text"
                name="{{ $field['name'] }}"
                value="{{ old($field['name']) ?? $field['value'] ?? $field['default'] ?? '' }}"
                data-role="tagsinput"
                id="input_tag"
                @include('crud::inc.field_attributes')
        >
        @if(isset($field['suffix'])) <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif
        @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


{{-- FIELD EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

 @push('crud_fields_styles')
     <link rel="stylesheet" href="{{ url('frontend/plugins/BootstrapTagsInput/bootstrap-tagsinput.css') }}" type="text/css" />
     <style>
         .bootstrap-tagsinput{
             width:100%;
         }
     </style>
@endpush


{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

 @push('crud_fields_scripts')
     <script src="{{ url('frontend/plugins/BootstrapTagsInput/bootstrap-tagsinput.js') }}"></script>
     <script>
         $(document).keypress(
             function(event){
                 if (event.which == '13') {
                     event.preventDefault();
                 }
             });
         $("button[type=submit]").click(function (event) {
             tags = $('#input_tag').val();
             count_tag = tags.split(",").length;
             if(count_tag < 3){
                 new PNotify({
                     title: 'Thông báo : ',
                     text: 'Số lượng Tag bạn nhập phải từ 3 trở lên',
                     icon: 'fa fa-envelope-o',
                     type : 'warning'
                 });
                 event.preventDefault();

             }


         });
     </script>
@endpush


{{-- Note: you can use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load some CSS/JS once, even though there are multiple instances of it --}}
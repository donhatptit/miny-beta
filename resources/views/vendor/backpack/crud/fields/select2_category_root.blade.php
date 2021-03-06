<!-- select2 -->
@php
    $current_value = old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' ));
@endphp

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <select
        name="cate_root"
        style="width: 100%"
        @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2_field select_ajax'])
        >

            <option value="" selected>Chọn lớp</option>
        @if (isset($field['model']))
            @foreach ($field['model']::all() as $connected_entity_entry)
                @if($connected_entity_entry->depth == 0)
                @if($current_value == $connected_entity_entry->getKey())
                    <option value="{{ $connected_entity_entry->getKey() }}" selected>{{ $connected_entity_entry->{$field['attribute']} }}</option>
                @else
                    <option value="{{ $connected_entity_entry->getKey() }}">{{ $connected_entity_entry->{$field['attribute']} }}</option>
                @endif
                @endif
            @endforeach
        @endif
    </select>

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
        <!-- include select2 css-->
        <link href="{{ asset('vendor/adminlte/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- include select2 js-->
        <script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
        <script>
            jQuery(document).ready(function($) {
                // trigger select2 for each untriggered select2 box
                $('.select2_field').each(function (i, obj) {
                    if (!$(obj).hasClass("select2-hidden-accessible"))
                    {
                        $(obj).select2({
                            theme: "bootstrap"
                        });
                    }
                });
                // gui request ajax;
                $('.select_ajax').on('change', function() {
                    var id_category = this.value;
                    $.ajax({
                        url: "{{ $field['data_source'] }}",
                        dataType: 'json',
                        method: 'GET',
                        data : { id_category : id_category, type : 'root'},

                        success: function success(data) {
                            console.log(data);
                            $('.category_child_one').find('option').remove().end().append('<option value= "" selected>Chọn môn</option>');
                            for (var i = 0; i < data.length; i++) {

                                $('.category_child_one').append($('<option>', {
                                    value: data[i].id,
                                    text: data[i].name
                                }));
                            }

                            $('.category_id').find('option').remove().end().append('<option value= "" selected>Chọn môn</option>');
                            for (var i = 0; i < data.length; i++) {

                                $('.category_id').append($('<option>', {
                                    value: data[i].id,
                                    text: data[i].name
                                }));
                            }
                        }
                    });
                });


            });

        </script>
    @endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}
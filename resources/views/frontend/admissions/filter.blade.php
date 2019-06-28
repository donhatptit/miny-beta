<div class="fillter-university" style="background-color:white">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <form class="form-inline" style="margin-top: 10px;" action="{{ route('admission.university.list') }}">
                    <div class="location-province col-md-3 col-sm-12 select-filter">
                        <select id="province" tabindex="-1" aria-hidden="true" name="province" class="select-custom">
                            <option value="">Tỉnh thành</option>
                            @foreach($locations as $location)

                                <option value="{{ $location->id }}"
                                        @if($location->id == request()->get('province'))
                                        selected = "selected"
                                        @endif
                                >{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="location-district select-filter col-md-3 col-sm-12">
                        <select id="district" class="select-custom" tabindex="-1" aria-hidden="true" name="district" old-value ="{{ request()->get('district')}}">
                            <option value="">Quận huyện</option>

                        </select>
                    </div>
                    <div class="type-university select-filter col-md-3 col-sm-12">
                        <select id="university" class="select-custom" tabindex="-1" aria-hidden="true" name="type">
                            <option value="" >Loại cơ sở</option>
                            <option value="0">Đại học</option>
                            <option value="1" >Cao đẳng</option>

                        </select>
                    </div>
                    <div class="button-search col-md-3 col-sm-12">
                        <button class="btn btn-primary btn-sm" type="submit">Tìm kiếm</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
                <form class="form-inline">
                    <div id="custom-search-input">
                        <div class="input-group col-md-12 p-0">
                            <input type="text" class="form-control input-lg" name="university-name" placeholder="Tên trường , mã trường ..."  value="{{ request()->get('university-name')  }}"/>
                            <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="submit" style="margin-top:5px">
                            <i class="fas fa-search"></i>
                        </button>
                    </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('after-scripts')
    <script>
        // thuc hien filter
        $('#province').on('change', function(){
            fillDistrict();

        });
        if($('#province').val() !== ''){
            fillDistrict();
        }
        function fillDistrict(){
            var province_id = $('#province').val();
            $.get('{{ route('admission.university.filter_district') }}',
                { 'province_id' : province_id },
                function(data){
                    old_district = $('#district').attr('old-value');
                    $('#district').find('option')
                        .remove()
                        .end().append('<option value= "" selected>Quận huyện</option>');
                    for (let i = 0; i < data.length; i++) {

                        $('#district').append($('<option>',
                            {
                                value: data[i].id,
                                text: data[i].name,
                            }));
                        if (data[i].id == old_district) {
                            $('#district').val(old_district).trigger('change.select2');
                        }
                    }
                });
        }
    </script>
@endpush
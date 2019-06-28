<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
    <div class="row">
        <div class="col-md-12">
            <p>Avatar : <img src="{{ config('app.url') . "/" . $entry->avatar }}" alt="" width ="100px" height="100px"></p>
        </div>
        <div class="col-md-12">
            <p>Thông tin chung</p>
            <p><b>Vi Name : </b>{{ $entry->vi_name }}</p>
            <p><b>En Name : </b>{{ $entry->en_name }}</p>
            <p><b>Mã trường :</b> {{ $entry->code }}</p>
            <p><b>Ký hiệu trường:</b> {{ $entry->keyword }}</p>
            <p><b>Địa chỉ :</b> {{ $entry->address }}</p>
            <p><b>Số điện thoại :</b> {{ $entry->phone }}</p>
            <p><b>Ngày thành lập :</b> {{ $entry->established }}</p>
            <p><b>Loại hình :</b> {{ $entry->type == 0 ? "Công lập" : "Dân lập" }}</p>
            <p><b>Trực thuộc :</b> {{ $entry->organization }}</p>
            <p><b>Quy mô : </b> {{ $entry->scale }}</p>
            <p><b>Website: </b> <a href="{{ $entry->website }}">{{ $entry->website }}</a></p>
            <p><b>Hình thức đào tạo: </b>{{ $entry->kind == 0 ? "Đại học" : "Cao đẳng" }}</p>
        </div>
        <div class="col-md-12" style="float:left">
            <p><b>Tổng số ảnh mô tả : </b> {{ count($images) }} Ảnh</p>
            @foreach($images as $img)
                <?php
                list($width, $height, $type, $attr) = getimagesize(config('app.url') . "/" . $img->path);
                ?>
            <div class="col-md-2" style="margin:auto">
                <img src="{{ config('app.url') . "/" . $img->path }}" alt="" height="100px" width ="100%">
                <p><a href="{{ config('app.url') . "/" . $img->path }}" target="_blank"><b>{{ $width }} x {{ $height }}pixels</b></a></p>
            </div>
                @endforeach
        </div>
    </div>
</div>
<div class="clearfix"></div>
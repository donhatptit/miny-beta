<style>
    .fade{
        opacity: 1 !important;
    }
</style>

<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
    <div class="row">
        <div class="col-md-12">
            <label> Phương trình </label>
            {!! $entry->equation !!}
        </div>
        <div class="col-md-12">
            <label> Điều kiện</label>
            {!! $entry->condition !!}
        </div>
        <div class="col-md-12">
            <label> Cách thực hiện </label>
            {!! $entry->execute !!}
        </div>
        <div class="col-md-12">
            <label> Hiện tượng  </label>
            {!! $entry->phenomenon !!}
        </div>
        <div class="col-md-12">
            <label> Thông tin thêm </label>
            {!! $entry->extra !!}
        </div>
    </div>
</div>
<div class="clearfix"></div>
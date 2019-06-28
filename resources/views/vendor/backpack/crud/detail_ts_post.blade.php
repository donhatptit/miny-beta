<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
    <div class="row">
        <div class="col-md-12">
            <p><b>Description</b>: {{ $entry->description }}</p>
        </div>

        <div class="col-md-12">
            <p><b>Content :</b></p>
            <div class="card">
                {!! $entry->content !!}
            </div>

        </div>
    </div>
</div>
<div class="clearfix"></div>
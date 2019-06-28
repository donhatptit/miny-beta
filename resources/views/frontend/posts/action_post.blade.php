
<span class="px-3 font-weight-bold">Google : </span>
<div class="btn-group" role="group" aria-label="Button group with nested dropdown" name ="{{ route('backend.action.post') }}" value ="{{ $post->id }}" id="btn-route">
    <button type="button" class="btn btn-sm btn-primary" value ="{{  $post->is_public }}" id="btn_public">{{ $post->is_public == 1 ? 'Đã hiển thị ' : 'Ẩn' }}</button>
    <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #FFA000">
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="font-size:13px;">
            @if($post->is_public ==0)
                <a class="dropdown-item action_public" href="#" value = "1" >Hiển thị</a>
            @else
                <a class="dropdown-item action_public" href="#" value ="0" >Ẩn</a>
            @endif
        </div>
    </div>
</div>
<span class="px-3 font-weight-bold">Trạng thái</span>
<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
    <button type="button" class="btn btn-primary btn-sm" id="btn_approve" value="{{ $post->is_approve }}">
        @if ($post->is_approve == 1)
            {{ 'Đã duyệt' }}
        @elseif ($post->is_approve == 0)
            {{ 'Chưa duyệt' }}
        @else
            {{'Không duyệt'}}
        @endif

    </button>
    <div class="btn-group" role="group">
        <button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #FFA000">
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="font-size:13px">
            @if($post->is_approve == 0)
                <a class="dropdown-item action_post" value ="1" href="#">Duyệt</a>
                <a class="dropdown-item " href="#reason" data-toggle="modal" data-target="#reason">Không duyệt</a>
            @elseif($post->is_approve == 1)
                <a class="dropdown-item action_post" value ="0" href="#" >Bỏ duyệt</a>
            @elseif($post->is_approve == -1)
                <a class="dropdown-item action_post" value ="1" href="#">Duyệt lại</a>
            @endif
        </div>
    </div>
</div>

<button class="btn btn-sm btn-info ml-3" id="save_action" disabled="true" data-toggle="modal" data-target="modal">Lưu</button>

{{--Hộp thoại popup lý do --}}

<!-- Modal -->
<div class="modal fade show" id="reason" tabindex="-1" role="dialog" aria-labelledby="reason" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('backend.action.post') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lý do</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" value="-1" name="action" hidden>
                        <input type="text" value ="{{ $post->id }}" name="id_post" hidden>
                        <textarea class="form-control" rows="5" id="comment" name="reason"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

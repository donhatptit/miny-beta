<form class="form-inline">
<div class="input-group mb-3">
    <div class="input-group-prepend">
        <label class="input-group-text" for="inputGroupSelect01">Google</label>
    </div>
    <select class="custom-select question_public" id="public_question">
        <option value="0" {{ $current_category->is_public == 0 ? "selected" : ''}}>Ẩn</option>
        <option value="1" {{ $current_category->is_public == 1 ? "selected" : ''}}>Hiển thị</option>
    </select>
</div>
    <div class="input-group mb-3 mx-3">
        <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect01">Trạng thái</label>
        </div>
        <select class="custom-select question_approve" id="approve_question">
            @if($current_category->is_approve !== -1)
            <option value="0" {{ $current_category->is_approve == 0 ? "selected" : ''}} >Chưa duyệt</option>
            <option value="1" {{ $current_category->is_approve == 1 ? "selected" : ''}}>Đã duyệt</option>
            <option value="-1"  {{ $current_category->is_approve == -1 ? "selected" : ''}} >Không duyệt</option>
                @else
                <option value="-1"  {{ $current_category->is_approve == -1 ? "selected" : ''}} >Không duyệt</option>
                <option value="1">Duyệt lại </option>
            @endif
        </select>
    </div>
    <button type="submit" class="btn btn-primary mb-3 save_status" data-link = "{{ route('frontend.question.status') }}" value="{{ $current_category->id }}" >Lưu</button>
</form>
<div class="modal fade show" id="reason" tabindex="-1" role="dialog" aria-labelledby="reason" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lý do</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea class="form-control" rows="5" id="comment" name="reason"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger save_status " data-dismiss="modal" data-link = "{{ route('frontend.question.status') }}" value="{{ $current_category->id }}">Đồng ý</button>
                </div>
        </div>
    </div>
</div>
<div id="message" tabindex="-1" class="bootbox modal show bd-example-modal-sm" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header pb-0">
                <h4 class="modal-title font-weight-bold">Err</h4>
            </div>
            <div class="modal-body py-1">
                <div class="bootbox-body"></div>
            </div>
            <div class="modal-footer py-2">
                <button class="btn btn-primary btn-sm" id="button_close" type="button" data-bb-handler="cancel"><i class="fa fa-times"></i> Đóng</button>
            </div>
        </div>
    </div>
</div>


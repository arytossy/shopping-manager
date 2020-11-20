<div class="modal fade" id="{{ $modal_name }}Dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $modal_title }}</h5>
        <button class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body overflow-auto" style="max-height: 50vh;">
        {{ $slot }}
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
        <button class="btn btn-success" form="{{ $modal_name }}Form">{{ $go_text }}</button>
      </div>
    </div>
  </div>
</div>
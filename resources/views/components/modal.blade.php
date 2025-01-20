<div class="modal {{ $style ?? ''}} fade p-1" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $labelId }}" aria-hidden="true" style="display: none;">
  <div class="modal-dialog {{ $size ?? 'modal-md' }}">
    <form id="{{ $formId }}" method="POST" {{ $attributes }}>
      @csrf
      @if(strtoupper($method) !== 'POST')
        @method($method)
      @endif
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="{{ $labelId }}">
            {{ $title }}
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{ $slot }}
        </div>
        <div class="modal-footer">
          @if($showSaveButton ?? true)
          <button type="submit" class="font-medium btn btn-light-success text-success waves-effect" id="btn">
            <span class="spinner-border spinner-border-sm d-none" id="btn-loading-spinner" role="status" aria-hidden="true"></span>
            {{ $saveButtonText ?? 'Save' }}
          </button>
          @endif
          <button type="button" class="font-medium btn btn-light-danger text-danger waves-effect" data-bs-dismiss="modal">
            {{ $closeButtonText ?? 'Close' }}
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

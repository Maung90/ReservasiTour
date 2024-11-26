@props(['id' => 'loading-spinner'])
@if($id =='loading-spinner')
<div id="{{$id}}" class="d-none position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="z-index: 1055; ">
    <div class="spinner-border" style="width: 3rem; height: 3rem" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
@else
<div id="{{$id}}" class="d-none d-flex align-items-center justify-content-center" style="z-index: 1055; ">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
@endif

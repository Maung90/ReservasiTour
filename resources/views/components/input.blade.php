@props(['id' => 'nama', 'name' => 'nama', 'type' => 'text'])
<div class="form-group">
    <label for="{{$id}}">{{ $slot }}</label>
    <input type="{{$type}}" class="form-control" name="{{$name}}" id="{{$id}}" required autocomplete="off">
</div>
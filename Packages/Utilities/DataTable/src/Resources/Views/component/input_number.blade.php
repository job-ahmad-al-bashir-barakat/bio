@php
    extract($gridSystemResult);
@endphp

<div class='form-group {{ $global }}'>
    <label class='{{ $label }} control-label' for='{{$name}}'>{{ $title }} @if($star) <span class='text-danger'>*</span> @endif </label>
    <div class='{{ $input }}'>
        <input id='{{ $id }}'
               data-datavalue='{{ $data }}'
               name='{{ $name }}'
               type='{{ $type }}'
               placeholder='{{ $placeholder }}'
               class='form-control {{ $class }}'
               data-editable = 'true'
               {{ $attr }}
        >
        <div id='error_{{ $id }}'></div>
    </div>
</div>
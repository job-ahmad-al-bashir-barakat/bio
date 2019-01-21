@php
    extract($gridSystemResult);
@endphp

<div class='form-group {{ $global }}'>
    @if(!matchClass('noLabel' ,$class))
        <label class='{{ $label }} control-label' for='{{ $name }}'>{{ $title }} @if($star) <span class='text-danger'>*</span> @endif </label>
    @endif
    <div class='{{ $input }}'>
        <textarea id='{{ $id }}'
                  data-datavalue='{{ $data }}'
                  name='{{ $name }}'
                  placeholder='{{ $placeholder }}'
                  class='form-control {{ $class }}'
                  style='resize:vertical; overflow-x: hidden;'
                  data-editable = 'true'
                  dir="{{ config("datatable.local_direction.$datatable_lang") }}"
                  {{ $attr }}
        ></textarea>
        <div id='error_{{ $id }}'></div>
    </div>
</div>
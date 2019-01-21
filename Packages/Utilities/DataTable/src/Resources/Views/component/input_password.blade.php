@php
    extract($gridSystemResult);
@endphp

<div class='form-group {{ $global }}'>
    <label class='{{ $label }} control-label' for='{{ $name }}'>{{ $title }} @if($star) <span class='text-danger'>*</span> @endif </label>
    <div class='{{ $input }}'>

        <div id='{{ $name }}_group' class='input-group'>
            <input id='{{ $id }}'
                   data-datavalue='{{ $data }}'
                   name='{{ $name }}'
                   type='{{ $type }}'
                   placeholder='{{ $placeholder }}'
                   class='form-control {{ $class }}'
                   data-editable = 'true'
                   {{ $attr }}
            >
            @if($refresh)
                <span class='input-group-addon {{ $id }}_password btn-refresh' style='cursor: pointer;'>
                    <span class='fa fa-refresh'></span>
                </span>
            @endif
            <span id='icon-password' class='input-group-addon btn-eye' style='cursor: pointer;'>
                <span class='fa fa-eye-slash'></span>
            </span>
        </div>
        <div id='error_{{ $id }}'></div>
    </div>
</div>
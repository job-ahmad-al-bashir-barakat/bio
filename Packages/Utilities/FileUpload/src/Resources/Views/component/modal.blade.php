@php
    $width  = isset($width)  ? $width  : false;
@endphp

<div id='{{ $id ?? '' }}' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' class='modal fade'>
    <div class='modal-dialog' role='document' style="{{ $width ? "min-width: $width;" : "" }}">
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' data-dismiss='modal' aria-label='Close' class='close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                <h4 id='myModalLabel' class='modal-title'>
                    {{ $title ?? '' }}
                </h4>
            </div>
            <div class='modal-body clearfix'>
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

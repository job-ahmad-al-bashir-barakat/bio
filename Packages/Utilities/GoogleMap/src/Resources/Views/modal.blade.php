@php
    $width  = isset($width)  ? $width  : false;
@endphp

<div id='{{ $id or '' }}' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' class='modal fade'>
    <div class='modal-dialog' role='document' style="{{ $width ? "min-width: $width;" : "" }}">
        <div class='modal-content'>

            <div class='modal-header'>
                <button type='button' data-dismiss='modal' aria-label='Close' class='close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                <h4 id='myModalLabel' class='modal-title'>
                    {{ $title or '' }}
                </h4>
            </div>

            <div class='modal-body clearfix {{ $bodyClass or '' }}' {{ $bodyAttr or '' }}>
                {{ $slot }}
            </div>

            <div class='modal-footer'>
                <button type='button' data-dismiss='modal' class='btn btn-default'>{{ trans('gmap::gmap.close') }}</button>
                {{ $footer or '' }}
            </div>
        </div>
    </div>
</div>

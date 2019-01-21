@php
    $id           = isset($id)          ? "id='panel-$id'" : "";
    $class        = isset($class)       ? $class           : '';
    $footer       = isset($footer)      ? $footer          : true;
    $panelType    = isset($panelType)   ? $panelType       : 'default';
    $panelClass   = isset($panelClass)  ? $panelClass      : '';
    $panelAttr    = isset($panelAttr)   ? $panelAttr       : '';
    $panelFooter  = isset($panelFooter) ? $panelFooter     : '';
    $html         = isset($html)        ? $html            : '';
@endphp

<!-- START panel-->
<div {{ $id }} class="panel panel-{{ $panelType }} clearfix {{ $panelClass }}" {{ $panelAttr }}>
    <div class="panel-heading">
        {{ $title }}
    </div>
    <div class="panel-wrapper">
        <div class="panel-body {{ $class or '' }}">
            {!! $slot or $html !!}
        </div>
        @if($footer)
            <div class="panel-footer">
                <div class="clearfix">
                    {{ $panelFooter }}
                </div>
            </div>
        @endif
    </div>
</div>
<!-- END panel-->
@php
    $id    = isset($id)    ? "modal-{$id}-input-location" : 'modal-input-location';
    $title = isset($title) ? $title : '';
    $width = isset($width) ? $width : false;
    extract($extra);
    $stopFooter = isset($stopFooter) ? $stopFooter : true;
@endphp

@component('gmap::modal', [
    'id'         => $id,
    'title'      => $title,
    'width'      => $width,
    'bodyClass'  => 'p-0',
])
    <div class="maps-search hide">
        <input type="text" id="component-maps-search"  class="map-autocomplete controls" type="text" placeholder="{{ trans('gmap::gmap.search_box') }}"/>
    </div>
    <div id="map-location"
         data-gmap=""
         data-address="{{ $geoLocation or '' }}" {{--276 N TUSTIN ST, ORANGE, CA 92867--}}
         data-maptype="ROADMAP"
         data-styled class="gmap"
         data-zoom={{ $zoom or 14 }}
         data-click="{{ $click or 'true' }}"
         data-autocomplete="{{ $autocomplete or 'true' }}"
         data-navigator="{{ $navigator or 'true' }}"
         data-location='{ "location":"#map-full-location" ,"lat":"#map-lat-location" ,"lng":"#map-lng-location" ,"reverseGeoCoding":"#map-reverse-geo-coding" }'
         data-initialize="true"
         data-map-reload="true"
    >
    </div>
    <input type="hidden" id="map-full-location">
    <input type="hidden" id="map-lat-location">
    <input type="hidden" id="map-lng-location">
    <input type="hidden" id="map-reverse-geo-coding">

    {{ $slot or '' }}

    @if($stopFooter)
        @slot('footer')
            <button type="button" class="btn btn-labeled btn-primary set-map-location"
                    data-input-full-location="{{ $inputFullLocation or '' }}"
                    data-input-lat-location="{{ $inputLatLocation or '' }}"
                    data-input-lng-location="{{ $inputLngLocation or '' }}"
                    data-input-reverse-geo-coding="{{ $inputReverseGeoCoding or '' }}">
                {{ trans('gmap::gmap.set_location') }}
                <span class="btn-label btn-label-right"><i class="icon-location-pin"></i></span>
            </button>
            {{ $footer or '' }}
        @endslot
    @endif
@endcomponent

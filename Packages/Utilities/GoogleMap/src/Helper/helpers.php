<?php

if(! function_exists('autGoogleMap'))
{
    /**
     *
     * Return locale url
     *
     * @param $url
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function autGoogleMap
    (
        $id    = '' ,
        $title = '' ,
        $width = '',
        $zoom = 10 ,
        $defaultGeoLocation = '',
        $inputFullLocation = '' ,
        $inputLatLocation  = '',
        $inputLngLocation  = '',
        $inputreverseGeoCoding  = '',
        $extra = [
            'click'        => true,
            'autocomplete' => true,
            'navigator'    => true,
            'stopFooter'   => true
        ]
    )
    {
        return view('gmap::input_location', [
            'id'                     => $id,
            'title'                  => $title ? $title : trans('gmap::gmap.gelocation'),
            'width'                  => $width ? $width : '',
            'zoom'                   => $zoom  ? $zoom : 10,
            'geoLocation'            => $defaultGeoLocation,
            'inputFullLocation'      => $inputFullLocation ? $inputFullLocation : '',
            'inputLatLocation'       => $inputLatLocation  ? $inputLatLocation : '',
            'inputLngLocation'       => $inputLngLocation  ? $inputLngLocation : '',
            'inputReverseGeoCoding'  => $inputreverseGeoCoding ? $inputreverseGeoCoding : '',
            'extra'                  => $extra ? $extra : [
                'click'        => true,
                'autocomplete' => true,
                'navigator'    => true,
                'stopFooter'   => true,
            ],
        ])->render();
    }
}


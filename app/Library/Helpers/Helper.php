<?php

if(! function_exists('lang'))
{
    function lang($col='',$alias = '')
    {
        $lang = \App::getLocale();
        $col = "{$col}_{$lang}";
        if($alias != '') $col = "$col as $alias";
        return $col;
    }
}

if(! function_exists('human_filesize'))
{
    function human_filesize($bytes) {
        if(!$bytes) return $bytes;
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), [0,0,2,2,3][$i]).['','k','M','G','T'][$i];
    }
}

if(! function_exists('geolocation'))
{
    function geolocation($location) {

        $location = explode(',',$location);

        $result = [];
        $geolocationTitle = [];
        $geolocationSearch = '';

        foreach (\LaravelLocalization::getSupportedLanguagesKeys() as $lang)
        {
            $geolocationTitle[$lang] = \Geocoder::setLanguage($lang)->getAddressForCoordinates($location[0] ,$location[1])['formatted_address'];
            $geolocationSearch      .= \Geocoder::setLanguage($lang)->getAddressForCoordinates($location[0] ,$location[1])['formatted_address'] . ' - ';
        }

        $result['geolocationTitle']  = $geolocationTitle;
        $result['geolocationSearch'] = replaceSearchGeolocation($geolocationSearch,false);

        return  $result;
    }
}


if(! function_exists('pageFrom'))
{
    function pageFrom($obj)
    {
        $total = $obj->total();

        if(!$total)
            return 0;

        $count = ($obj->currentPage() - 1) * $obj->perPage();

        return $count == 0 ? 1 : $count;
    }
}

if(! function_exists('pageTo'))
{
    function pageTo($obj)
    {
        $count = $obj->currentPage() * $obj->perPage();

        $total = $obj->total();

        return $count > $total ? $total : $count;
    }
}

if(! function_exists('replaceSearch'))
{
    function replaceSearch($words) {

        return '%'. preg_replace('/\s/','%',$words) .'%';
    }
}

if(! function_exists('replaceSearchRegex'))
{
    function replaceSearchRegex($words) {

        $search = preg_replace('/(،|-|,)/',' ',$words);
        $search = trim(preg_replace('/\s+/',' ',$search));

        return preg_replace('/\s/','|',$search).'| ';
    }
}

if(! function_exists('replaceSearchGeolocation'))
{
    function replaceSearchGeolocation($words, $isSearch = true) {

        $search = preg_replace('/(،|-|,)/',' ',$words);
        $search = trim(preg_replace('/\s+/',' ',$search));

        if($isSearch)
            return '%'. preg_replace('/\s/','%',$search) .'%';
        else
            return $search;
    }
}

if(! function_exists('websiteUrl'))
{
    function websiteUrl($website) {

        return preg_replace("((.+)?//)",'',$website);
    }
}

if(! function_exists('replaceImageUrl'))
{
    function replaceImageUrl($image ,$folder = 'users' ,$defaultImage = 'img/avatar.jpg') {

        if($image && $image->image)
            $image = preg_replace("({folder})",$folder ,$image->image->image_url);
        // else if(Auth::check() && Auth::user()->image)
        //    $image = preg_replace("({folder})",'users' ,Auth::user()->image->image_url);
        else
            $image = asset($defaultImage);

        return $image;
    }
}


if(! function_exists('position')) {

    /**
     *
     * return position left => ltr or right => rtl
     *
     * @return string
     */
    function position($pascalCase = false)
    {
        if(LaravelLocalization::getCurrentLocaleDirection() == 'ltr')
        {
            $position = 'left';
        }
        else
        {
            $position = 'right';
        }

        return $pascalCase == true ? str($position)->toPascalCase() : $position;
    }
}


if(! function_exists('reversePosition')) {


    /**
     *
     * return position right => ltr or left => rtl
     *
     * @return string
     */
    function reversePosition($pascalCase = false)
    {
        if(LaravelLocalization::getCurrentLocaleDirection() == 'ltr')
        {
            $position = 'right';
        }
        else
        {
            $position = 'left';
        }

        return $pascalCase == true ? str($position)->toPascalCase() : $position;
    }
}
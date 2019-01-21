<?php

use Illuminate\Support\Str;

if(! function_exists('autAutocompleteLang'))
{
    function autAutocompleteLang($col='',$alias = '')
    {
        $lang = \App::getLocale();
        $col = "{$col}_{$lang}";
        if($alias != '') $col = "$col as $alias";
        return $col;
    }
}

if(! function_exists('autocompleteURL'))
{
    function autocompleteURL($url = '')
    {
        $url = \Illuminate\Support\Str::contains($url ,'autocomplete') ? "/$url" : "/autocomplete/$url";

        return url(\LaravelLocalization::getCurrentLocale().$url);
    }
}

if(! function_exists('autAutocompleteEval'))
{
    function autAutocompleteEval($object ,$multi = false ,$id = 'id' ,$name = 'name') {

        if(is_null($object))
        {
            return [];
        }
        else
        {
            if ($multi)
                return $object->pluck(autAutocompleteLang($name), $id)->toArray();
            else
                return [$object->$id => $object->{autAutocompleteLang($name)}];
        }
    }
}

if(! function_exists('autAutocomplete'))
{
    function autAutocomplete($id = 'id', $name = 'id' ,$remoteUrl = '' ,$option = [] ,$class = '' ,$placeholder = '' ,$letter = 0 ,$attr = [] ,$tags = false) {

        return view('autocomplete::component.autocomplete',[
            'id'          => $id,
            'name'        => $name,
            'remoteUrl'   => $remoteUrl,
            'option'      => $option,
            'class'       => $class,
            'placeholder' => $placeholder,
            'letter'      => $letter,
            'attr'        => $attr,
            'tags'        => $tags,
        ])->render();
    }
}

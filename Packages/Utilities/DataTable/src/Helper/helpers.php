<?php

if(! function_exists('datatableLocalizeURL'))
{
    /**
     *
     * Return locale url
     *
     * @param $url
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    function datatableLocalizeURL($url = '')
    {
        $url = \Illuminate\Support\Str::startsWith($url,'/') ? $url : "/{$url}" ;

        return url(\LaravelLocalization::getCurrentLocale()."$url");
    }
}

if(! function_exists('datatable'))
{

    /**
     * @param string $dataModel
     * @param string $dataParam
     * @param bool $dataLoad
     * @return string
     */
    function datatable($dataModel = '' , $dataParam = '' , $dataLoad = true)
    {
        $url = datatableLocalizeURL("datatable/$dataModel/table/create{$dataParam}");

        $cont = "<div class='datatable' data-table='$dataModel' role='datatable' data-load='$dataLoad' data-url='$url'></div>";

        return $cont;
    }
}

if(! function_exists('gridSystem'))
{
    /**
     * @param string $dataModel
     * @param string $dataParam
     * @param bool $dataLoad
     * @return string
     */
    function gridSystem($cols ,$type)
    {
        $result = '';

        if(preg_match('/|/',$cols))
            $cols = explode('|' ,$cols);
        else
            $cols = [$cols];

        if(preg_match('/|/',$type))
            $type = explode('|' ,$type);
        else
            $type = [$type];


        foreach ($type as $index => $type)
        {
            $col = isset($cols[$index]) ? $cols[$index] : $cols[0];

            $result .= " col-$type-$col";
        }

        return $result;
    }

}

if(! function_exists('gridSystemResult'))
{

    function gridSystemResult($enableGridSystem ,$gridSystem){

        if($enableGridSystem)
        {
            if(!$gridSystem['formHorizontal'])
            {
                $global = isset($gridSystem['global']) ? gridSystem($gridSystem['global']['cols'] ,$gridSystem['global']['type']) : '';
                $label  = '';
                $input  = '';
            }
            else
            {
                $global = '';
                $label  = isset($gridSystem['label']) ? gridSystem($gridSystem['label']['cols'] ,$gridSystem['label']['type']) : '';
                $input  = isset($gridSystem['input']) ? gridSystem($gridSystem['input']['cols'] ,$gridSystem['input']['type']) : '';
            }
        }
        else
        {
            $global = '';
            $label  = 'col-lg-3';
            $input  = 'col-lg-8';
        }

        return ['global' => $global, 'label' => $label, 'input' => $input];
    }
}

if(! function_exists('autDatatableEval'))
{

    function autDatatableEval($obj){


        return '["]+' . $obj . '+["]' ;
    }
}

if(! function_exists('autConvertString'))
{

    function autConvertString($temp){

        $convertDoubleToSingle = '["]'.preg_replace('/(?!\[)"(?!\])/',"'" ,$temp).'["]';
        $convertFirstLastToDouble = preg_replace('/\["\]/' ,'"' ,$convertDoubleToSingle);
        $removeSpaces = preg_replace('/\s+/', ' ', $convertFirstLastToDouble);

        return $removeSpaces;
    }
}

if(! function_exists('colValue'))
{
    //get prob Val
    function colValue($col ,$obj)
    {
        if(preg_match('/->/',$col))
        {
            $setItem = $obj;
            foreach (explode('->' ,$col) as $item)
                $setItem = $setItem[$item];

            return $setItem;
        }
        else
            return $obj[$col];
    }
}

if(! function_exists('convertArrayToString'))
{
    function convertArrayToString($input ,$additional_string = '')
    {
        $result = '';
        if(is_array($input))
        {
            foreach ($input as $index => $item)
                if(is_numeric($index))
                    $result .= "{$item} ";
                else
                    $result .= "{$index}={$item} ";

            return "$result $additional_string";
        }
        else
            return "$input $additional_string";
    }
}

if(! function_exists('shortIfElse'))
{
    function shortIfElse($condition ,$if ,$else)
    {
        return $condition ? $if : $else;
    }
}

if(! function_exists('matchClass'))
{
    function matchClass($match ,$subject ,&$matches = null ,$flags = 0)
    {
        return preg_match("/\b(?<![\S])($match)(?![\S])\b/",$subject ,$matches ,$flags);
    }
}



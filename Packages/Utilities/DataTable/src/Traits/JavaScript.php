<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 10/23/2016
 * Time: 4:39 PM
 */

namespace Aut\DataTable\Traits;


trait JavaScript
{
    private function replaceScript($script)
    {
        return preg_replace('/<\/?script>/','',$script);
    }

    private function addCustomNavButtonScript($title ,$icon ,$class ,$attr)
    {
        return
        "
            $('#{$this->id}_wrapper .dt-buttons').append(\"<a class='btn btn-default button-style $class' tabindex='0' title='$title' $attr><span><i class='$icon'></i></span></a>\");
        ";
    }
}
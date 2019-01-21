<?php

namespace Aut\FileUpload;

use Form;

class FileUpload
{
    function ImageUpload
    (
        $id = '',
        $name = '',
        $class = '',
        $param = '',
        $imageWidth = null,
        $imageHeight = null,
        $targetModel = [
            'modalId' => '',
            'modalTitle' => '',
            'modalWidth' => '700px'
        ],
        $datatable = '',
        $datatableInitialize = 'true',
        $datatableInitializeProperty = '.image',
        $extraParameter = [
            'maxFileCount' => '0',
            'minFileCount' => '0',
            'minImageWidth' => null,
            'minImageHeight' => null,
            'maxImageWidth' => null,
            'maxImageHeight' => null,
            'allowedFileExtensions' => 'jpeg,jpg,bmp,png',
            'appendLocation' => '',
            'appendName' => '',
            'reloadDatatable' => 'true',
            'fileuploadedEvent' => '',
            'filedeletedEvent' => '',
            'allowedPreviewIcons' => 'false',
            'autoReplace' => 'false',
            'showCaption' => 'false',
            'showPreview' => 'true',
            'allowRatio' => 'false'
        ]
    )
    {
        return Form::ImageUpload($id, $name, $class, $param, $imageWidth, $imageHeight, $targetModel, $datatable, $datatableInitialize, $datatableInitializeProperty, $extraParameter);
    }

    function ImageUploadCropper($width = '90%', $single = false, $showName = true, $showType = false, $showOption = false, $showToggleOption = false, $showPreview = false, $previewType = ['lg', 'md', 'sm', 'xs'] ,$showManager = false)
    {
        return Form::ImageUploadCropper($width, $single, $showName, $showType, $showOption, $showToggleOption, $showPreview, $previewType ,$showManager);
    }
}
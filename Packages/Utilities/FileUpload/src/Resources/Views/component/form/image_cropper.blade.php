@component('fileupload::component.modal' ,[
    'id'         => isset($id) ? $id : 'crop-image',
    'title'      => isset($title) ? $title : trans('fileupload::fileupload.image_cropper'),
    'width'      => isset($width) ? $width : '90%',
])
    @include('fileupload::component.cropper' ,[
        'single'           => isset($single)           ? $single : false,
        'cropperClass'     => isset($cropperClass)     ? $cropperClass : 'aut-cropper-file-upload',
        'showName'         => isset($showName)         ? $showName : true,
        'showOption'       => isset($showOption)       ? $showOption : false,
        'showToggleOption' => isset($showToggleOption) ? $showToggleOption : false,
        'showManager'      => isset($showManager)      ? $showManager : false,
        'showPreview'      => isset($showPreview)      ? $showPreview : false,
        'previewType'      => isset($previewType)      ? $previewType : ['lg' ,'md' ,'sm' ,'xs'],
    ])
@endcomponent

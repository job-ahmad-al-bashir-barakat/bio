@php(extract($extraParameter))
@php(extract($targetModel))
@php(
    $cropRatio = collect(config("fileupload.$id.ratio"))->map(function ($item ,$index) {
        $item['title'] = isset($item['title']) ? trans($item['title']) : $index;
        return $item;
    })
)

@unless(empty($targetModel))
    @component('fileupload::component.modal' ,[
        'id'         => $modalId,
        'title'      => $modalTitle,
        'width'      => isset($modalWidth) ? $modalWidth : '700px',
    ])
@endunless

    <div class="image-cont">
        <div class="ratio-cont">
            <span><b>{{ trans('fileupload::fileupload.allowed_ratio') }}</b></span>
            @foreach($cropRatio as $index => $item)
                <span> [{{ $item['width'] }} × {{ $item['height'] }}] </span>
            @endforeach
        </div>
        <input id="{{$id}}"
               name="{{$name}}"
               type="file"
               class="file-loading upload-file @if($class) {{ $class }} @else load-file @endif"
               data-upload-url="{{ fileUploadLocalizeURL("fileupload/$id/image/upload") }}"
               data-delete-url="{{ fileUploadLocalizeURL("fileupload/$id/image/destroy") }}"
               data-download-folder="{{ \Illuminate\Support\Str::plural($id) }}"
               data-max-file-size="{{ $maxFileSize or 0 }}"
               data-image-width="{{ $imageWidth or null }}"
               data-image-height="{{ $imageHeight or null }}"
               data-min-image-height="{{ $minImageHeight or null }}"
               data-min-image-width="{{ $minImageWidth or null }}"
               data-max-image-height="{{ $maxImageHeight or null }}"
               data-max-image-width="{{ $maxImageWidth or null }}"
               data-max-file-count="{{ $maxFileCount or 0 }}"
               data-min-file-count="{{ $minFileCount or 0 }}"
               data-param="{{ $param or '' }}"
               data-preview-file-type="{{ $previewFileType or "image" }}"
               data-allowed-file-types="{{ $allowedFileTypes or "image" }}"
               data-allowed-file-extensions="{{ $allowedFileExtensions or "jpeg,jpg,bmp,png" }}"
               data-target="#{{ $modalId or '' }}"
               data-cropper="{{ $cropper or 'true' }}"
               data-cropper-selector="{{ $cropperSelector or '.aut-cropper-file-upload' }}"
               data-cropper-modal="{{ $cropperModal or '#crop-image' }}"
               data-allow-ratio="{{ $allowRatio or 'false' }}"
               data-ratio="{{ $cropRatio->toJson() }}"
               data-ratio-message="{{ trans('fileupload::fileupload.ratio' ,['attribute' => '{name}']) }}"
               data-show-caption="{{ $showCaption or 'false' }}"
               data-show-preview="{{ $showPreview or 'true' }}"
               data-datatable="{{ $datatable or ''}}"
               data-reload-datatable="{{ $reloadDatatable or 'true' }}"
               {{--(event, data, previewId, index)--}}
               data-fileuploaded="{{ $fileuploadedEvent or '' }}"
               {{--(event, key, jqXHR, data)--}}
               data-filedeleted="{{ $filedeletedEvent or '' }}"
               data-datatable-initialize="{{ $datatableInitialize or 'true' }}"
               data-datatable-initialize-property="{{ $datatableInitializeProperty or '.image' }}"
               data-remove-label="{{ $removeLabel or trans('fileupload::fileupload.clear') }}"
               data-upload-retry-title="{{ $uploadRetryTitle or trans('fileupload::fileupload.upload_retry_title') }}"
               data-crop-title="{{ $cropTitle or trans('fileupload::fileupload.crop_title') }}"
               data-attribute-title="{{ $attributeTitle or trans('fileupload::fileupload.attribute_title') }}"
               data-append-location="{{ $appendLocation or '' }}"
               data-append-name="{{ $appendName or '' }}"
               data-allowed-preview-icons="{{ $allowedPreviewIcons or 'false' }}"
               data-auto-replace="{{ $autoReplace or 'false' }}"
               multiple
        >
    </div>

@unless(empty($targetModel))
    @endcomponent
@endunless







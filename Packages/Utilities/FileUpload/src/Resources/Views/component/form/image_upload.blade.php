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
               data-max-file-size="{{ $maxFileSize ?? 0 }}"
               data-image-width="{{ $imageWidth ?? null }}"
               data-image-height="{{ $imageHeight ?? null }}"
               data-min-image-height="{{ $minImageHeight ?? null }}"
               data-min-image-width="{{ $minImageWidth ?? null }}"
               data-max-image-height="{{ $maxImageHeight ?? null }}"
               data-max-image-width="{{ $maxImageWidth ?? null }}"
               data-max-file-count="{{ $maxFileCount ?? 0 }}"
               data-min-file-count="{{ $minFileCount ?? 0 }}"
               data-param="{{ $param ?? '' }}"
               data-preview-file-type="{{ $previewFileType ?? "image" }}"
               data-allowed-file-types="{{ $allowedFileTypes ?? "image" }}"
               data-allowed-file-extensions="{{ $allowedFileExtensions ?? "jpeg,jpg,bmp,png" }}"
               data-target="#{{ $modalId ?? '' }}"
               data-cropper="{{ $cropper ?? 'true' }}"
               data-cropper-selector="{{ $cropperSelector ?? '.aut-cropper-file-upload' }}"
               data-cropper-modal="{{ $cropperModal ?? '#crop-image' }}"
               data-allow-ratio="{{ $allowRatio ?? 'false' }}"
               data-ratio="{{ $cropRatio->toJson() }}"
               data-ratio-message="{{ trans('fileupload::fileupload.ratio' ,['attribute' => '{name}']) }}"
               data-show-caption="{{ $showCaption ?? 'false' }}"
               data-show-preview="{{ $showPreview ?? 'true' }}"
               data-datatable="{{ $datatable ?? ''}}"
               data-reload-datatable="{{ $reloadDatatable ?? 'true' }}"
               {{--(event, data, previewId, index)--}}
               data-fileuploaded="{{ $fileuploadedEvent ?? '' }}"
               {{--(event, key, jqXHR, data)--}}
               data-filedeleted="{{ $filedeletedEvent ?? '' }}"
               data-datatable-initialize="{{ $datatableInitialize ?? 'true' }}"
               data-datatable-initialize-property="{{ $datatableInitializeProperty ?? '.image' }}"
               data-remove-label="{{ $removeLabel ?? trans('fileupload::fileupload.clear') }}"
               data-upload-retry-title="{{ $uploadRetryTitle ?? trans('fileupload::fileupload.upload_retry_title') }}"
               data-crop-title="{{ $cropTitle ?? trans('fileupload::fileupload.crop_title') }}"
               data-attribute-title="{{ $attributeTitle ?? trans('fileupload::fileupload.attribute_title') }}"
               data-append-location="{{ $appendLocation ?? '' }}"
               data-append-name="{{ $appendName ?? '' }}"
               data-allowed-preview-icons="{{ $allowedPreviewIcons ?? 'false' }}"
               data-auto-replace="{{ $autoReplace ?? 'false' }}"
               multiple
        >
    </div>

@unless(empty($targetModel))
    @endcomponent
@endunless







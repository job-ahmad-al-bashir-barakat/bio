{{--file upload--}}
{{ FileUpload::ImageUpload('gallery','gallery','','','64','64',[
   'modalId'    => 'gallery-image-upload',
   'modalTitle' => trans('control::app.upload_images')
],'#datatable-gallery','true','.image',['maxFileCount' => '1']) }}

{{ FileUpload::ImageUploadCropper('90%' ,false ,true,false ,false ,false ,true) }}

<script>
    function galleryModal($this) {
        UPLOAD.initFileUploadWithDatatable($this ,'#gallery-image-upload' ,'#datatable-gallery')
    }
</script>
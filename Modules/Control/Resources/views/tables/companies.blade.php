{!! autGoogleMap('companies' ,false ,false ,15 ,'Syria ,Aleppo' ,'#datatable-companies-modal .input-location input',false,false,'#datatable-companies-modal .geolocation') !!}

{{ FileUpload::ImageUpload('company','company','','','64','64',[
   'modalId'    => 'company-image-upload',
   'modalTitle' => trans('control::app.upload_images')
],'#datatable-companies','true','.image',['maxFileCount' => '1']) }}

{{ FileUpload::ImageUploadCropper('90%' ,false ,true,false ,false ,false ,true) }}

{{--skills modal--}}
@component('control.component.modal', [
    'id'            => 'jobs-custom',
    'title'         => trans('control::app.jobs'),
    'bodyClass'     => 'p0',
    'width'         => '70%'
])
    {!! datatable('jobs' ,'' ,'false') !!}
@endcomponent

<script>
    function showFileUploadModal($this) {

        UPLOAD.initFileUploadWithDatatable($this ,'#company-image-upload' ,'#datatable-companies')
    }

    function jobsModal($this) {
        _aut_datatable_custom_merge_datatable_url_open_modal_refresh_datatable('#jobs-custom', "?company=" + $($this).data('key'));
    }
</script>



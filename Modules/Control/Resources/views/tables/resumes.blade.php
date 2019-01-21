{{--map--}}
{!! autGoogleMap('resumes' ,false ,false ,15 ,'Syria ,Aleppo' ,'#datatable-resumes-modal .input-location input',false,false,'#datatable-resumes-modal .geolocation') !!}

{{--file upload--}}
{{ FileUpload::ImageUpload('resume','resume','','','64','64',[
   'modalId'    => 'resume-image-upload',
   'modalTitle' => trans('control::app.upload_images')
],'#datatable-resumes','true','.image',['maxFileCount' => '1']) }}

{{ FileUpload::ImageUpload('work-experience','work-experience','','','64','64',[
   'modalId'    => 'work-experience-image-upload',
   'modalTitle' => trans('control::app.upload_images')
],'#datatable-work-experiences','true','.image',['maxFileCount' => '1']) }}

{{ FileUpload::ImageUploadCropper('90%' ,false ,true,false ,false ,false ,true) }}

{{--skills modal--}}
@component('control.component.modal', [
    'id'            => 'skills-custom',
    'title'         => trans('control::app.skills'),
    'bodyClass'     => 'p0'
])
    {!! datatable('resume-skills' ,'' ,'false') !!}
@endcomponent

{{--educations modal--}}
@component('control.component.modal', [
    'id'            => 'educations-custom',
    'title'         => trans('control::app.educations'),
    'bodyClass'     => 'p0',
    'width'         => '60%'
])
    {!! datatable('resume-educations' ,'' ,'false') !!}
@endcomponent

{{--work experiences modal--}}
@component('control.component.modal', [
    'id'            => 'work-experiences-custom',
    'title'         => trans('control::app.work_experiences'),
    'bodyClass'     => 'p0',
    'width'         => '60%'
])
    {!! datatable('work-experiences' ,'' ,'false') !!}
@endcomponent

<script>
    function showFileUploadModal($this) {
        UPLOAD.initFileUploadWithDatatable($this ,'#resume-image-upload' ,'#datatable-resumes')
    }

    function showWorkExperienceFileUploadModal($this) {
        UPLOAD.initFileUploadWithDatatable($this ,'#work-experience-image-upload' ,'#datatable-work-experiences')
    }

    function skillsModal($this) {
        _aut_datatable_custom_merge_datatable_url_open_modal_refresh_datatable('#skills-custom', "?resume=" + $($this).data('key'));
    }

    function educationsModal($this) {
        _aut_datatable_custom_merge_datatable_url_open_modal_refresh_datatable('#educations-custom', "?resume=" + $($this).data('key'));
    }

    function workExperiencesModal($this) {
        _aut_datatable_custom_merge_datatable_url_open_modal_refresh_datatable('#work-experiences-custom', "?resume=" + $($this).data('key'));
    }
</script>



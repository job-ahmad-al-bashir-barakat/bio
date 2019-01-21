@component('control.component.modal', [
    'id'            => 'comments-custom',
    'title'         => trans('control::app.comments'),
    'bodyClass'     => 'p0',
    'width'         => '70%'
])
    {!! datatable('comments' ,'' ,'false') !!}
@endcomponent

<script>
    function commentsModal($this) {
        _aut_datatable_custom_merge_datatable_url_open_modal_refresh_datatable('#comments-custom', "?id=" + $($this).data('key') + "&type=news");
    }
</script>
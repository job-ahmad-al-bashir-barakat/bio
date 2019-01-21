{{--map--}}
{!! autGoogleMap('job-apply' ,false ,false ,15 ,'Syria ,Aleppo' ,'#job-apply-modal .input-location input') !!}
{{--map readonly--}}
{!! autGoogleMap('read-location' ,false ,false ,15 ,'Syria ,Aleppo',false,false,false,false,[
    'click'        => false,
    'autocomplete' => false,
    'navigator'    => false,
    'stopFooter'   => false
]) !!}

<script>
    // send post when change apply status
    $('.datatable').on('change','.apply-status', function () {
        $.put("{{ datatableLocalizeURL('datatable/resume-apply/table') }}/" + $(this).data('key') ,{ apply_status_id: $(this).val() ,'_method' : 'put' }, function () {
            console.log($(this).val());
        });
    });
    // show read only location
    $('.datatable').on('click', '.input-location-read', function () {

        var $this = $(this),
            $input = $this.prev('input'),
            $modal = '#modal-read-location-input-location';

        $($modal).off('shown.bs.modal').on('shown.bs.modal', function (event) {

            var location = $input.val();
            AUT_GMAP.GMap.init($(this).find('[data-gmap]'), location);
        });

        $($modal).modal('show');
    });
</script>
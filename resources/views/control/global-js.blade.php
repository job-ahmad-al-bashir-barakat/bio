<script>

    var DIR  = "{{ $dir }}",
        LANG = "{{ $lang }}",
        CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
            }
        });
    });
</script>
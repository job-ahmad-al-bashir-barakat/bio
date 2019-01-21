/*---------------------------------------
             datetimepicker
-----------------------------------------*/

var _dateTimePicker = {

    init : function () {
        var $this = $(this);
        var $input = $this.find('input');
        var format = (typeof $input.data('format') !== typeof undefined) ? $input.data('format') : '';

        if($this.data("DateTimePicker"))
            $this.data("DateTimePicker").destroy();

        $this.datetimepicker({
            locale: 'en',
            viewMode: 'years',
            format: format,
            useCurrent:false,
            icons: {
                time: 'fa fa-clock-o',
                date: 'fa fa-calendar',
                up: 'fa fa-chevron-up',
                down: 'fa fa-chevron-down',
                previous: 'fa fa-chevron-left',
                next:  'fa fa-chevron-right',
                today: 'fa fa-crosshairs',
                clear: 'fa fa-trash'
            }
        });
    },

    reload: function(selector) {

        $(selector).each(_dateTimePicker.init);
    },

    diff: {

        change: function(firstDatetimepickerSelector ,secondDatetimepickerSelector) {

            var firstDatetimepicker  = $(firstDatetimepickerSelector).parent().data("DateTimePicker");
            var secondDatetimepicker = $(secondDatetimepickerSelector).parent().data("DateTimePicker");

            if(firstDatetimepicker && firstDatetimepicker.date())
                secondDatetimepicker.minDate(firstDatetimepicker.date());
            if(secondDatetimepicker && secondDatetimepicker.date())
                firstDatetimepicker.maxDate(secondDatetimepicker.date());

            $(firstDatetimepickerSelector).parent().on("dp.change", function (e) {
                secondDatetimepicker.minDate(e.date);
            });

            $(secondDatetimepickerSelector).parent().on("dp.change", function (e) {
                firstDatetimepicker.maxDate(e.date);
            });
        }
    }
};

var summernote = {

    init: function () {

        $(this).summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true,
            placeholder: 'write here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['insert',['ltr','rtl']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height' ,'hr','codeview' ,'undo' ,'redo']]
            ]
            // lang: LANG == 'en' ? 'ar-AR' : 'en-US'
        });
    },

    clear: function (selector) {
        $(selector).find('.summernote-editor').summernote('code', '');
    }
};

var inputMask = {

    init: function () {

        /**
         * data param
         *
         * data-masked
         * data-inputmask = 'mask':'(999)999-9999'
         * data-mask-type
         */

        var $this = $(this),
            $type = typeof $this.data('mask-type') != typeof undefined ? $this.data('mask-type') : false,
            $mask;

        switch ($type) {

            case 'phone': {
                $mask = '(9{3}) 9{7}';
            }; break;

            case 'mobile': {
                $mask = '(9{3}) 9{3}-9{4}';
            }; break;

            case 'fax': {
                $mask = '+\\963 (9{2}) 9{3}-9{4}';
            }; break;
        }

        $this.attr('dir', 'ltr');
        $this.inputmask($mask, {
            rightAlign: DIR == 'ltr' ? false : true,
            clearMaskOnLostFocus: true,
        });
    },
};

var initGlobalJs = {

    init: function () {

        $(document).ajaxError(function( event, jqxhr, settings, thrownError ) {

            if(jqxhr.responseJSON && jqxhr.responseJSON.redirect_url)
                window.location.href = jqxhr.responseJSON.redirect_url;
        });

        $(document).ajaxSuccess(function( event, jqxhr, settings, thrownError ) {

            if(jqxhr.responseJSON && jqxhr.responseJSON.redirect_url)
                window.location.href = jqxhr.responseJSON.redirect_url;
        });
    }
};

$(function(){
    $('.date').each(_dateTimePicker.init);
    $('.summernote-editor').each(summernote.init);
    $('[data-masked]').each(inputMask.init);

    initGlobalJs.init();
});




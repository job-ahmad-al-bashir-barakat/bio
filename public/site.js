
var helper = {
    human_filesize: function(bytes,decimals) {

    if(bytes == 0) return '0';

    var k = 1024,
        dm = decimals || 2,
        sizes = ['', 'K', 'M', 'G', 'T'],
        i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}
};

var rating = {

    init: function (selector) {

        $(selector).rating({
            'showCaption': false,
            showClear: false,
            theme: 'krajee-svg',
        }).on('rating:change', function () {

            var $this = $(this);

            $.post($this.data('url') ,{ rate : $this.val() })
        });
    }
};

var liked = {

    init: function () {

        $(this).on('click',function () {

            var $this = $(this),
                url   = $this.data('url');

            $.post(url,function (res) {

                if(res.success) {

                    var count = parseInt($this.attr('data-count'));

                    if (res.new)
                    {
                        $this.removeClass('fa-heart').addClass('fa-heart-o');
                        $this.attr('data-count',count + 1);
                        $this.find('.liked-count').text(helper.human_filesize(count + 1));
                    }
                    else
                    {
                        $this.removeClass('fa-heart-o').addClass('fa-heart');
                        $this.attr('data-count',count - 1);
                        $this.find('.liked-count').text(helper.human_filesize(count - 1));
                    }
                }
            });
        });

    }
};

var loadMorePage = {

    init: function ($this) {

        var $this = $($this),
            spinner = $this.parent().find('.spinner'),
            page    = parseInt($this.attr('data-page')) + parseInt($this.data('page')),
            prePage = parseInt($this.attr('data-page'));

        spinner.removeClass('hide').show();

        $.get($this.data('url') ,{ 'page' : page, 'prePage' : prePage } ,function (res) {

            if(res.content != '')
            {
                $this.attr('data-page', page);

                $this.closest('.load-more-container').find('.load-more-content').append(res.content);

                if (typeof $this.data('ajax-success') != typeof undefined)
                    window[$this.data('ajax-success')]($this, res);
            }
            else
            {
                $this.remove();
            }

            spinner.addClass('hide').hide();
        });
    },
};

var switchery = {

    radio: function () {
        $(document).off('change').on('change' ,'.js-switch.js-switch-radio' ,function() {

            if($(this).prop('checked'))
            {
                $('.js-switch').not(this).each(function(i,v){

                    $(v).parent().hide();
                })
            }
            else
            {
                $('.js-switch').each(function(i,v){
                    //var switchery = new Switchery(v);
                    $(v).parent().show();
                })
            }
        });
    },

    initSmallReload: function () {

        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch:not([data-switchery])'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html, { size: 'small' });
        });
    }
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

$(function () {

    $('.liked').each(liked.init);

    initGlobalJs.init();
    switchery.radio();
});



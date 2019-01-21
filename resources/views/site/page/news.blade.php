@extends('site.layout')

@section('content')

<!-- Site header -->
<header class="page-header bg-img size-lg" style="background-image: url({{ asset('background/6.jpeg') }})">
    <div class="container no-shadow">
        <h1 class="text-center">{{ trans('app.news') }}</h1>
        <p class="lead text-center">{{ trans('app.keep_up_to_date_news') }}</p>
    </div>
</header>
<!-- END Site header -->

<!-- Main container -->
<main class="container blog-page">

    <div class="row">

        <div class="col-lg-12">

            @foreach($news as $newOne)
                <article class="post">

                    <header>
                        <h2>{{ $newOne->{lang('title')} }}</h2>
                        <div class="text-center" dir="ltr">
                            <span class="p-10"><i class="fa fa-user"></i> {{ $newOne->user->name }}</span>
                            <span class="p-10"><i class="fa fa-calendar"></i> {{ $newOne->date->format('M d, Y') }}</span>
                        </div>
                    </header>

                    <div class="blog-content">
                        <p class="text-justify">
                            {{ $newOne->{lang('content')} }}
                        </p>
                    </div>

                    @if($is_user)
                        <footer>
                            <div class="pull-right">

                                <span class="fa {{  $newOne->user_like_count ? 'fa-heart-o' : 'fa-heart' }} m-10 hand liked" data-url="{{ RouteUrls::site_like('news',$newOne->id) }}" data-count="{{ $newOne->like_count }}">
                                    <span class="label label-info liked-count liked-count-sm">{{ human_filesize($newOne->like_count) }}</span>
                                </span>

                                <span class="fa fa-comment m-10 hand commented" data-toggle="modal" data-target="#modal-comment" data-key="{{ $newOne->id }}"></span>
                            </div>
                        </footer>
                    @endif

                </article>
            @endforeach

            <nav class="text-center">
                {{ $news->links() }}
            </nav>

        </div>

    </div>

</main>
<!-- END Main container -->

@if($is_user)
    <!-- Contact modal -->
    @component('site.component.modal' ,[
        'id'          => 'modal-comment',
        'bodyClass'   => 'p-0',
        'footerClass' => 'p-0',
        'footerAttr'  => 'style=border:0;',
    ])

        @slot('title',trans('app.send_comment'))

        <div class="comments">
            <ul class="comments-list p-15 hide" style="overflow-y: scroll; height: 300px;"></ul>
        </div>

        @slot('footer')
           <div style="position: relative;">
               {{ Form::open(['id' => 'post-comment' ,'url' => '#' ,'method' => 'post']) }}
                   <textarea id="comment-message" name="message" class="form-control" style="resize: none; padding-right: 60px;" autofocus></textarea>
                   <span class="submit-comment hand" style="position:absolute; top: 0; right: 0; padding: 21px;"><i class="fa fa-send-o" style="font-size: 1.2em;"></i></span>
               {{ Form::close() }}
           </div>
        @endslot

    @endcomponent
@endif

@endsection

@section('script')
    <script>
        (function () {

            $('.commented').click(function () {

                var key = $(this).data('key');

                $('.submit-comment').data('key' ,key);

                $.get("{{ RouteUrls::site_comment('news') }}" + '/' + key, function (res) {

                    var commentsList = $('.comments-list');

                    if(res.comments_count)
                        commentsList.removeClass('hide').show();
                    else
                        commentsList.addClass('hide').hide();

                    commentsList.html(res.comments);
                    commentsList.animate({scrollTop: document.body.scrollHeight},"fast");
                });
            });

            $('.submit-comment').click(function () {

                var $this   = $(this);
                    message = $this.parent().find('#comment-message');

                $.post("{{ RouteUrls::site_comment('news') }}" + '/' + $this.data('key'), { 'message' : message.val() }, function (res) {

                    message.val('');
                    message.attr('placeholder','');

                    var commentsList = $this.closest('#modal-comment').find('.comments-list');

                    if(commentsList.find('li').length == 0)
                        commentsList.removeClass('hide').show();

                    commentsList.append(res.comments);

                    $('.comments-list').animate({scrollTop: document.body.scrollHeight},"fast");

                }).fail(function (res) {

                    message.val('');

                    $.each(res.responseJSON,function (i,v) {
                        message.attr('placeholder',v);
                    });
                });
            });

            $('#modal-comment').on('click','.delete-comment',function () {

                var $this = $(this);

                $.post("{{ RouteUrls::site_comment() }}" + '/' + $this.data('comment-key') ,{'_method' : 'delete'},function (res) {

                    if(res.success)
                    {
                        // remove comment
                        $this.closest('li').fadeOut(300 ,function () {

                            var $this = $(this);

                            // hide continer if ther is no comment exists
                            var commentsList = $this.closest('#modal-comment').find('.comments-list');

                            if((commentsList.find('li').length - 1) == 0)
                                commentsList.addClass('hide').hide();

                            $this.remove();
                        });
                    }
                });
            });
        })();
    </script>
@endsection
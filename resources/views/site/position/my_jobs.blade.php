@extends('site.layout')

@section('body' ,'nav-on-header smart-nav bg-alt')

@section('content')

    <!-- Page header -->
    <header class="page-header bg-img size-lg" style="background-image: url({{ asset('background/3.jpeg') }})">
        <div class="container no-shadow">
            <h1 class="text-center">{{ trans('app.my_position') }}</h1>
        </div>
    </header>
    <!-- END Page header -->

    <!-- Main container -->
    <main>
        <section class="no-padding-top bg-alt">
            <div class="container">
                <div class="main-cont">
                    <div class="row">
                        @foreach($jobs as $job)
                        <!-- Job detail -->
                        <div class="col-xs-12">
                            <div class="item-block">
                                <header>
                                    <img src="{{ replaceImageUrl($job->company->first(),'companies') }}" alt="">
                                    <div class="hgroup">
                                        <h4>{{ $job->name }}</h4>
                                        <h5>{{ $job->company->name }}
                                            <span class="filled-cont">
                                                @if($job->is_filled)
                                                    <span class="label label-success">{{ trans('app.filled') }}</span>
                                                @endif
                                            </span>
                                        </h5>
                                    </div>
                                    <div class="header-meta">
                                        <span class="location" dir="ltr">{{ $job->company->contact->geolocation_title[$lang] }}</span>
                                        <time dir="ltr">{{ $job->last_update->diffForHumans() }}</time>
                                    </div>
                                </header>

                                <footer>
                                    <p class="status"><strong>{{ trans('app.status') }}</strong> {{ $job->job_status_title }}</p>

                                    <div class="action-btn">
                                        <a class="btn btn-xs btn-primary mark-filled" data-key="{{ $job->id }}" href="#">
                                            @if($job->is_filled)
                                                {{ trans('app.mark_empty') }}
                                            @else
                                                {{ trans('app.mark_filled') }}
                                            @endif
                                        </a>
                                        
                                        <a class="btn btn-xs btn-success suggestion" data-key="{{ $job->id }}" href="#">{{ trans('app.suggestion') }}</a>
                                        <a class="btn btn-xs btn-gray" href="{{ RouteUrls::site_job_detail($job->id) }}">{{ trans('app.show') }}</a>
                                    </div>
                                </footer>
                            </div>
                        </div>
                        <!-- END Job detail -->
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="text-center">
                            {{ $jobs->links() }}
                        </div>
                    </div>
                </div>
                <div class="suggestion-cont hide">
                    <div class="row">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3>
                                    {{ trans('app.suggestion') }}
                                    <span class="pull-right suggestion-close hand"><i class="fa fa-times"></i></span>
                                </h3>
                            </div>
                        </div>

                        @include('site.partial.loader')

                        <div class="row suggestion-ajax">

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- END Main container -->

@endsection

@section('script')
    <script>
        // mark filled
        $('.mark-filled').click(function () {

            var $this = $(this),
                filledCont = $this.closest('.item-block').find('.filled-cont');

            $.post("{{ RouteUrls::site_job_mark_filled() }}",{ id : $(this).data('key') },function (res) {

                $this.text(res.btn_title);

                if(res.is_filled)
                    filledCont.html(res.filled);
                else
                    filledCont.html('');
            });
        });

        $('.suggestion').click(function () {

            var spinner = $('.spinner');
            $('.main-cont').fadeOut(300,function(){
                $(this).toggleClass('hide');
            });
            $('.suggestion-cont').fadeIn(300,function(){
                $(this).toggleClass('hide');
            });

            spinner.removeClass('hide').show();
            $.get("{{ RouteUrls::site_resume_suggestion() }}", { job: $(this).data('key') }, function (res) {
                spinner.addClass('hide').hide();
                $('.suggestion-ajax').html(res.content);
            });
        });

        $('.suggestion-close').click(function () {
            $('.main-cont').fadeIn(300,function(){
                $(this).toggleClass('hide');
            });
            $('.suggestion-cont').fadeOut(300,function(){
                $(this).toggleClass('hide');
            });
        });
    </script>
@endsection
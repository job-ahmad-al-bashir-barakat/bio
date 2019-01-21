@extends('site.layout')

@section('body' ,'nav-on-header smart-nav bg-alt')

@section('content')

    <!-- Page header -->
    <header class="page-header bg-img size-lg" style="background-image: url({{ asset('background/4.jpeg') }})">
        <div class="container no-shadow">
            <h1 class="text-center">{{ trans('app.my_resume') }}</h1>
        </div>
    </header>
    <!-- END Page header -->

    <!-- Main container -->
    <main>
        <section class="no-padding-top bg-alt">
            <div class="container">
                <div class="main-cont">
                    <div class="row">

                    @foreach($resumes as $resume)
                    <!-- Resume item -->
                    <div class="col-xs-12">
                            <div class="item-block">
                                <header>
                                    <img class="resume-avatar" src="{{ replaceImageUrl($resume,'resumes') }}">
                                    <div class="hgroup">
                                        <h4>{{ $resume->name }}</h4>
                                        <h5>{{ $resume->headline }}</h5>
                                    </div>
                                    <div class="header-meta">
                                        <span class="location" dir="ltr">{{ $resume->contact->geolocation_title[$lang] or '' }}</span>
                                        <span class="rate" dir="ltr">{{ trans('app.hour_price',['price' => $resume->salary]) }}</span>
                                    </div>
                                </header>

                                <footer>
                                    <p class="status" dir="{{ $dir }}"><strong>{{ trans('app.updated_on') }}</strong> {{ $resume->last_update->format('M d, Y') }}</p>

                                    <div class="action-btn">
                                        <a class="btn btn-xs btn-success suggestion" data-key="{{ $resume->id }}" href="#">{{ trans('app.suggestion') }}</a>
                                        <a class="btn btn-xs btn-gray" href="{{ RouteUrls::site_resume_detail($resume->id) }}">{{ trans('app.show') }}</a>
                                    </div>
                                </footer>
                            </div>
                        </div>
                    <!-- END Resume item -->
                    @endforeach

                    </div>

                    <div class="row">
                        <div class="text-center">
                            {{ $resumes->links() }}
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
        $('.suggestion').click(function () {

            var spinner = $('.spinner');
            $('.main-cont').fadeOut(300,function(){
                $(this).toggleClass('hide');
            });
            $('.suggestion-cont').fadeIn(300,function(){
                $(this).toggleClass('hide');
            });

            spinner.removeClass('hide').show();
            $.get("{{ RouteUrls::site_job_suggestion() }}", { resume: $(this).data('key') }, function (res) {
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

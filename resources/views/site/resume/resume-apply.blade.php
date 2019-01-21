@extends('site.layout')

@section('content')
    <!-- Page header -->
    <header class="page-header bg-img size-lg" style="background-image: url({{ asset('background/4.jpeg') }})">
        <div class="container no-shadow">
            <h1 class="text-center">{{ trans('app.apply_for_the_resume') }}</h1>

            <hr>

            <!-- Job detail -->
            <a class="item-block item-block-flat" href="{{ RouteUrls::site_resume_detail($resume->id) }}">
                <header>
                    <img src="{{ replaceImageUrl($resume,'resumes') }}">
                    <div class="hgroup">
                        <h4>{{ $resume->name }}</h4>
                        <h5>{{ $resume->headline }}</h5>
                    </div>
                    <div class="header-meta">
                        <span class="location" dir="ltr"> <span>{{ $resume->contact->geolocation_title[$lang] }}</span></span>
                        <time dir="ltr">{{ $resume->last_update->diffForHumans() }}</time>
                    </div>
                </header>
            </a>
            <!-- END Job detail -->

            <div class="button-group">
                <div class="action-buttons">
                    <a class="btn btn-primary" href="#sec-job">{{ trans('app.select_a_job') }}</a>
                    <a class="btn btn-gray" href="#sec-custom">{{ trans('app.apply_now') }}</a>
                </div>
            </div>

        </div>
    </header>
    <!-- END Page header -->

    <!-- Main container -->
    <main>
        <form action="{{ RouteUrls::site_resume_apply_send($resume->id) }}" method="post">
            {{ csrf_field() }}

            <section id="sec-job">
                <div class="container">

                    <header class="section-header">
                        <span>{{ trans('app.apply_with_a_job') }}</span>
                        <h2>{{ trans('app.select_a_job') }}</h2>
                        <p>{{ trans('app.select_a_job_message') }}</p>
                    </header>

                    <div class="load-more-container">
                        <div class="load-more-content">
                            @include('site.resume._resume_apply_jobs',['jobs' => $jobs ])
                        </div>
                        @include('site.partial.load_more',[
                            'url'   => RouteUrls::site_jobs(),
                            'page'  => 5,
                            'event' => 'loadMoreSuccess'
                         ])
                    </div>
                </div>
            </section>

            <section id="sec-custom" class="bg-alt">
                <div class="container">
                    <header class="section-header">
                        <h2>{{ trans('app.apply_now') }}</h2>
                    </header>

                    @include('control.component.error')

                    <div class="form-group">
                        <input name="subject" type="text" class="form-control input-lg" placeholder="{{ trans('app.subject') }}" required>
                    </div>

                    <div class="form-group">
                        <textarea name="message" class="form-control" rows="5" placeholder="{{ trans('app.message') }}" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-md-2">
                            <button type="submit" class="btn btn-block btn-primary">{{ trans('app.apply') }}</button>
                        </div>
                    </div>

                </div>
            </section>
        </form>
    </main>
    <!-- END Main container -->

@endsection

@section('script')
    <script>
        function loadMoreSuccess() {
            switchery.initSmallReload();
        }
    </script>
@endsection


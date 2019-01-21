@extends('site.layout')

@section('content')
    <!-- Page header -->
    <header class="page-header bg-img size-lg" style="background-image: url({{ asset('background/3.jpeg') }})">
        <div class="container no-shadow">
            <h1 class="text-center">{{ trans('app.apply_for_the_job') }}</h1>

            <hr>

            <!-- Job detail -->
            <a class="item-block item-block-flat" href="{{ RouteUrls::site_job_detail($job->id) }}">
                <header>
                    <img src="{{ replaceImageUrl($job->company->first(),'companies') }}">
                    <div class="hgroup">
                        <h4>{{ $job->name }}</h4>
                        <h5>{{ $job->company->name }}</h5>
                    </div>
                    <div class="header-meta">
                        <span class="location" dir="ltr">{{ $job->company->contact->geolocation_title[$lang] }}</span>
                        <time dir="ltr">{{ $job->last_update->diffForHumans() }}</time>
                    </div>
                </header>
            </a>
            <!-- END Job detail -->

            <div class="button-group">
                <div class="action-buttons">
                    <a class="btn btn-primary" href="#sec-resume">{{ trans('app.select_a_resume') }}</a>
                    <a class="btn btn-gray" href="#sec-custom">{{ trans('app.apply_now') }}</a>
                </div>
            </div>

        </div>
    </header>
    <!-- END Page header -->

    <!-- Main container -->
    <main>

        <form action="{{ RouteUrls::site_job_apply_send($job->id) }}" method="post">

            {{ csrf_field() }}

            <!-- Apply with resume -->
            <section id="sec-resume">
                <div class="container">

                    <header class="section-header">
                        <span>{{ trans('app.apply_with_a_resume') }}</span>
                        <h2>{{ trans('app.select_a_resume') }}</h2>
                        <p>{{ trans('app.select_a_resume_message') }}</p>
                    </header>


                    <div class="load-more-container">
                        <div class="load-more-content">
                            @include('site.position._job_apply_resumes',['resumes' => $resumes ])
                        </div>
                        @include('site.partial.load_more',[
                            'url'   => RouteUrls::site_resumes(),
                            'page'  => 5,
                            'event' => 'loadMoreSuccess'
                         ])
                    </div>

                </div>
            </section>
            <!-- END Apply with resume -->

            <!-- Custom application -->
            <section id="sec-custom" class="bg-alt">
                <div class="container">
                    <header class="section-header">
                        <h2>{{ trans('app.apply_now') }}</h2>
                    </header>

                    @include('control.component.error')

                    <div class="form-group">
                        <input name="subject" type="text" class="form-control input-lg" placeholder="{{ trans('app.subject') }}">
                    </div>

                    <div class="form-group">
                        <textarea name="message" class="form-control" rows="5" placeholder="{{ trans('app.message') }}"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-md-2">
                            <button type="submit" class="btn btn-block btn-primary">{{ trans('app.apply') }}</button>
                        </div>
                    </div>
                </div>
            </section>
            <!-- END Custom application -->
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

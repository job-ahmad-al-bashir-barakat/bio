@extends('site.layout')

@section('content')
    <!-- Site header -->
    <header class="site-header size-lg text-center" style="background-image: url({{ asset('background/1.jpeg') }})">
        <div class="container">
            <div class="col-xs-12">
                <br><br>
                <h1>{{ trans('app.welcome') }}</h1>
                <h5 class="font-alt">{{ trans('app.welcome_message') }}</h5>
                <br><br><br>
                <form class="header-job-search" action="{{ RouteUrls::site_jobs() }}" method="get">
                    <div class="input-keyword">
                        <input name="keyword" type="text" class="form-control" placeholder="{{ trans('app.jobs_keyword') }}">
                    </div>

                    <div class="input-location">
                        <input name="location" type="text" class="form-control" placeholder="{{ trans('app.jobs_location') }}">
                    </div>

                    <div class="btn-search">
                        <button class="btn btn-primary" type="submit">{{ trans('app.find_jobs') }}</button>
                        <a href="{{ RouteUrls::site_jobs('jobs') }}">{{ trans('app.advanced_job_search') }}</a>
                    </div>
                </form>
            </div>

        </div>
    </header>
    <!-- END Site header -->

    <!-- Main container -->
    <main>

        <!-- Categories -->
        <section class="bg-alt">
            <div class="container">
                <header class="section-header">
                    <span>{{ trans('app.categories') }}</span>
                    <h2>{{ trans('app.popular_categories') }}</h2>
                </header>

                <div class="category-grid">
                    @foreach($categories as $category)
                    <a href="{{ RouteUrls::site_job_category($category->id) }}">
                        <i class="{{ $category->icon->code }}"></i>
                        <h6>{{ $category->{lang('name')} }}</h6>
                        <p>{{ $category->{lang('description')} }}</p>
                    </a>
                    @endforeach
                </div>

            </div>
        </section>
        <!-- END Categories -->
    </main>
    <!-- END Main container -->
@endsection


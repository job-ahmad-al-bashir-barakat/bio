@extends('site.layout')

@section('body' ,'nav-on-header smart-nav bg-alt')

@section('content')
<!-- Page header -->
<header class="page-header bg-img" style="background-image: url({{ asset('background/5.jpeg') }});">
    <div class="container page-name">
        <h1 class="text-center">{{ trans('app.browse_companies') }}</h1>
        <p class="lead text-center">{{ trans('app.search_box_to_find_companies') }}</p>
    </div>

    <div class="container">
        <form action="{{ RouteUrls::site_companies() }}" method="GET">

            <div class="row">
                <div class="form-group col-xs-12 col-sm-6">
                    <input type="text" name="keyword" class="form-control" placeholder="{{ trans('app.company_keyword') }}">
                </div>

                <div class="form-group col-xs-12 col-sm-6">
                    <input type="text" name="location" class="form-control" placeholder="{{ trans('app.company_location') }}">
                </div>
            </div>

            <div class="button-group">
                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary">{{ trans('app.apply_filter') }}</button>
                </div>
            </div>

        </form>
    </div>

</header>
<!-- END Page header -->

<!-- Main container -->
<main>
    <section class="no-padding-top bg-alt">
        <div class="container">

            @include('site.partial.result_match',['object' => $companies])

            @foreach($companies as $company)

                <div class="row">
                    <!-- Company detail -->
                    <div class="col-xs-12">
                        <a class="item-block" href="{{ RouteUrls::site_company_detail($company->id) }}">
                            <header>
                                <img src="{{ replaceImageUrl($company,'companies') }}" alt="">
                                <div class="hgroup">
                                    <h4>{{ $company->name }}</h4>
                                    <h5>{{ $company->headline }}</h5>
                                </div>
                                <span class="open-position">{{ $company->job_count }} {{ trans('app.open_position') }}</span>
                            </header>

                            <div class="item-body">
                                <p>{!! $company->short_description !!}</p>
                            </div>
                        </a>
                    </div>
                    <!-- END Company detail -->
                </div>

            @endforeach

            <div class="row">
                <nav class="text-center">
                    {{ $companies->links() }}
                </nav>
            </div>

        </div>
    </section>
</main>
<!-- END Main container -->
@endsection
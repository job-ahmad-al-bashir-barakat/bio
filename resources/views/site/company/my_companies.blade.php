@extends('site.layout')

@section('body' ,'nav-on-header smart-nav bg-alt')

@section('content')

    <!-- Page header -->
    <header class="page-header bg-img size-lg" style="background-image: url({{ asset('background/5.jpeg') }})">
        <div class="container no-shadow">
            <h1 class="text-center">{{ trans('app.my_company') }}</h1>
        </div>
    </header>
    <!-- END Page header -->

    <!-- Main container -->
    <main>
        <section class="no-padding-top bg-alt">
            <div class="container">
                <div class="row item-blocks-condensed">

                    @foreach($companies as $company)
                    <!-- Company item -->
                    <div class="col-xs-12">
                        <div class="item-block">
                            <header>
                                <img src="{{ replaceImageUrl($company,'companies') }}">
                                <div class="hgroup">
                                    <h4>{{ $company->name }}</h4>
                                    <h5>{{ $company->headline }} <span class="label label-info">{{ $company->job_count }} {{ trans('app.job') }}</span></h5>
                                </div>
                                <div class="action-btn">
                                    <a class="btn btn-xs btn-gray" href="{{ RouteUrls::site_company_detail($company->id) }}">{{ trans('app.show') }}</a>
                                </div>
                            </header>
                        </div>
                    </div>
                    <!-- END Company item -->
                    @endforeach

                </div>

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

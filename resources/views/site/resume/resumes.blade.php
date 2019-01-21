@extends('site.layout')

@section('body' ,'nav-on-header smart-nav bg-alt')

@section('content')
<!-- Page header -->
<header class="page-header bg-img" style="background-image: url({{ asset('background/4.jpeg') }});">
    <div class="container page-name">
        <h1 class="text-center">{{ trans('app.browse_resumes') }}</h1>
        <p class="lead text-center">{{ trans('app.search_box_to_find_resumes') }}</p>
    </div>

    <div class="container" style="width: 75%;">
        <form action="{{ RouteUrls::site_resumes() }}" method="get">

            <div class="row">
                <div class="form-group col-xs-12 col-sm-6">
                    <input name="keyword" type="text" class="form-control" placeholder="{{ trans('app.resume_keyword') }}">
                </div>

                <div class="form-group col-xs-12 col-sm-6">
                    <input type="text" name="location" class="form-control" placeholder="{{ trans('app.resume_location') }}">
                </div>

                <div class="form-group col-xs-12 col-sm-6">
                    <h6>{{ trans('app.hourly_rate') }}</h6>
                    <div class="checkall-group">
                        @foreach($hourlyRate as $index => $rate)
                            @if ($index == 0)
                                <div class="checkbox">
                                    <input type="checkbox" id="rate{{ $index }}" name="rate" checked>
                                    <label for="rate{{ $index }}">{{ trans('app.all_rates') }}</label>
                                </div>
                            @endif
                            <div class="checkbox">
                                <input type="checkbox" id="rate{{ $index+1 }}" name="rate[]" value="{{ $rate->value }}">
                                <label for="rate{{ $index+1 }}">{{ $rate->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group col-xs-12 col-sm-6">
                    <h6>{{ trans('app.academic_degree') }}</h6>
                    <div class="checkall-group">

                        @foreach($degrees as $index => $degree)
                            @if ($index == 0)
                                <div class="checkbox">
                                    <input type="checkbox" id="degree{{ $index }}" name="degree" checked>
                                    <label for="degree{{ $index }}">{{ trans('app.all_degrees') }}</label>
                                </div>
                            @endif
                            <div class="checkbox">
                                <input type="checkbox" id="degree{{ $index+1 }}" name="degree[]" value="{{ $degree->id }}">
                                <label for="degree{{ $index+1 }}">{{ $degree->{lang('name')} }}</label>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <div class="button-group">
                <div class="action-buttons">
                    <button class="btn btn-primary">{{ trans('app.apply_filter') }}</button>
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

        @include('site.partial.result_match',['object' => $resumes])

        @include('site.resume._resumes',['resumes' => $resumes])

        <div class="row">
            <div class="text-center">
                {{ $resumes->links() }}
            </div>
        </div>

    </div>
</section>
</main>
<!-- END Main container -->
@endsection

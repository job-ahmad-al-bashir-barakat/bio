@extends('site.layout')

@section('content')

    <!-- Page header -->
    <header class="page-header bg-img size-lg" style="background-image: url({{ asset('background/5.jpeg') }})"
            xmlns="">
        <div class="container">
            <div class="header-detail">
                <img class="logo" src="{{ replaceImageUrl($company,'companies') }}" alt="">
                <div class="hgroup">
                    <h1>{{ $company->name }}</h1>
                    <h3>{{ $company->headline }}</h3>
                </div>
                @if($is_user)
                <div class="pull-right" dir="ltr">
                    <input id="input-1" name="rate" class="rating" data-min="0" data-max="5" data-step="1" value="{{ $company->averageRating }}" data-size="xs" data-url="{{ RouteUrls::site_rate('company',$company->id) }}">
                </div>
                @endif
                <hr>
                <p class="lead">{!! $company->short_description !!}</p>

                <ul class="details cols-3">
                    <li>
                        <i class="fa fa-map-marker"></i>
                        <span>{{ $company->contact->geolocation_title[$lang] }}</span>
                    </li>

                    <li>
                        <i class="fa fa-globe"></i>
                        <a href="{{ $company->contact->website }}">{{ websiteUrl($company->contact->website) }}</a>
                    </li>

                    <li>
                        <i class="fa fa-users"></i>
                        <span>{{ $company->companyEmployer->name }} {{ trans('app.employer') }}</span>
                    </li>

                    <li>
                        <i class="fa fa-birthday-cake"></i>
                        <span>{{ trans('app.from') }} {{ $company->founded_from }}</span>
                    </li>

                    <li>
                        <i class="fa fa-phone"></i>
                        <span dir="ltr">{{ $company->contact->phone_number }}</span>
                    </li>

                    <li>
                        <i class="fa fa-envelope"></i>
                        <span>{{ $company->contact->email }}</span>
                    </li>
                </ul>

                <div class="button-group">
                    <ul class="social-icons">
                        @foreach($company->contact->socialNetwork as $social)
                            <li><a class="{{ $social->code }}" href="{{ $social->pivot->value }}"><i class="fa fa-{{ $social->code }}"></i></a></li>
                        @endforeach
                    </ul>

                    @if($is_user)
                        <div class="action-buttons">
                            <div class="pull-right">
                                <span style="font-size: 1.5em;" class="fa {{ $company->user_like_count ? 'fa-heart-o' : 'fa-heart' }} m-10 hand liked" data-url="{{ RouteUrls::site_like('company',$company->id) }}" data-count="{{ $company->like_count }}">
                                    <span class="label label-info liked-count liked-count-lg">{{ human_filesize($company->like_count) }}</span>
                                </span>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </header>
    <!-- END Page header -->


    <!-- Main container -->
    <main>

        <!-- Company detail -->
        <section>
            <div class="container">

                <header class="section-header">
                    <span>{{ trans('app.about') }}</span>
                    <h2>{{ trans('app.company_detail') }}</h2>
                </header>

                <div>
                    {!! $company->detail !!}
                </div>

            </div>
        </section>
        <!-- END Company detail -->

        <!-- Open positions -->
        <section id="open-positions" class="bg-alt">
            <div class="container">
                <header class="section-header">
                    <span>vacancies</span>
                    <h2>Open positions</h2>
                </header>

                <div class="row">

                    <div class="load-more-container">
                        <div class="load-more-content">
                            @include('site.position._jobs',['jobs' => $jobs])
                        </div>
                        @include('site.partial.load_more',[
                            'url'   => RouteUrls::site_company_detail($company->id),
                            'page'  => 3,
                        ])
                    </div>

                </div>

            </div>
        </section>
        <!-- END Open positions -->

    </main>
    <!-- END Main container -->

@endsection

@if($is_user)
    @section('script')
        <script>
            rating.init('.rating');
        </script>
    @endsection
@endif

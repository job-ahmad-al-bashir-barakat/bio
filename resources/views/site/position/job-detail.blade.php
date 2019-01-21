@extends('site.layout')

@section('content')
<!-- Page header -->
<header class="page-header bg-img size-lg" style="background-image: url({{ asset('background/3.jpeg') }})">
    <div class="container">
        <div class="header-detail">
            <img class="logo" src="{{ replaceImageUrl($job->company->first(),'companies') }}" alt="">
            <div class="hgroup">
                <h1>{{ $job->name }}</h1>
                <h3><a href="{{ RouteUrls::site_company_detail($job->company->id) }}">{{ $job->company->name }}</a></h3>
            </div>
            <time dir="ltr">{{ $job->last_update->diffForHumans() }}</time>
            <hr>
            <p class="lead">{{ $job->short_description }}</p>

            <ul class="details cols-3">
                <li>
                    <i class="fa fa-map-marker"></i>
                    <span>{{ $job->company->contact->geolocation_title[$lang] }}</span>
                </li>

                <li>
                    <i class="fa fa-briefcase"></i>
                    <span>{{ $job->contract->{lang('name')} }}</span>
                </li>

                <li>
                    <i class="fa fa-money"></i>
                    <span>{{ trans('app.hour_price',['price' => $job->salary]) }}</span>
                </li>

                <li>
                    <i class="fa fa-clock-o"></i>
                    <span>{{ trans('app.work_hour_num',['hour' => $job->work_hour_num]) }}</span>
                </li>

                <li>
                    <i class="fa fa-flask"></i>
                    <span>{{ $job->experience_num }} {{ trans('app.years_experience') }}</span>
                </li>

                <li>
                    <i class="fa fa-certificate"></i>
                    <a href="#">{{ implode($job->degree->pluck(lang('name'))->toArray() ,trans('app.or')) }}</a>
                </li>
            </ul>

            <div class="button-group">
                <ul class="social-icons">
                    @foreach($job->company->contact->socialNetwork as $social)
                        <li><a class="{{ $social->code }}" href="{{ $social->pivot->value }}"><i class="fa fa-{{ $social->code }}"></i></a></li>
                    @endforeach
                </ul>

                @if(!$job->HasJobApply->count())
                    @if($is_user && $user->id != $job->company->user_id)
                        <div class="action-buttons">
                            <a class="btn btn-success" href="{{ RouteUrls::site_job_detail_apply($job->id) }}">{{ trans('app.apply') }}</a>
                        </div>
                    @endif
                @endif
            </div>

        </div>
    </div>
</header>
<!-- END Page header -->

<!-- Main container -->
<main>

    <!-- Job detail -->
    <section>
        <div class="container">
            {!! $job->detail !!}
        </div>
    </section>
    <!-- END Job detail -->

</main>
<!-- END Main container -->
@endsection


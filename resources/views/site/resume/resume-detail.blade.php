@extends('site.layout')

@section('content')
<!-- Page header -->
<header class="page-header bg-img" style="background-image: url({{ asset('background/4.jpeg') }})">
    <div class="container">
        <div class="row">

            <div class="col-xs-12  header-detail">
                <div>
                    <img class="logo" src="{{ replaceImageUrl($resume,'resumes') }}">
                    <div class="hgroup">
                        <h1>{{ $resume->name }}</h1>
                        <h3>{{ $resume->headline }}</h3>
                    </div>
                </div>
                <hr>
                <p class="lead">{{ $resume->short_description }}</p>

                <ul class="details cols-2">
                    <li>
                        <i class="fa fa-map-marker"></i>
                        <span>{{ $resume->contact->geolocation_title[$lang] }}</span>
                    </li>

                    <li>
                        <i class="fa fa-globe"></i>
                        <a href="#">{{ websiteUrl($resume->contact->website) }}</a>
                    </li>

                    <li>
                        <i class="fa fa-money"></i>
                        <span>{{ trans('app.hour_price',['price' => $resume->salary]) }}</span>
                    </li>

                    <li>
                        <i class="fa fa-birthday-cake"></i>
                        <span>{{ trans('app.year_old',['old' => $resume->age]) }}</span>
                    </li>

                    <li>
                        <i class="fa fa-phone"></i>
                        <span dir="ltr">{{ $resume->contact->phone_number }}</span>
                    </li>

                    <li>
                        <i class="fa fa-envelope"></i>
                        <a href="#">{{ $resume->contact->email }}</a>
                    </li>
                </ul>

                <div class="tag-list">
                    @foreach($resume->tagList as $tag)
                        <span>{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="button-group">
            <ul class="social-icons">
                @foreach($resume->contact->socialNetwork as $social)
                    <li><a class="{{ $social->code }}" href="{{ $social->pivot->value }}"><i class="fa fa-{{ $social->code }}"></i></a></li>
                @endforeach
            </ul>

            @if(!$resume->HasJobApply->count())
                @if($is_user && $user->id != $resume->user_id)
                    <div class="action-buttons">
                        <a class="btn btn-success" href="{{ RouteUrls::site_resume_detail_apply($resume->id) }}">{{ trans('app.apply') }}</a>
                    </div>
                @endif
            @endif
        </div>
    </div>
</header>
<!-- END Page header -->

<!-- Main container -->
<main>

    @if ($resume->resumeEducation->count())
    <!-- Education -->
    <section>
        <div class="container">

            <header class="section-header">
                <span>{{ trans('app.latest_degrees') }}</span>
                <h2>{{ trans('app.education') }}</h2>
            </header>

            <div class="row">

                @foreach($resume->resumeEducation as $education)
                    <div class="col-xs-12">
                        <div class="item-block">
                            <header>
                                <div class="hgroup">
                                    <h4>{{ $education->degree->{lang('name')} }} <small>{{ $education->majer->name }}</small></h4>
                                    <h5>{{ $education->school->name }}</h5>
                                </div>
                                <h6 class="time">{{ $education->date_from_to }}</h6>
                            </header>
                            <div class="item-body">
                                <p>{{ $education->short_description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </section>
    <!-- END Education -->
    @endif

    @if($resume->skills->count())
    <!-- Work Experience -->
    <section class="bg-alt">
        <div class="container">
            <header class="section-header">
                <span>{{ trans('app.past_positions') }}</span>
                <h2>{{ trans('app.work_experience') }}</h2>
            </header>

            <div class="row">

                @foreach($resume->workExperience as $workExperience)
                <!-- Work item -->
                <div class="col-xs-12">
                    <div class="item-block">
                        <header>
                            <img src="{{ replaceImageUrl($workExperience,'work-experiences') }}">
                            <div class="hgroup">
                                <h4>{{ $workExperience->workExpCompany->name }}</h4>
                                <h5>{{ $workExperience->workExpJobTitle->name }}</h5>
                            </div>
                            <h6 class="time">{{ $workExperience->date_from_to }}</h6>
                        </header>
                        <div class="item-body">
                            {!! $workExperience->summery !!}
                        </div>
                    </div>
                </div>
                <!-- END Work item -->
                @endforeach
            </div>
        </div>
    </section>
    <!-- END Work Experience -->
    @endif


    @if($resume->skills->count())
    <!-- Skills -->
    <section>
        <div class="container">
            <header class="section-header">
                <span>{{ trans('app.expertise_areas') }}</span>
                <h2>{{ trans('app.skills') }}</h2>
            </header>

            <br>
            <ul class="skills cols-3">
                @foreach($resume->skills as $skill)
                    <li>
                        <div>
                            <span class="skill-name">{{ $skill->name }}</span>
                            <span class="skill-value">{{ $skill->pivot->proficiency_ratio }}%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: {{ $skill->pivot->proficiency_ratio }}%;"></div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
    <!-- END Skills -->
    @endif

</main>
<!-- END Main container -->
@endsection

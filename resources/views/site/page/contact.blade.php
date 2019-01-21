@extends('site.layout')

@section('content')
<!-- Site header -->
<header class="page-header bg-img size-lg" style="background-image: url({{ asset('background/7.jpeg') }})">
    <div class="container no-shadow">
        <h1 class="text-center">{{ trans('app.contact_us') }}</h1>
        <p class="lead text-center">{{ trans('app.contact_us_message') }}</p>
    </div>
</header>
<!-- END Site header -->

<!-- Main container -->
<main>

    <section>
        <div class="container">

            <div class="row">
                <div class="col-sm-12">
                    <h4>{{ trans('app.contact') }}</h4>

                    @if($errors->all())
                        <div class="alert alert-danger" style="margin-top: 20px;">
                            <ul style="text-align: left;">
                                @foreach ($errors->all() as $error)
                                    <li style="font-size: 13px;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('message'))
                        <div class="alert alert-success" style="margin-top: 20px;">
                            <span>{{ session('message') }}</span>
                        </div>
                    @endif

                    {{ Form::open(['url' => \RouteUrls::site_contact(), 'method' => 'post']) }}
                        <div class="form-group">
                            <input name="subject" type="text" class="form-control input-lg" placeholder="{{ trans('app.subject') }}" value="{{ old('subject') }}" required autofocus>
                        </div>

                        <div class="form-group">
                            <input name="email" type="email" class="form-control input-lg" placeholder="{{ trans('app.email') }}" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="5" placeholder="{{ trans('app.message') }}" required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ trans('app.send') }}</button>
                    {{ Form::close() }}
                </div>
            </div>

        </div>
    </section>


</main>
<!-- END Main container -->
@endsection

@section('footer')
    <script src="{{ asset(mix('js/theme-site.js')) }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?callback=initMap" async defer></script>
@endsection


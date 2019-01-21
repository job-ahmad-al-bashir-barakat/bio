@extends('site.auth.layout')

@section('content')

<main>

    <div class="login-block">

        <img src="{{ asset('img/logo-site.png') }}" alt="">
        <h1>Request password reset</h1>

        {{ Form::open(['url' => RouteUrls::site_passwordEmail(),'method' => 'post']) }}

            @if (session('status'))
                <div class="alert alert-success">
                    <span style="font-size: 13px;">{{ session('status') }}</span>
                </div>
            @endif

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="ti-email"></i></span>
                    <input name="email" type="text" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                </div>
            </div>

            <button class="btn btn-primary btn-block" type="submit">Request reset link</button>

            @if($errors->all())
                <div class="alert alert-danger" style="margin-top: 20px;">
                    <ul style="text-align: left;">
                        @foreach ($errors->all() as $error)
                            <li style="font-size: 13px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        {{ Form::close() }}

    </div>

    <div class="login-links">
        <p class="text-center"><a href="{{ RouteUrls::site_login('login') }}">Back to login</a></p>
    </div>

</main>

@endsection

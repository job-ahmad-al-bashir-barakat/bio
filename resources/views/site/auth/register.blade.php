@extends('site.auth.layout')

@section('content')

    <main>

        <div class="login-block">
            <img src="{{ asset('img/logo-site.png') }}" alt="">
            <h1>Log into your account</h1>

            {{ Form::open(['url' => RouteUrls::site_register() ,'method' => 'post']) }}

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ti-user"></i></span>
                        <input name="name" type="text" class="form-control" placeholder="Your name" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                <hr class="hr-xs">

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ti-email"></i></span>
                        <input name="email" type="text" class="form-control" placeholder="Your email address" value="{{ old('email') }}" required>
                    </div>
                </div>

                <hr class="hr-xs">

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ti-unlock"></i></span>
                        <input name="password" type="password" class="form-control" placeholder="Choose a password" required>
                    </div>
                </div>

                <hr class="hr-xs">

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ti-unlock"></i></span>
                        <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm a password" required>
                    </div>
                </div>

                <button class="btn btn-primary btn-block" type="submit">Sign up</button>

                @include('control.component.error');

            {{ Form::close() }}

        </div>

        <div class="login-links">
            <p class="text-center">Already have an account? <a class="txt-brand" href="{{ RouteUrls::site_login() }}">Login</a></p>
        </div>

    </main>

@endsection
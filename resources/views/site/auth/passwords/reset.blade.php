@extends('site.auth.layout')

@section('content')

    <main>

        <div class="login-block">

            <img src="{{ asset('img/logo-site.png') }}" alt="">
            <h1>Reset Password</h1>

            {{ Form::open(['url' => RouteUrls::site_passwordReset(),'method' => 'post']) }}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ti-email"></i></span>
                        <input name="email" type="text" class="form-control" placeholder="Email" value="{{ $email ?? old('email') }}" required autofocus>
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

                <button class="btn btn-primary btn-block" type="submit">Reset Password</button>

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
 
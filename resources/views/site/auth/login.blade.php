@extends('site.auth.layout')

@section('content')

    <main>

        <div class="login-block">
            <img src="{{ asset('img/logo-site.png') }}" alt="">
            <h1>Log into your account</h1>

            {{ Form::open(['url' => RouteUrls::site_login() ,'method' => 'post']) }}

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ti-email"></i></span>
                        <input name="email" type="text" class="form-control" placeholder="Email" required autofocus>
                    </div>
                </div>

                <hr class="hr-xs">

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="ti-unlock"></i></span>
                        <input name="password" type="password" class="form-control" placeholder="Password" required>
                    </div>
                </div>

                <div class="form-group pull-left">
                    <div class="checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="checkbox">
                        <label for="checkbox">Remember Me</label>
                    </div>
                </div>

                <button class="btn btn-primary btn-block" type="submit">Login</button>

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
            <a class="pull-left" href="{{ RouteUrls::site_passwordReset() }}">Forget Password?</a>
            <a class="pull-right" href="{{ RouteUrls::site_register() }}">Register an account</a>
        </div>

    </main>

@endsection
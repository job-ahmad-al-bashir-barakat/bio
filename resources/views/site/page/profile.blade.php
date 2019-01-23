@extends('site.layout')

@section('content')

    <form action="{{ RouteUrls::site_profile()  }}" method="post" enctype="multipart/form-data">

        {{ csrf_field() }}
        <!-- Page header -->
        <header class="page-header  bg-img" style="background-image: url({{ asset('background/8.jpeg') }})">
            <div class="container page-name">
                <h1 class="text-center">{{ trans('app.profile') }}</h1>
                <p class="lead text-center">{{ trans('app.profile_message') }}</p>
            </div>

            <div class="container">

                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="form-group">
                            <input name="personal_image" type="file" class="dropify"
                                   data-default-file="{{ replaceImageUrl($user) }}">
                            <span class="help-block">{{ trans('app.profile_image_upload') }}</span>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-4">

                        <h6>{{ trans('app.basic_information') }}</h6>

                        <div class="row">

                            <div class="form-group col-xs-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input name="name" type="text" class="form-control" placeholder="{{ trans('app.name') }}" value="{{ $user->name ?? old('name') }}" required>
                                </div>
                            </div>

                            <div class="form-group col-xs-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input name="email" type="text" class="form-control" placeholder="{{ trans('app.email_address') }}" value="{{ $user->email ?? old('email') }}" required>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="col-xs-6 col-sm-4">

                        <h6>{{ trans('app.change_password') }}</h6>

                        <div class="row">

                            <div class="form-group col-xs-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input name="password" type="text" class="form-control" placeholder="{{ trans('app.passowrd') }}">
                                </div>
                            </div>

                            <div class="form-group col-xs-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input name="password_confirmation" type="text" class="form-control" placeholder="{{ trans('app.confirm_password') }}">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                @if($errors->all())
                    <div class="row">
                        <div class="alert alert-danger" style="margin-top: 20px;">
                            <ul style="text-align: left;">
                                @foreach ($errors->all() as $error)
                                    <li style="font-size: 13px;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

            </div>

        </header>
        <!-- END Page header -->

        <!-- Main container -->
        <main>

            <!-- Submit -->
            <section class="">
                <div class="container">
                    <header class="section-header">
                        <span>{{ trans('app.are_you_done') }}</span>
                        <h2>{{ trans('app.submit_profile') }}</h2>
                        <p>{{ trans('app.submit_profile_message') }}</p>
                    </header>

                    <p class="text-center">
                        <button class="btn btn-success btn-xl btn-round">{{ trans('app.submit_profile') }}</button>
                    </p>

                </div>
            </section>
            <!-- END Submit -->

        </main>
        <!-- END Main container -->

    </form>

@endsection
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $dir }}">

@include('site.partial.head')

<body class="nav-on-header smart-nav">

<!-- Site header -->
<header class="site-header size-lg text-center" style="background-image: url({{ asset('img/bg-banner1.jpg') }})">
    <div class="container">
        <div class="col-xs-12">
            <div class="row">
                <h1 class="p-20  mb-25" style="font-size: 150px;">404</h1>
                <h5 class="font-alt">
                    <div class="p-5">{{ trans('app.404_head') }}</div>
                    <div class="p-5">{{ trans('app.404_message') }}</div>
                </h5>
            </div>

            <div class="row mt-10">
                <a class="btn btn-white" href="{{ Redirect::back()->getTargetUrl() }}">{{ trans('app.go_back') }}</a>
            </div>
        </div>
    </div>
</header>
<!-- END Site header -->

@include('site.partial.footer')

</body>
</html>

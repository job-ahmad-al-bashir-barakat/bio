<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $dir }}">

<head>
    @include("$module::layouts._meta")

    <link id="maincss" rel="stylesheet" href="{{ asset(mix("css/control-all-$dir.css")) }}">
    <base href="{{ asset('/') }}">

    <div role="header">
        @yield('header')
    </div>
</head>

<body>
<div class="wrapper">

    <!-- top navbar-->
    @include("$module::layouts._header")
    <!-- sidebar-->
    @include("$module::layouts._aside")
    <!-- Main section-->
    <section>
        <!-- Page content-->
        <div class="content-wrapper">

            @yield('content_header')

            @yield('content')

        </div>
    </section>
    <!-- Page footer-->
    <footer>
        <span>&copy; {{ date('Y') }} - bio</span>
    </footer>

</div>
<!-- =============== VENDOR SCRIPTS ===============-->

<script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCC3X-thsM5s1FkNqwFtRKTaa1CMFctf1k&language={{$lang}}&libraries=places"></script>
<script src="{{ asset(mix("js/control-all-$dir.js")) }}"></script>
<script src="{{ asset('GMap.js') }}"></script>
<script src="{{ asset('control.js') }}"></script>

@include('control.global-js')

<div role="footer">
    @yield('footer')
</div>

</body>
</html>


<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $dir }}">

@include('site.partial.head')

<body class="@yield('body', 'nav-on-header smart-nav')">

<!-- Navigation bar -->
<nav class="navbar">
    <div class="container">

        <!-- Logo -->
        @include('site.partial.logo')
        <!-- END Logo -->

        <!-- User account -->
        @include('site.partial.user_account')
        <!-- END User account -->

        <!-- Navigation menu -->
        @include('site.partial.navigation-menu')
        <!-- END Navigation menu -->

    </div>
</nav>
<!-- END Navigation bar -->

<!-- Main container -->
@yield('content')
<!-- END Main container -->

<!-- Site footer -->
@include('site.partial.footer')
<!-- END Site footer -->

<!-- Back to top button -->
<a id="scroll-up" href="#"><i class="ti-angle-up"></i></a>
<!-- END Back to top button -->

<!-- Scripts -->
@section('footer')
    <script src="{{ asset(mix('js/theme-site.js')) }}"></script>
    <script src="{{ asset('site.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
@show

@yield('script')

</body>
</html>

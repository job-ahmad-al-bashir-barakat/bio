<!-- top navbar-->
<header class="topnavbar-wrapper">
    <!-- START Top Navbar-->
    <nav role="navigation" class="navbar topnavbar">
        <!-- START navbar header-->
        <div class="navbar-header">
            <a href="{{ RouteUrls::control() }}" class="navbar-brand ajax">
                <div class="brand-logo" style="padding: 15px 15px;">
                    <img style="width: 45px;" src="{{ asset('background/logo.png') }}" alt="App Logo" class="img-responsive">
                </div>
                <div class="brand-logo-collapsed" style="padding: 15px 15px;">
                    <img style="width: 45px;" src="{{ asset('background/logo.png') }}" alt="App Logo" class="img-responsive">
                </div>
            </a>
        </div>
        <!-- END navbar header-->

        <!-- START Nav wrapper-->
        <div class="nav-wrapper">
            <!-- START Left navbar-->
            <ul class="nav navbar-nav">
                <li>
                    <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                    <a href="javascript:void(0)" data-toggle-state="aside-toggled" data-no-persist="true"
                       class="visible-xs sidebar-toggle">
                        <em class="fa fa-navicon"></em>
                    </a>
                </li>
                <!-- go home-->
                <li>
                    <a href="{{ RouteUrls::site_home() }}" title="{{ trans('admin::app.back_to_home') }}">
                        <em class="icon-home"></em>
                    </a>
                </li>
                <!-- End go home-->
                <!-- START logout-->
                <li>
                    <form id="logout-form" action="{{ RouteUrls::logout() }}" method="POST" class="hide">{{ csrf_field() }}</form>
                    <a href="{{ RouteUrls::logout() }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="{{ trans('admin::app.logout') }}">
                        <em class="icon-logout"></em>
                    </a>
                </li>
                <!-- END logout-->
            </ul>
            <!-- END Left navbar-->

            <!-- START Right Navbar-->
            <ul class="nav navbar-nav navbar-right">
                <!-- Fullscreen (only desktops)-->
                <li class="visible-lg">
                    <a href="javascript:void(0)" data-toggle-fullscreen="" title="{{ trans('admin::app.fullscreen') }}">
                        <em class="fa fa-expand"></em>
                    </a>
                </li>
            </ul>
            <!-- END Right Navbar-->
        </div>
        <!-- END Nav wrapper-->
    </nav>
    <!-- END Top Navbar-->
</header>
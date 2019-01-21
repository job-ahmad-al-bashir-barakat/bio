<div class="pull-right">

    <div class="dropdown user-account">

        <a class="dropdown-toggle" href="#" data-toggle="dropdown">
            <img src="{{ replaceImageUrl($user,'users','img/logo-default.png') }}" alt="avatar">
        </a>

        <ul class="dropdown-menu dropdown-menu-{{ $revPos }}">

            @foreach(LaravelLocalization::getSupportedLocales() as $index => $_lang)
                @if($index != $lang)
                    <li>
                        <a hreflang="{{ $index }}" href="{{ LaravelLocalization::getLocalizedURL($index ,\URL::current()) }}">
                            {{ $_lang['native'] }}
                        </a>
                    </li>
                @endif
            @endforeach

            @unless($is_user)
                <li><a href="{{ RouteUrls::site_login() }}">{{ trans('app.login') }}</a></li>
                <li><a href="{{ RouteUrls::site_register() }}">{{ trans('app.register') }}</a></li>
            @else
                <li><a href="{{ RouteUrls::site_profile() }}">{{ trans('app.profile') }}</a></li>
                {{--<li><a href="{{ RouteUrls::site_gallery() }}">Gallery</a></li>--}}
                <li><a href="{{ RouteUrls::control() }}">{{ trans('app.control_panel') }}</a></li>
                <li>
                    <form id="logout-form" action="{{ RouteUrls::site_logout() }}" method="POST" class="hide">{{ csrf_field() }}</form>
                    <a href="{{ RouteUrls::site_logout() }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="{{ trans('app.logout') }}">
                        <span>{{ trans('app.logout') }}</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>

</div>

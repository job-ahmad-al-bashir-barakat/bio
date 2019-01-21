<ul class="nav-menu">
    <li>
        <a class="active" href="{{ RouteUrls::site_home() }}">{{ trans('app.home') }}</a>
    </li>

    {{--job--}}
    @unless($is_user)
        <li>
            <a href="{{ RouteUrls::site_jobs() }}">{{ trans('app.position') }}</a>
        </li>
    @else
        <li>
            <a href="#">{{ trans('app.position') }}</a>
            <ul>
                <li><a href="{{ RouteUrls::site_my_jobs() }}">{{ trans('app.my_position') }}</a></li>
                <li><a href="{{ RouteUrls::site_jobs() }}">{{ trans('app.browse_position') }}</a></li>
            </ul>
        </li>
    @endunless
    {{--end job--}}

    {{--resume--}}
    @unless($is_user)
        <li>
            <a href="{{ RouteUrls::site_resumes() }}">{{ trans('app.resume') }}</a>
        </li>
    @else
        <li>
            <a href="#">{{ trans('app.resume') }}</a>
            <ul>
                <li><a href="{{ RouteUrls::site_my_resumes() }}">{{ trans('app.my_resume') }}</a></li>
                <li><a href="{{ RouteUrls::site_resumes() }}">{{ trans('app.browse_resume') }}</a></li>
            </ul>
        </li>
    @endunless
    {{--end resume--}}

    {{--company--}}
    @unless($is_user)
        <li>
            <a href="{{ RouteUrls::site_companies() }}">{{ trans('app.company') }}</a>
        </li>
    @else
        <li>
            <a href="#">{{ trans('app.company') }}</a>
            <ul>
                <li><a href="{{ RouteUrls::site_my_companies() }}">{{ trans('app.my_company') }}</a></li>
                <li><a href="{{ RouteUrls::site_companies() }}">{{ trans('app.browse_company') }}</a></li>
            </ul>
        </li>
    @endunless
    {{--end company--}}

    <li>
        <a href="#">{{ trans('app.pages') }}</a>
        <ul>
            <li><a href="{{ RouteUrls::site_news() }}">{{ trans('app.news') }}</a></li>
            {{--<li><a href="{{ RouteUrls::site_about() }}">About</a></li>--}}
            @if($is_user)
            <li><a href="{{ RouteUrls::site_contact() }}">{{ trans('app.contact') }}</a></li>
            @endif
            <li><a href="{{ RouteUrls::site_faq() }}">{{ trans('app.faq') }}</a></li>
        </ul>
    </li>
</ul>
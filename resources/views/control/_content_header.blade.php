<div class="content-heading">
    <!-- START Language list-->
    <div class="pull-right">
        <div class="btn-group">
            <button type="button" data-toggle="dropdown" class="btn btn-default">{{ LaravelLocalization::getCurrentLocaleNative() }}</button>
            <ul role="menu" class="dropdown-menu dropdown-menu-right animated fadeInUpShort">
                @foreach(LaravelLocalization::getSupportedLocales() as $index => $lang)
                    <li>
                        <a  rel="alternate"
                            hreflang="{{ $index }}"
                            href="{{ LaravelLocalization::getLocalizedURL($index ,\URL::current()) }}"
                        >
                            {{ $lang['native'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- END Language list -->
    {{ $title }}
</div>

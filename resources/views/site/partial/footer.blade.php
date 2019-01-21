<footer class="site-footer">

    <!-- Bottom section -->
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-6 col-xs-12 pull-left">
                <p class="copyright-text">{!! trans('app.copyrights',['year' => date('Y') ]) !!}</p>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <ul class="social-icons">
                    @foreach(config('bio.social_media') as $index => $media)
                        <li><a class="{{ $index }}" href="{{ $media }}"><i class="fa fa-{{ $index }}"></i></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- END Bottom section -->

</footer>
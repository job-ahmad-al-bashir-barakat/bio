@foreach($resumes as $resume)

    <div class="row">
        <!-- Resume detail -->
        <div class="col-xs-12">
            <a class="item-block" href="{{ RouteUrls::site_resume_detail($resume->id) }}">
                <header>
                    <img class="resume-avatar" src="{{ replaceImageUrl($resume,'resumes') }}" alt="">
                    <div class="hgroup">
                        <h4>{{ $resume->name }}</h4>
                        <h5>{{ $resume->headline }}</h5>
                    </div>
                </header>

                <div class="item-body">
                    <p>{{ $resume->short_description }}</p>

                    <div class="tag-list">
                        @foreach($resume->tagList as $tag)
                            <span>{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>

                <footer>
                    <ul class="details cols-3">
                        <li>
                            <i class="fa fa-map-marker"></i>
                            <span>{{ $resume->contact->geolocation_title[$lang] ?? '' }}</span>
                        </li>

                        <li>
                            <i class="fa fa-money"></i>
                            <span>{{ trans('app.hour_price',['price' => $resume->salary]) }}</span>
                        </li>

                        @php($resumeEducation = $resume->resumeEducation->last())
                        @if($resume->resumeEducation->count())
                            @if ($resumeEducation->degree->count() || $resumeEducation->majer->count())
                                <li>
                                    <i class="fa fa-certificate"></i>
                                    <span>{{ $resumeEducation->degree->{lang('name')} ?? '' }} - {{ $resumeEducation->majer->name ?? '' }}</span>
                                </li>
                            @endif
                        @endif
                    </ul>
                </footer>
            </a>
        </div>
        <!-- END Resume detail -->
    </div>

@endforeach

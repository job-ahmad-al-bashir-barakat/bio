@foreach($resumes as $resume)
<!-- Job suggestion -->
<div class="col-sm-12 col-md-6">
    <a class="item-block" href="{{ RouteUrls::site_resume_detail($resume->id) }}">
        <header>
            <img class="resume-avatar" src="{{ replaceImageUrl($resume,'resumes') }}">
            <div class="hgroup">
                <h4>{{ $resume->name }}</h4>
                <h5>{{ $resume->headline }}</h5>
            </div>
        </header>

        <footer>
            <ul class="details cols-2">
                <li>
                    <i class="fa fa-map-marker"></i>
                    <span>{{ $resume->contact->geolocation_title[$lang] }}</span>
                </li>

                <li>
                    <i class="fa fa-money"></i>
                    <span>{{ trans('app.hour_price',['price' => $resume->salary]) }}</span>
                </li>
            </ul>
        </footer>
    </a>
</div>
<!-- Job suggestion -->
@endforeach
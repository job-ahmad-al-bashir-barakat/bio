@foreach($resumes as $resume)
<!-- Resume item -->
<div class="item-block">

    <a href="{{ RouteUrls::site_resume_detail($resume->id) }}">
        <header>
            <img class="resume-avatar" src="{{ replaceImageUrl($resume->user) }}">
            <div class="hgroup">
                <h4>{{ $resume->name }}</h4>
                <h5>{{ $resume->headline }}</h5>
            </div>
            <div class="header-meta">
                <span class="location" dir="ltr">{{ $resume->contact->geolocation_title[$lang] }}</span>
                <span class="rate">{{ trans('app.per_hour_price',['price' => $resume->salary]) }}</span>
            </div>
        </header>
    </a>

    <footer>
        <p class="status"><strong>{{ trans('app.updated_on') }}</strong> {{ $resume->last_update->format('M d, Y') }}</p>

        <div class="action-btn">
            <input name="resume" type="checkbox" class="js-switch js-switch-radio" value="{{ $resume->id }}">
        </div>
    </footer>
</div>
<!-- END Resume item -->
@endforeach
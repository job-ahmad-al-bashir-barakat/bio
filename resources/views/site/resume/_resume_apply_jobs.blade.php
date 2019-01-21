@foreach($jobs as $job)
<!-- Job item -->
<div class="item-block">
    <div>
        <a href="{{ RouteUrls::site_job_detail($job->id) }}">
            <header>
                <img class="resume-avatar" src="{{ replaceImageUrl($job->company->first(),'companies') }}">
                <div class="hgroup">
                    <h4>{{ $job->name }}</h4>
                    <h5>{{ $job->company->name }} <span class="label label-success">{{ $job->contract->{lang('name')} }}</span></h5>
                </div>
                <div class="header-meta">
                    <span class="location" dir="ltr"> <span>{{ $job->company->contact->geolocation_title[$lang] }}</span></span>
                    <span class="rate">{{ trans('app.per_hour_price',['price' => $job->salary]) }}</span>
                </div>
            </header>
        </a>
        <footer>
            <p class="status" dir="{{ $dir }}"><strong>{{ trans('app.updated_on') }}</strong> {{ $job->last_update->format('M d, Y') }}</p>

            <div class="action-btn">
                <input name="job" type="checkbox" class="js-switch js-switch-radio" value="{{ $job->id }}">
            </div>
        </footer>
    </div>
</div>
<!-- END Job item -->
@endforeach
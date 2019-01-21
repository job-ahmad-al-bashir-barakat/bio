@foreach($jobs as $job)
<!-- Job suggestion -->
<div class="col-sm-12 col-md-6">
    <a class="item-block" href="{{ RouteUrls::site_job_detail($job->id) }}">
        <header>
            <img class="resume-avatar" src="{{ replaceImageUrl($job->company->first(),'companies') }}">
            <div class="hgroup">
                <h4>{{ $job->name }}</h4>
                <h5>{{ $job->company->name }}</h5>
            </div>
        </header>

        <footer>
            <ul class="details cols-2">
                <li>
                    <i class="fa fa-map-marker"></i>
                    <span>{{ $job->company->contact->geolocation_title[$lang] }}</span>
                </li>

                <li>
                    <i class="fa fa-money"></i>
                    <span>{{ trans('app.hour_price',['price' => $job->salary]) }}</span>
                </li>
            </ul>
        </footer>
    </a>
</div>
<!-- Job suggestion -->
@endforeach
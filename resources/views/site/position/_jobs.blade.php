@foreach($jobs as $job)
    <!-- Job item -->
    <div class="col-xs-12">
        <a class="item-block" href="{{ RouteUrls::site_job_detail($job->id) }}">
            <header>
                <img src="{{ replaceImageUrl($job->company->first(),'companies') }}">
                <div class="hgroup">
                    <h4>{{ $job->name }}</h4>
                    <h5>{{ $job->company->name }} <span class="label label-success">{{ $job->contract->{lang('name')} }}</span></h5>
                </div>
                <time dir="ltr">{{ $job->last_update->diffForHumans() }}</time>
            </header>

            <div class="item-body">
                <p>{{ $job->short_description }}</p>
            </div>

            <footer>
                <ul class="details cols-3">
                    <li>
                        <i class="fa fa-map-marker"></i>
                        <span>{{ $job->company->contact->geolocation_title[$lang] }}</span>
                    </li>

                    <li>
                        <i class="fa fa-money"></i>
                        <span>{{ trans('app.hour_price',['price' => $job->salary]) }}</span>
                    </li>

                    <li>
                        <i class="fa fa-certificate"></i>
                        <span>{{ implode($job->degree->pluck(lang('name'))->toArray() ,trans('app.or')) }}</span>
                    </li>
                </ul>
            </footer>
        </a>
    </div>
    <!-- END Job item -->
@endforeach
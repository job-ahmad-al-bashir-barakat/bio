@section('_aside')
    <li class="nav-heading ">
       <span>{{ trans('control::app.admin_menu') }}</span>
    </li>

    @if ($user->is_admin)
        <li class="">
           <a href="{{ RouteUrls::users() }}" title="{{ trans('control::app.users') }}">
               <em class="icon-user"></em>
               <span>{{ trans('control::app.users') }}</span>
           </a>
        </li>
    @endif

    <li class="">
        <a href="{{ RouteUrls::resumes() }}" title="{{ trans('control::app.resumes') }}">
            <em class="icon-book-open"></em>
            <span>{{ trans('control::app.resumes') }}</span>
        </a>
    </li>

    <li class="">
        <a href="{{ RouteUrls::companies() }}" title="{{ trans('control::app.companies') }}">
            <em class="icon-organization"></em>
            <span>{{ trans('control::app.companies') }}</span>
        </a>
    </li>

    {{--<li class="">
        <a href="{{ RouteUrls::gallery() }}" title="{{ trans('control::app.gallery') }}">
            <em class="icon-camera"></em>
            <span>{{ trans('control::app.gallery') }}</span>
        </a>
    </li>--}}

    <li class="">
        <a href="#manage_apply" title="{{ trans('control::app.manage_apply') }}" data-toggle="collapse">
            <em class="icon-briefcase"></em>
            <span>{{ trans('control::app.manage_apply') }}</span>
        </a>

        <ul id="manage_apply" class="nav sidebar-subnav collapse">
            <li class="sidebar-subnav-header">{{ trans('control::app.manage_apply') }}</li>

            <li>
                <a href="{{ RouteUrls::resumeApply() }}" title="{{ trans('control::app.resume_apply') }}">
                    <span>{{ trans('control::app.resume_apply') }}</span>
                </a>
            </li>
            <li>
                <a href="{{ RouteUrls::jobApply() }}" title="{{ trans('control::app.job_apply') }}">
                    <span>{{ trans('control::app.job_apply') }}</span>
                </a>
            </li>
        </ul>
    </li>

    @if ($user->is_admin)
        <li class="">
            <a href="#manage_content" title="{{ trans('control::app.manage_content') }}" data-toggle="collapse">
                <em class="icon-note"></em>
                <span>{{ trans('control::app.manage_content') }}</span>
            </a>

            <ul id="manage_content" class="nav sidebar-subnav collapse">
                <li class="sidebar-subnav-header">{{ trans('control::app.manage_content') }}</li>
                {{--<li>
                    <a href="{{ RouteUrls::pages() }}" title="{{ trans('control::app.pages') }}">
                        <span>{{ trans('control::app.pages') }}</span>
                    </a>
                </li>--}}
                <li>
                    <a href="{{ RouteUrls::news() }}" title="{{ trans('control::app.news') }}">
                        <span>{{ trans('control::app.news') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ RouteUrls::faqs() }}" title="{{ trans('control::app.faqs') }}">
                        <span>{{ trans('control::app.faqs') }}</span>
                    </a>
                </li>
                {{--<li>
                    <a href="{{ RouteUrls::counter() }}" title="{{ trans('control::app.counters') }}">
                        <span>{{ trans('control::app.counters') }}</span>
                    </a>
                </li>--}}
            </ul>
        </li>

        <li class="">
            <a href="#settings" title="{{ trans('control::app.settings') }}" data-toggle="collapse">
                <em class="icon-people"></em>
                <span>{{ trans('control::app.settings') }}</span>
            </a>

            <ul id="settings" class="nav sidebar-subnav collapse">
                <li class="sidebar-subnav-header">{{ trans('control::app.settings') }}</li>
                <li>
                    <a href="{{ RouteUrls::categories() }}" title="{{ trans('control::app.categories') }}">
                        <span>{{ trans('control::app.categories') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ RouteUrls::contracts() }}" title="{{ trans('control::app.contracts') }}">
                        <span>{{ trans('control::app.contracts') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ RouteUrls::applyStatuses() }}" title="{{ trans('control::app.apply_statuses') }}">
                        <span>{{ trans('control::app.apply_statuses') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ RouteUrls::schools() }}" title="{{ trans('control::app.schools') }}">
                        <span>{{ trans('control::app.schools') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ RouteUrls::degrees() }}" title="{{ trans('control::app.degrees') }}">
                        <span>{{ trans('control::app.degrees') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ RouteUrls::majers() }}" title="{{ trans('control::app.majers') }}">
                        <span>{{ trans('control::app.majers') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ RouteUrls::skills() }}" title="{{ trans('control::app.skills') }}">
                        <span>{{ trans('control::app.skills') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ RouteUrls::tagLists() }}" title="{{ trans('control::app.tage_lists') }}">
                        <span>{{ trans('control::app.tage_lists') }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ RouteUrls::hourlyRates() }}" title="{{ trans('control::app.hourly_rate') }}">
                        <span>{{ trans('control::app.hourly_rates') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ RouteUrls::socialNetworks() }}" title="{{ trans('control::app.social_networks') }}">
                        <span>{{ trans('control::app.social_networks') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ RouteUrls::faqTypes() }}" title="{{ trans('control::app.faq_types') }}">
                        <span>{{ trans('control::app.faq_types') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ RouteUrls::companyEmployers() }}" title="{{ trans('control::app.company_employers') }}">
                        <span>{{ trans('control::app.company_employers') }}</span>
                    </a>
                </li>

                <li class="">
                    <a href="#work_experience" title="{{ trans('control::app.work_experience') }}" data-toggle="collapse">
                        <em class="fa fa-angle-right"></em>
                        <span>{{ trans('control::app.work_experience') }}</span>
                    </a>

                    <ul id="work_experience" class="nav sidebar-subnav collapse">
                        <li class="sidebar-subnav-header">{{ trans('control::app.work_experience') }}</li>
                        <li>
                            <a href="{{ RouteUrls::experienceCompanies() }}" title="{{ trans('control::app.companies') }}">
                                <span>{{ trans('control::app.companies') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ RouteUrls::experienceJobTitles() }}" title="{{ trans('control::app.job_titles') }}">
                                <span>{{ trans('control::app.job_titles') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    @endif

@endsection

@include('control._aside' ,['module' => 'admin'])

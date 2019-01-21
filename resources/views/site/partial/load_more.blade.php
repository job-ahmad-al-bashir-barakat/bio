<div class="text-center mt-15 load-more">
    @include('site.partial.loader')
    <a class="btn btn-round btn-white mt-15" href="#" onclick="loadMorePage.init(this)" data-url="{{ $url }}" data-page="{{ $page or 3 }}" @if(isset($event)) data-ajax-success="{{ $event }}" @endif>
        <i class="fa fa-refresh m-0"></i> {{ trans('app.load_more') }}
    </a>
</div>
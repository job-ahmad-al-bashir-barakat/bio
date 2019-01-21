@extends('site.layout')

@section('content')
<!-- Site header -->
<header class="site-header size-lg text-center" style="background-image: url({{ asset('background/2.jpeg') }})">
    <div class="container">
        <div class="col-xs-12">
            <h1>{{ trans('app.faq_head') }}</h1>
            <h5 class="font-alt">{{ trans('app.faq_message') }}</h5>
            <br>
            <div id="faq-search" class="form-group">
                <i class="ti-search fa-flip-horizontal1"></i>
                <input type="text" class="form-control" name="search" placeholder="{{ trans('app.type_to_search') }}">
            </div>
        </div>

    </div>
</header>
<!-- END Site header -->

<!-- Main container -->
<main id="faq-result">

    @foreach($faqTypesNames as $index => $faqTypesName)

        <section class="{{ $index % 2 == 0 ? 'bg-alt' : '' }}">
            <div class="container">
                <header class="section-header text-left">
                    <h2>{{ $faqTypesName['name'] }}</h2>
                </header>

                <ul class="faq-items">

                    @foreach($faqs[$faqTypesName['index']] as $faq)
                        <li>
                            <h5>{{ $faq->{lang('title')} }}</h5>
                            <p>{{ $faq->{lang('content')} }}</p>
                        </li>
                    @endforeach

                </ul>
            </div>
        </section>
    @endforeach

</main>
<!-- END Main container -->
@endsection

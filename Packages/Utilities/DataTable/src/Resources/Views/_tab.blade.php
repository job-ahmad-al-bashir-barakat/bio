<div class="row">
    <div class="datatable-sidebar-tab hidden-sm hidden-xs">
        <div class="col-lg-2 col-md-2 visible-lg visible-md darkness tab-area datatable-sidebar-tab-erea"></div>
        <div class="col-lg-2 col-md-2 bhoechie-tab-menu datatable-sidebar-tab-erea">
            <div class="list-group">
                @foreach($tabs as $index => $tab)
                    <a data-tab="{{$id}}_{{$index}}_tab" href="javascript:void(0);" class="list-group-item text-center {{ $tab['class'] }} {{ $index == 0 ? 'active' : '' }}">
                        <h4 class="{{ $tab['icon'] }}"></h4><br/>{{ $tab['title'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 bhoechie-tab datatable-content-tab tabs tabs-content">
        @foreach($tabs as $index => $tab)
            <div data-tab="{{$id}}_{{$index}}_tab" class="bhoechie-tab-content {{ $index == 0 ? "active $tabAnimation" : '' }}" {{ $tab['attr'] }}>
                {!! $tab['content'] !!}
            </div>
        @endforeach
    </div>
</div>
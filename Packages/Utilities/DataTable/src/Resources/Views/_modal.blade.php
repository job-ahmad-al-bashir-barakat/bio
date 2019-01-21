<div id='{{ $id }}' {{--tabindex='-1'--}} data-table="{{$table}}" role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' class='modal datatable-modal fade'>
    <div class='modal-dialog' role='document' style='{{ $dialogWidth }}'>
        <div class='modal-content'>
            <form id='form-dialog' action='#' method='post' class='{{ $form_class }}' {{ $form_attr }}>
                <div class='modal-header'>
                    <button type='button' data-dismiss='modal' aria-label='Close' class='close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                    <h4 id='myModalLabel' class='modal-title'>
                        @if($withTabs)
                            <i class="datatable-sidebar-tab-toggle hidden-lg hidden-md icon-menu datatable-pr-10 hand"></i>
                        @endif
                        <span class='text-dialog'></span>
                    </h4>
                </div>
                <div class='modal-body clearfix {{ $withTabs == true ? 'tabs' : '' }} '>
                    <div class='@if($enableGridSystem) {{ $gridSystem['formHorizontal'] ? 'form-horizontal' : '' }} @else form-horizontal @endif'>
                        {!! $continer !!}
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' data-dismiss='modal' class='btn btn-default datatable-m-top-5'>{{ trans('datatable::table.dialog.close') }}</button>
                    <button type='submit' data-loading-text="<i class='fa fa-circle-o-notch fa-spin'> </i> {{ trans('datatable::table.waiting') }}" class='btn btn-primary datatable-m-top-5' data-status='add' ><span class='text-dialog'></span></button>
                    <button type='submit' data-loading-text="<i class='fa fa-circle-o-notch fa-spin'> </i> {{ trans('datatable::table.waiting') }}" class='btn btn-primary datatable-m-top-5' data-status='save'><span>{{ trans('datatable::table.dialog.save_add_new') }}</span></button>
                    {!! $dialogFooter !!}
                </div>
            </form>
        </div>
    </div>
</div>
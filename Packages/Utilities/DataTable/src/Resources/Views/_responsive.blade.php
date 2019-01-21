<div class="row">
    <div class="col-md-12">
        <div data-dt-row={!! autDatatableEval('col.rowIndex') !!} data-dt-column={!! autDatatableEval('col.columnIndex') !!}>

            <label class="col-xs-12">
                {!! autDatatableEval('col.title') !!} <span>:</span>
            </label>

            <span class="col-xs-12">
                {!! autDatatableEval('col.data') !!}
            </span>
        </div>
    </div>
</div>
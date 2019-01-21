<div style="display: {{ strlen($name) > 50 ? 'inline-table' : 'block' }}; height: 30px;">
    <div class='pull-left' >{{ $name }}</div>

    @unless($approvied)
        <div class='pull-right' style="position:relative;">
            <div style='font-size: 0.8em;  text-align: center;'>
                <span class=' icon icon-trash hand delete-autocomplete' style='padding: 5px; font-size: 0.9em; margin: 0px 5px;' data-key='{{ $id }}' data-action='{{ autocompleteURL("$model/$id") }}'></span>
                <span class=' {{ $approviedIcon }} fa fa-check hand approvied-autocomplete' style='padding: 5px; font-size: 0.9em;' data-key='{{ $id }}' data-action='{{ autocompleteURL("$model/$id") }}'></span>
            </div>
            <div style='font-size: 0.6em; opacity: 0.4;'>
                <i>{{ trans('autocomplete::autocomplete.need_to_approvied') }}</i>
            </div>
        </div>
    @endunless
</div>

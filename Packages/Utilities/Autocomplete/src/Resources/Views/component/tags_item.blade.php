@unless($approvied)
{{--<div>--}}
    <span style='padding: 5px; text-overflow: ellipsis !important; white-space: normal;'>{{ $text }}</span>
    <span class='pull-right icon icon-trash hand delete-autocomplete' style='padding: 5px; font-size: 0.9em; margin: 0px 5px;' data-key='{{ $id }}' data-action='{{ autocompleteURL("$model/$id") }}'></span>
    <span class='pull-right {{ $approviedIcon }} fa fa-check hand approvied-autocomplete' style='padding: 5px; font-size: 0.9em;' data-key='{{ $id }}' data-action='{{ autocompleteURL("$model/$id") }}'></span>
{{--</div>--}}
@else
    {{ $text }}
@endunless


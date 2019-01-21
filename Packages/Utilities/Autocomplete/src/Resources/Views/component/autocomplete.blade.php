@php
    $tags = $tags ? ['data-tags' => $tags] : [];
@endphp

{!! Form::select($name,$option,array_keys($option),array_merge([
     'id'                    => $id,
     'class'                 => "form-control autocomplete $class",
     'data-letter'           => $letter,
     'data-placeholder'      => $placeholder,
     'tabindex'              => '1',
     'style'                 => "width: 100%",
     'data-remote'           => $remoteUrl
],array_merge($attr ,$tags))) !!}

@if($tags)
    <div class="text-info" style="font-size: 0.8em;">{{ trans('autocomplete::autocomplete.insert_new_item_autocomplete') }}</div>
@endif
{!! $dataTable["table"] !!}

{!! $dataTable["dialog"] !!}

{!! $dataTable["script"] !!}

@foreach($dataTable["blade"] as $index => $value)
    <div id="{{ $index }}" class="bladeCont" data-append="{{ $value['appendLocation'] }}" data-append-type="{{ $value['appendType'] }}">
        {!! $value['content'] !!}
    </div>
@endforeach

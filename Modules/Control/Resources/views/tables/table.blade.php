@extends('control::layouts.layout')

@section('content_header')
    @include('control::layouts._content_header' ,['title' => $title])
@endsection

@section('content')
    <div class="container-fluid">
        <!-- START row-->
        <div class="row">
            <div class="col-lg-12">
                @component('control.component.panel', [
                    'id'     => "panel-$table",
                    'title'  => $title,
                    'class'  => 'p0',
                    'footer' => false,
                ])
                    {!! datatable($table ,$param) !!}
                @endcomponent
            </div>
        </div>
    </div>
@stop

@section('footer')
    @includeWhen($subPage, $subPage)
@endsection
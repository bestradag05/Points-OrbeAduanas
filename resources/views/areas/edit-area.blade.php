@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un Área</h2>
        <div>
            <a href="{{ url('/areas') }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>
@stop

@section('dinamic-content')
    <form action="{{ url('/areas/' . $area->id) }}" method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include('areas.form-area', ['formMode' => 'edit'])
    </form>
@stop

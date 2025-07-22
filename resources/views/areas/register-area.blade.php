@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registrar un Área</h2>
        <div>
            <a href="{{ url('/areas') }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>
@stop

@section('dinamic-content')
    <form action="{{ url('/areas') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('areas.form-area', ['formMode' => 'create'])
    </form>
@stop

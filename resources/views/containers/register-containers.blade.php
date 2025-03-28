@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registrar Contenedor</h2>
        <div>
            <a href="{{ url('/containers') }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>
@stop

@section('dinamic-content')
    <form action="{{ route('containers.store') }}" method="POST">
        @csrf
        @include ('containers.form-containers', ['formMode' => 'create'])
    </form>
@stop
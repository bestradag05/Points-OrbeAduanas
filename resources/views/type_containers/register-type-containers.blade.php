@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registrar Tipo de Contenedor</h2>
        <div>
            <a href="{{ url('/type_containers') }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>
@stop

@section('dinamic-content')
    <form action="/type_containers" method="POST">
        @csrf
        @include ('type_containers.form-type-containers', ['formMode' => 'create'])
    </form>
@stop
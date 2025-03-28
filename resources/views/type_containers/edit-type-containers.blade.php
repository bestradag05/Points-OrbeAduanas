@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar Tipo de Contenedor</h2>
        <div>
            <a href="{{ url('/type_containers') }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>
@stop

@section('dinamic-content')
    <form action="{{ route('type_containers.update', $typeContainer->id) }}" method="POST">
        @method('PATCH')
        @csrf
        @include ('type-containers.form-type-containers', ['formMode' => 'edit'])
    </form>
@stop
@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar Contenedor</h2>
        <div>
            <a href="{{ url('/containers') }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>
@stop

@section('dinamic-content')
    <form action="{{ route('containers.update', $container->id) }}" method="POST">
        @method('PATCH')
        @csrf
        @include ('containers.form-containers', ['formMode' => 'edit'])
    </form>
@stop
@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un Equipo</h2>
        <div>
            <a href="{{ url('/teams') }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>
@stop

@section('dinamic-content')
    <form action="{{ url('/teams/' . $team->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        @include('teams.form-team', ['formMode' => 'edit'])
    </form>
@stop

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registrar un Equipo</h2>
        <div>
            <a href="{{ url('/teams') }}" class="btn btn-primary">Atrás</a>
        </div>
    </div>
@stop

@section('dinamic-content')
    <form action="{{ url('/teams') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('teams.form-team', ['formMode' => 'create'])
    </form>
@stop

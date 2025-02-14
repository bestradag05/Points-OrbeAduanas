@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registrar Nuevo Régimen</h2>
        <div>
        <a href="{{url('/regimes') }}" class="btn btn-primary"> Atras </a>
       </div>
    </div>
@stop

@section('dinamic-content')
    <form action="/regimes" method="POST" enctype="multipart/form-data">
        @csrf
        @include('regimes.form-regimes') <!-- Incluye el formulario reutilizable -->
    </form>
@stop
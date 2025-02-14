@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un Regimen</h2>
        <div>
        <a href="{{url('/regimes') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/regimes/'. $regime->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        @include ('regimes.form-regimes', ['formMode' => 'edit'])
    </form>

   
@stop
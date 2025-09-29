@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un Regimen</h2>
        <div>
        <a href="{{url('/warehouses') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/warehouses/'. $warehouses->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PUT') }}
        {{ csrf_field() }}
        @include ('warehouses.form-warehouse', ['formMode' => 'edit'])
    </form>

   
@stop
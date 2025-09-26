@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registrar Nuevo Régimen</h2>
        <div>
        <a href="{{url('/warehouses') }}" class="btn btn-primary"> Atras </a>
       </div>
    </div>
@stop

@section('dinamic-content')
    <form action="/warehouses" method="POST" enctype="multipart/form-data">
        @csrf
        @include('warehouses.form-warehouse', ['formMode' => 'create']) <!-- Incluye el formulario reutilizable -->
    </form>
@stop
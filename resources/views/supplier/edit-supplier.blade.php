@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un proveedor</h2>
        <a href="{{ url('suppliers') }}" class="btn btn-primary">Atrás</a>
    </div>
@stop

@section('dinamic-content')
    <form action="{{ url('suppliers/'.$supplier->id) }}" method="POST">
        @method('PATCH')
        @csrf
        @include('supplier.form-supplier', ['formMode' => 'edit'])
    </form>
@stop

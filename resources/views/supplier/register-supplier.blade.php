@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registrar un proveedor</h2>
        <a href="{{ url('suppliers') }}" class="btn btn-primary">Atrás</a>
    </div>
@stop

@section('dinamic-content')
    <form action="{{ url('suppliers') }}" method="POST">
        @csrf
        @include('supplier.form-supplier', ['formMode' => 'create'])
    </form>
@stop

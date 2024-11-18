@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un proveedor</h2>
        <div>
            <a href="{{url('/suppliers') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/suppliers" method="post" enctype="multipart/form-data">
        @csrf
        @include ('supplier.form-supplier', ['formMode' => 'create'])
    </form>


@stop

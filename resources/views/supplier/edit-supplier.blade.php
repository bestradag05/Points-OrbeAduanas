@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un Cliente</h2>
        <div>
            <a href="{{ url('/suppliers') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/suppliers/'. $supplier->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('supplier.form-supplier', ['formMode' => 'edit'])
    </form>

   
@stop

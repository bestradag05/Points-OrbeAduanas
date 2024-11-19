@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un tipo de embarque</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/type_load/'. $type_load->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('type_load.form-type_load', ['formMode' => 'edit'])
    </form>

   
@stop

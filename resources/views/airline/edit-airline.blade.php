@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar aerolínea</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/airline/'. $airline->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('airline.form-airline', ['formMode' => 'edit'])
    </form>

   
@stop

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Generar punto de aduana</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/custom/'. $custom->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('custom.form-point-custom', ['formMode' => 'edit'])
    </form>

   
@stop

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un pais</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/country/'. $country->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('country.form-country', ['formMode' => 'edit'])
    </form>

   
@stop
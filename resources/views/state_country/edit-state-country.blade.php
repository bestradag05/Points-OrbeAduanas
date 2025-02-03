@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar una ciudad</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/state_country/'. $stateCountry->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('state_country.form-state-country', ['formMode' => 'edit'])
    </form>

   
@stop
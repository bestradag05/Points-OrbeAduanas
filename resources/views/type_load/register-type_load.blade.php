@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un tipo de carga</h2>
        <div>
            <a href="{{url('/type_load') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/type_load" method="post" enctype="multipart/form-data">
        @csrf
        @include ('type_load.form-type_load', ['formMode' => 'create'])
    </form>


@stop

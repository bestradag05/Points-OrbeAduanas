@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra Circunscripción - Aduana</h2>
        <div>
            <a href="{{url('/customs_districts') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/customs_districts" method="post" enctype="multipart/form-data">
        @csrf
        @include ('custom_districts.form-custom_district', ['formMode' => 'create'])
    </form>


@stop

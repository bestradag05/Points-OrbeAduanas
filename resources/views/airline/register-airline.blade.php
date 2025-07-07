@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra una aerolínea</h2>
        <div>
            <a href="{{url('/airline') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/airline" method="post" enctype="multipart/form-data">
        @csrf
        @include ('airline.form-airline', ['formMode' => 'create'])
    </form>


@stop

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un transporte</h2>
        <div>
            <a href="{{url('/transport') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/transport" method="post" enctype="multipart/form-data">
        @csrf
        @include ('transport.form-transport', ['formMode' => 'create'])
    </form>


@stop

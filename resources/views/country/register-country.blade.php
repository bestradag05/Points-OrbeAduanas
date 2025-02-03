@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un incoterm</h2>
        <div>
            <a href="{{url('/country') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/country" method="post" enctype="multipart/form-data">
        @csrf
        @include ('country.form-country', ['formMode' => 'create'])
    </form>


@stop
@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un incoterm</h2>
        <div>
            <a href="{{url('/currencies') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/currencies" method="post" enctype="multipart/form-data">
        @csrf
        @include ('currencies.form-currencies', ['formMode' => 'create'])
    </form>


@stop

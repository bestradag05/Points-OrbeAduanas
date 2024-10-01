@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un concepto</h2>
        <div>
            <a href="{{url('/concepts') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/concepts" method="post" enctype="multipart/form-data">
        @csrf
        @include ('concepts.form-concepts', ['formMode' => 'create'])
    </form>


@stop

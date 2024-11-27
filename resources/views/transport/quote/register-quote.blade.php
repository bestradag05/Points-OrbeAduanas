@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Cotizacion de transporte</h2>
        <div>
            <a href="{{url('/quote') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/quote" method="post" enctype="multipart/form-data">
        @csrf
        @include ('transport.quote.form-quote', ['formMode' => 'create'])
    </form>


@stop

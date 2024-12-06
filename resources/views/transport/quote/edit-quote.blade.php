@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Cotizacion de transporte</h2>
        <div>
            <a href="{{ url('/quote') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')

    <form action={{ url('/quote/transport/' . $quote->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('transport.quote.form-quote', ['formMode' => 'edit'])
    </form>


@stop

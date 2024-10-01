@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un tipo de embarque</h2>
        <div>
            <a href="{{url('/type_shipment') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/type_shipment" method="post" enctype="multipart/form-data">
        @csrf
        @include ('type_shipment.form-type_shipment', ['formMode' => 'create'])
    </form>


@stop

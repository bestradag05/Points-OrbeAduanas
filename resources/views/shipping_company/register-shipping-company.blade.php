@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un tipo de empaque</h2>
        <div>
            <a href="{{url('/shipping_company') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/shipping_company" method="post" enctype="multipart/form-data">
        @csrf
        @include ('shipping_company.form-shipping-company', ['formMode' => 'create'])
    </form>


@stop

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un cliente</h2>
        <div>
            <a href="{{url('/customer') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/customer" method="post" enctype="multipart/form-data">
        @csrf
        @include ('customer.form-customer', ['formMode' => 'create'])
    </form>


@stop

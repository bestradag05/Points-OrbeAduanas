@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un Cliente</h2>
        <div>
            <a href="{{ url('/customer') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/customer/'. $customer->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('customer.form-customer', ['formMode' => 'edit'])
    </form>

   
@stop

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un tipo de empaque</h2>
        <div>
            <a href="{{url('/packing_type') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/packing_type" method="post" enctype="multipart/form-data">
        @csrf
        @include ('packing_type.form-packing-type', ['formMode' => 'create'])
    </form>


@stop

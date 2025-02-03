@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Generar punto de flete</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')


    <form action={{ url('/freight/' . $freight->id) }} method="POST" id="formFreight" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('freight.form-freight', ['formMode' => 'edit'])
    </form>


@stop

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un Flete</h2>
        <div>
            <a href="{{url('/quote/freight') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/freight" method="post" id="formFreight" enctype="multipart/form-data">
        @csrf
        @include ('freight.form-freight', ['formMode' => 'create'])
    </form>


@stop

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un modalidad</h2>
        <div>
            <a href="{{url('/modality') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/modality" method="post" enctype="multipart/form-data">
        @csrf
        @include ('modality.form-modality', ['formMode' => 'create'])
    </form>


@stop

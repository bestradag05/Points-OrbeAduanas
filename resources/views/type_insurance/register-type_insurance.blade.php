@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un tipo de seguro</h2>
        <div>
            <a href="{{url('/type_insurance') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/type_insurance" method="post" enctype="multipart/form-data">
        @csrf
        @include ('type_insurance.form-type_insurance', ['formMode' => 'create'])
    </form>


@stop

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un incoterm</h2>
        <div>
            <a href="{{url('/incoterms') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/incoterms" method="post" enctype="multipart/form-data">
        @csrf
        @include ('incoterms.form-incoterm', ['formMode' => 'create'])
    </form>


@stop

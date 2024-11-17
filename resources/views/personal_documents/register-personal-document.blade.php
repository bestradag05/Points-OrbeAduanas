@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un tipo de documento</h2>
        <div>
            <a href="{{url('/document') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/personal_document" method="post" enctype="multipart/form-data">
        @csrf
        @include ('personal_documents.form-personal-document', ['formMode' => 'create'])
    </form>


@stop

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar documento del personal</h2>
        <div>
            <a href="{{ url('/personal_document') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/personal_document/'. $personal_document->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('personal_documents.form-personal-document', ['formMode' => 'edit'])
    </form>

   
@stop

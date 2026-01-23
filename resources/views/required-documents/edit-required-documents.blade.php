@extends('home')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Editar Documento Requerido</h1>
        </div>
        <div class="col-sm-6">
            <a href="{{ route('required-documents.index') }}" class="btn btn-secondary float-right">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
@stop

@section('dinamic-content')

    <form action="{{ route('required-documents.update', $document->id) }}" method="POST" enctype="multipart/form-data"
        class="form-horizontal">
        @csrf
        @method('PUT')
        @include('required-documents.form-required-documents', ['formMode' => 'edit'])

    </form>
@endsection

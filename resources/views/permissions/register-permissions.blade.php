@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un Permiso</h2>
        <div>
            <a href="{{url('/permissions') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

    @if(isset($error))
    <div class="alert alert-danger">
        {{ $error }}
    </div>
@endif

@stop
@section('dinamic-content')
    <form action="/permissions" method="post" enctype="multipart/form-data">
        @csrf
        @include ('permissions.form-permissions', ['formMode' => 'create'])
    </form>

   
@stop

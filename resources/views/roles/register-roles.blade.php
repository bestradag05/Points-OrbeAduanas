@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un rol</h2>
        <div>
            <a href="{{url('/roles') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

    @if(isset($error))
    <div class="alert alert-danger">
        {{ $error }}
    </div>
@endif

@stop
@section('dinamic-content')
    <form action="/roles" method="post" enctype="multipart/form-data">
        @csrf
        @include ('roles.form-roles', ['formMode' => 'create'])
    </form>

   
@stop

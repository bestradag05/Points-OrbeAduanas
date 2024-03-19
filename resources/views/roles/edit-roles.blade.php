@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un roles</h2>
        <div>
            <a href="{{url('/roles') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/roles/'. $rol->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('roles.form-roles', ['formMode' => 'edit'])
    </form>

   
@stop

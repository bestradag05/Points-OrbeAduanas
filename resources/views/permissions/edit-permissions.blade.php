@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un permiso</h2>
        <div>
            <a href="{{url('/permissions') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/permissions/'. $permission->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('permissions.form-permissions', ['formMode' => 'edit'])
    </form>

   
@stop

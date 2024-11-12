@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un usuario</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/users/'. $user->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('users.form-user', ['formMode' => 'edit'])
    </form>

@stop

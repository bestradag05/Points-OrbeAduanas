@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un usuario</h2>
        <div>
            <a href="{{url('/users') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/users" method="post" enctype="multipart/form-data">
        @csrf
        @include ('users.form-user', ['formMode' => 'create'])
    </form>

@stop

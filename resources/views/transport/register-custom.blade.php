@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra una aduana</h2>
        <div>
            <a href="{{url('/custom') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/custom" method="post" enctype="multipart/form-data">
        @csrf
        @include ('custom.form-custom', ['formMode' => 'create'])
    </form>


@stop

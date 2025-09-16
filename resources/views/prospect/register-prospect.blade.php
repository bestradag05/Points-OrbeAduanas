@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un prospecto</h2>
        <div>
            <a href="{{url('/prospects') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/prospects" method="post" enctype="multipart/form-data">
        @csrf
        @include ('prospect.form-prospect', ['formMode' => 'create'])
    </form>


@stop

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra una ciudad</h2>
        <div>
            <a href="{{url('/state_country') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/state_country" method="post" enctype="multipart/form-data">
        @csrf
        @include ('state_country.form-state-country', ['formMode' => 'create'])
    </form>


@stop
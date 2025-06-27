@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un incoterm</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/currencies/'. $currency->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('currencies.form-currencies', ['formMode' => 'edit'])
    </form>

   
@stop

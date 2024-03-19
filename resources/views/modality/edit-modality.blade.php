@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar modalidad</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/modality/'. $modality->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('modality.form-modality', ['formMode' => 'edit'])
    </form>

   
@stop

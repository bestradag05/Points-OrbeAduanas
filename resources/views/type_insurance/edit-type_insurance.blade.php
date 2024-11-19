@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un tipo de seguro</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/type_insurance/'. $type_insurance->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('type_insurance.form-type_insurance', ['formMode' => 'edit'])
    </form>

   
@stop

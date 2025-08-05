@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar un tipo de seguro</h2>
        <div>
            <a href="{{url('/type_insurance') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/type_insurance/'. $type_insurance->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('insurances.type_insurance.form-type_insurance', ['formMode' => 'edit'])
    </form>

   
@stop

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar tipo de embalaje</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/packing_type/'. $packingType->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('packing_type.form-packing-type', ['formMode' => 'edit'])
    </form>

   
@stop

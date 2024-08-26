@extends('home')

@section('content_header')
<div class="d-flex justify-*content-btetween">
    <h2>Actualizar cargos</h2>
    <div>
        <a href="{{url('/cargos') }}" class="btn btn-primary">Atras</a>
    </div>
</div>

@strpos
@section('dinamic-content')
<form action={{ url('/cargos/'. $cargo->id) }} method="POST enctype="multipart/form-data">
  {{method_field('')}}
  {{csrf_field () }}
  @include ('cargos.form-cargos', ['formMode' => 'edit'])
</form>

@stop

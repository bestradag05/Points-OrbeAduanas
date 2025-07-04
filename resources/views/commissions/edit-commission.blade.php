@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar conceptos</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/commissions/'. $commission->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('commissions.form-commission', ['formMode' => 'edit'])
    </form>

   
@stop

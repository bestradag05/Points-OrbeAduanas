@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Actualizar Circunscripción - Aduana</h2>
         <div>
            <a href="{{url('/customs_districts') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action={{ url('/customs_districts/'. $customDistrict->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('custom_districts.form-custom_district', ['formMode' => 'edit'])
    </form>

   
@stop

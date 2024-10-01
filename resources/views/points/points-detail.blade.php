@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Detalle de puntos</h2>
    </div>

@stop


@section('dinamic-content')

<div class="container">
    <div class="row">
        <div class="col-12">
           {{dd($personalPoints)}}

        </div>
    </div>
</div>

@stop


@push('scripts')


@endpush

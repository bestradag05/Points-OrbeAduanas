@extends('home')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h2>Registrar un transporte</h2>
    <a href="{{ url('/transport') }}" class="btn btn-secondary">Atrás</a>
</div>
@stop

@section('dinamic-content')
<form action="{{ route('transport.store', $quote->id) }}" method="POST" id="formTransport">
    @csrf
    @include ('transport.form-transport', ['formMode' => 'create'])
</form>
@stop

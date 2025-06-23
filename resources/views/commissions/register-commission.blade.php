@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra un concepto</h2>
        <div>
            <a href="{{url('/commissions') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/commissions" method="post" enctype="multipart/form-data">
        @csrf
        @include ('commissions.form-commission', ['formMode' => 'create'])
    </form>


@stop

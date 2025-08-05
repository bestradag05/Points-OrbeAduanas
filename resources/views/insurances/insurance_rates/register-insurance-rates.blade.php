@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Tarifa de seguro</h2>
        <div>
            <a href="{{url('/insurance_rates') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')
    <form action="/insurance_rates" method="post" enctype="multipart/form-data" id="formInsuranceRate">
        @csrf
        @include ('insurances.insurance_rates.form-insurance-rates', ['formMode' => 'create'])
    </form>


@stop

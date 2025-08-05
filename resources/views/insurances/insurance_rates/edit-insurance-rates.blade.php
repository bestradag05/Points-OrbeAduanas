@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Editar tarifas del seguro</h2>
        <div>
           <a href="{{url('/insurance_rates') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')


<form action={{ url('/insurance_rates/' . $insurance_rate->id) }} method="POST" enctype="multipart/form-data" id="formInsuranceRate">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}
    @include ('insurances.insurance_rates.form-insurance-rates', ['formMode' => 'edit'])
</form>


@stop


@push('scripts')
    <script>
        $('#reguralization').datetimepicker({
            format: 'DD/MM/YYYY',
            lang: 'es',
            mask: true,
            timepicker: false
            
            
        });


    </script>


@endpush


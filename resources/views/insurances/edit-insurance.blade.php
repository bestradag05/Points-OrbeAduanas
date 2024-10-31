@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Generar punto de seguro</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')


<form action={{ url('/insurance/' . $insurance->id) }} method="POST" enctype="multipart/form-data">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}
    @include ('insurances.form-point-insurance', ['formMode' => 'edit'])
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


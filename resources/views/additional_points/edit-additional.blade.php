@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Generar puntos adicionales</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')


<form action={{ url('/additionals/' . $additional->id) }} method="POST" enctype="multipart/form-data">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}
    @include ('additional_points.form-point-additional', ['formMode' => 'edit'])
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


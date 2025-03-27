@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Editar un transporte</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')

    <form action={{ url('/transport/' . $transport->id) }}  method="POST" id="formTransport" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('transport.form-transport', ['formMode' => 'edit'])
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

        $('#doc_custom').change(function() {
            var archivo = $(this).prop('files')[0];
            if (archivo) {
                // Por ejemplo, podrías enviar el formulario después de seleccionar el archivo

                $('#formLoadFile').submit();
            }
        });
    </script>
@endpush

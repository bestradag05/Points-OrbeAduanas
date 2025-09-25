@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Editar una aduana</h2>
        <div>
           <a href="{{ url()->previous() }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')


<form action={{ url('/custom/' . $custom->id) }} id="formCustom" method="POST" enctype="multipart/form-data">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}
    @include ('custom.form-custom', ['formMode' => 'edit'])
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


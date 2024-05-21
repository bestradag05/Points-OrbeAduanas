@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Generar punto de aduana</h2>
        <div>
            <button class="btn btn-primary"> Atras </button>
        </div>
    </div>

@stop
@section('dinamic-content')

    {{-- @section('plugins.BsCustomFileInput', true)

<form action="{{ url('/custom/load') }}" id="formLoadFile" method="post" enctype="multipart/form-data">
    @csrf
    <div class="col-12">
        <x-adminlte-input-file name="doc_custom" igroup-size="md" placeholder="Suba el archivo...">
            <x-slot name="prependSlot">
                <div class="input-group-text bg-lightblue">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>
        </x-adminlte-input-file>
        <hr>
    </div>
</form> --}}

    <form action={{ url('/transport/' . $transport->id) }} method="POST" enctype="multipart/form-data">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        @include ('transport.form-point-transport', ['formMode' => 'edit'])
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

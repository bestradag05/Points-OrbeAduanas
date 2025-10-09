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

    <div id="modalAddConcept" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalAddConceptTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" id="formAddConcept">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddConceptTitle">Agregar Concepto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Nombre del concepto</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Ingrese el nombre" value="">
                            </div>
                            <div class="col-md-6">
                                <x-adminlte-select2 name="id_type_shipment" label="Tipo de embarque" igroup-size="md"
                                    readonly="true" data-placeholder="Selecciona una opcion...">
                                    <option />
                                    @foreach ($typeShipments as $typeShipment)
                                        <option value="{{ $typeShipment->id }}"
                                            {{ $custom->commercial_quote->type_shipment->name === $typeShipment->name ? 'selected' : '' }}>
                                            {{ $typeShipment->name }}
                                        </option>
                                    @endforeach
                                </x-adminlte-select2>

                            </div>
                            <div class="col-md-6">
                                <x-adminlte-select2 name="id_type_service" label="Tipo de servicio" igroup-size="md"
                                    readonly="true" data-placeholder="Selecciona una opcion...">
                                    <option />
                                    @foreach ($typeServices as $typeService)
                                        <option value="{{ $typeService->id }}"
                                            {{ $typeService->name === 'Aduanas' ? 'selected' : '' }}>
                                            {{ $typeService->name }}
                                        </option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="closeToModal('modalAddConcept')">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="saveConceptToDatabase()">Guardar
                            Concepto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


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

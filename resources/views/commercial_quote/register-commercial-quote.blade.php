@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Registra una cotización</h2>
        <div>
            <a href="{{ url('/commercial/quote') }}" class="btn btn-primary"> Atras </a>
        </div>
    </div>

@stop
@section('dinamic-content')



    <div class="mb-5 p-4">
        <div id="stepper" class="bs-stepper linear">
            <div class="bs-stepper-header" role="tablist">
                <div class="step active" data-target="#informacion">
                    <button type="button" class="step-trigger" role="tab" id="stepperInformacion"
                        aria-controls="informacion" aria-selected="true">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">Informacion</span>
                    </button>
                </div>
                <div class="bs-stepper-line"></div>
                <div class="step" data-target="#detalle_producto">
                    <button type="button" class="step-trigger" role="tab" id="stepperDetalleProducto"
                        aria-controls="detalle_producto" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">Detalle del Producto</span>
                    </button>
                </div>
                <div class="bs-stepper-line"></div>
                <div class="step" data-target="#servicios">
                    <button type="button" class="step-trigger" role="tab" id="stepperServicios"
                        aria-controls="servicios" aria-selected="false" disabled="disabled">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">Servicios</span>
                    </button>
                </div>

            </div>
            <div class="bs-stepper-content">
                <form id="formRouting" onsubmit="return false;" action="/commercial/quote" method="post"
                    enctype="multipart/form-data">

                    @csrf
                    @include ('commercial_quote.form-commercial-quote', ['formMode' => 'create'])


                </form>
            </div>
        </div>
    </div>


    <div id="modal-consolidated" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-consolidated-title"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-consolidated-title">Consolidado</h5>
                    <button  class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-consolidated" method="POST">
                   
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12">
                                <x-adminlte-select2 name="id_incoterms" class="required" label="Incoterms" igroup-size="md"
                                    data-placeholder="Seleccione una opcion...">
                                    <option />
                                    @foreach ($incoterms as $incoter)
                                        <option value="{{ $incoter->id }}"
                                            {{ (isset($routing->id_incoterms) && $routing->id_incoterms == $incoter->id) || old('id_incoterms') == $incoter->id ? 'selected' : '' }}>
                                            {{ $incoter->code }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="shipper_name">Proveedor:</label>
                                    <input id="shipper_name" class="form-control required" type="text" name="shipper_name">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="shipper_contact">Contacto:</label>
                                    <input id="shipper_contact" class="form-control" type="text" name="shipper_contact">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="shipper_contact_email">Correo de contacto:</label>
                                    <input id="shipper_contact_email" class="form-control" type="text"
                                        name="shipper_contact_email">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="shipper_contact_phone">Nro de contacto:</label>
                                    <input id="shipper_contact_phone" class="form-control" type="text"
                                        name="shipper_contact_phone">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="shipper_address">Direccion:</label>
                                    <input id="shipper_address" class="form-control required" type="text"
                                        name="shipper_address">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="commodity">Descripcion de la carga:</label>
                                    <input id="commodity" class="form-control required" type="text" name="commodity">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="load_value">Valor de la carga:</label>
                                    <input id="load_value" class="form-control required CurrencyInput" data-type="currency"
                                        type="text" name="load_value">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="nro_packages_consolidated">Nro de Bultos:</label>
                                    <input id="nro_packages_consolidated" type="number" min="0" step="1"
                                        class="form-control" type="text" name="nro_packages_consolidated">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="packaging_type_consolidated">Tipo Embalaje:</label>
                                    <input id="packaging_type_consolidated" class="form-control"
                                        type="text" name="packaging_type_consolidated">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="volumen">Volumen:</label>
                                    <input id="volumen" class="form-control CurrencyInput" data-type="currency"
                                        type="text" name="volumen">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="kilograms">Peso total:</label>
                                    <input id="kilograms" class="form-control CurrencyInput" data-type="currency"
                                        type="text" name="kilograms">
                                </div>
                            </div>
                            

                            <div id="container-measures-consolidated" class="col-12 mt-2">

                                <div id="div-measures-consolidated" class="row justify-content-center">

                                    <div class="col-2">
                                        <input type="number" class="form-control" step="1"
                                            id="amount_package_consolidated" name="amount_package_consolidated"
                                            placeholder="Ingresa la cantidad">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control CurrencyInput" data-type="currency"
                                            id="width" name="width" placeholder="Ancho(cm)">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control CurrencyInput" data-type="currency"
                                            id="length" name="length" placeholder="Largo(cm)">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control CurrencyInput" data-type="currency"
                                            id="height" name="height" placeholder="Alto(cm)">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-indigo btn-sm" onclick="addMeasuresConsolidate()"><i
                                                class="fa fa-plus"></i>Agregar</button>
                                    </div>

                                </div>

                                <table id="measures-consolidated" class="table table-bordered mt-3" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cantidad</th>
                                            <th>Ancho (cm)</th>
                                            <th>Largo (cm)</th>
                                            <th>Alto (cm)</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                </table>
                               
                                <input id="value-measures-consolidated" type="hidden"
                                name="value-measures-consolidated" />

                                @error('value-measures-consolidated')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>


                        </div>

                    </div>
                </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="saveConsolidated(event)">Guardar</button>
                        <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetailLabel">Detalles del Shipper</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <tbody id="shipper-details"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


@stop


@push('scripts')

@endpush

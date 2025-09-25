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


    <div id="modalSelectServices" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modalSelectServices-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSelectServices-title">Genera tu cotización</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formSelectServices" method="POST">

                    <div class="modal-body">
                        <div class="row text-center">
                            <div class="col-12 mb-4">
                                <h5 class="text-indigo text-center mb-3">Seleccione los servicios que se cotizaran para
                                    incluir
                                    dentro de este
                                    documento</h5>
                                <div class="icheck-primary d-inline mx-4 mt-4">
                                    <input type="checkbox" id="servicio_integral" value="integral" name="servicio_integral"
                                        onchange="selectAllServices()">
                                    <label for="servicio_integral">
                                        Servicio Integral
                                    </label>
                                </div>
                            </div>

                            <div class="col-12">
                                @foreach ($types_services as $type_service)
                                    <div class="icheck-danger d-inline mx-4 mt-4">
                                        <input type="checkbox" id="type_service_{{ $type_service->id }}"
                                            value="{{ $type_service->name }}" name="type_service[]">
                                        <label for="type_service_{{ $type_service->id }}">
                                            {{ $type_service->name }}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" id="btnGenerarServicios" class="btn btn-primary">Generar</button>
                    <a class="btn btn-secondary"  href="{{ route('quote.index') }}" >Cancelar</a>
                </div>

            </div>
        </div>
    </div>

    <div id="modal-consolidated" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-consolidated-title"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-consolidated-title">Consolidado</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-consolidated" method="POST">

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-12">
                                <x-adminlte-select2 name="id_incoterms" class="required" label="Incoterms"
                                    igroup-size="md" data-placeholder="Seleccione una opcion...">
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
                                    <input id="shipper_name" class="form-control required" type="text"
                                        name="shipper_name">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="shipper_contact">Contacto:</label>
                                    <input id="shipper_contact" class="form-control" type="text"
                                        name="shipper_contact">
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
                                    <input id="load_value" class="form-control required CurrencyInput"
                                        data-type="currency" type="text" name="load_value">
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
                                    <label for="id_packaging_type_consolidated">Tipo Embalaje:</label>
                                    {{-- <input id="id_packaging_type_consolidated" class="form-control"
                                        type="text" name="id_packaging_type_consolidated"> --}}

                                    <x-adminlte-select2 id="id_packaging_type_consolidated"
                                        name="id_packaging_type_consolidated" data-placeholder="Seleccione una opcion...">
                                        <option />
                                        @foreach ($packingTypes as $packingType)
                                            <option value="{{ $packingType->id }}">
                                                {{ $packingType->name }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            </div>

                            <div id="contenedor_vol_consolidated" class="col-4">
                                <div class="form-group">
                                    <label for="volumen">Volumen:</label>
                                    <input id="volumen" class="form-control CurrencyInput" data-type="currency"
                                        type="text" name="volumen">
                                </div>
                            </div>

                            <div id="contenedor_kg_vol_consolidated" class="col-4 d-none">
                                <div class="form-group">
                                    <label for="kilogram_volumen">KGV:</label>
                                    <input id="kilogram_volumen" class="form-control CurrencyInput" data-type="currency"
                                        type="text" name="kilogram_volumen">
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
                                            id="width" name="width" placeholder="Ancho">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control CurrencyInput" data-type="currency"
                                            id="length" name="length" placeholder="Largo">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control CurrencyInput" data-type="currency"
                                            id="height" name="height" placeholder="Alto">
                                    </div>
                                    <div class="col-2">
                                        <select class="form-control" id="units_measurements" name="units_measurements">
                                            <option value="cm">cm</option>
                                            <option value="in">in</option>
                                            <option value="lbs">lbs</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-indigo btn-sm"
                                            onclick="addMeasuresConsolidate()"><i class="fa fa-plus"></i>Agregar</button>
                                    </div>

                                </div>

                                <table id="measures-consolidated" class="table table-bordered mt-3" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Cantidad</th>
                                            <th>Ancho</th>
                                            <th>Largo</th>
                                            <th>Alto</th>
                                            <th>Unidad</th>
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

    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel"
        aria-hidden="true">
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

    {{-- Modal container --}}

    <div id="modalAddedContainer" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modalAddedContainer-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="row" id="formContainer">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="id_containers">Tipo de contenedor <span class="text-danger">*</span></label>

                                <select class="form-control @error('id_containers') is-invalid @enderror"
                                    id="id_containers" name="id_containers" data-required="true">
                                    <option value="">Seleccione un tipo</option>
                                    @foreach ($containers as $container)
                                        <option value="{{ $container->id }}"
                                            {{ old('id_containers') == $container->id ? 'selected' : '' }}>
                                            {{ $container->typeContainer->name }} - {{ $container->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_containers')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="container_quantity">Nº de contenedores <span
                                        class="text-danger">*</span></label>

                                <input type="number" min="0" step="1"
                                    class="form-control @error('container_quantity') is-invalid @enderror"
                                    id="container_quantity" name="container_quantity" data-required="true"
                                    placeholder="Ingrese el nro de contenedores.." oninput="validarInputNumber(this)"
                                    value="{{ isset($routing) ? $routing->container_quantity : '' }}">
                                @error('container_quantity')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="commodity">Producto <span class="text-danger">*</span></label>

                                <input type="text" class="form-control @error('commodity') is-invalid @enderror"
                                    id="commodity" name="commodity" placeholder="Ingrese el producto.."
                                    data-required="true"
                                    value="{{ isset($routing->commodity) ? $routing->commodity : old('commodity') }}">
                                @error('commodity')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="nro_package">N° Paquetes / Bultos</label>
                                <input type="number" min="0" step="1"
                                    class="form-control @error('nro_package') is-invalid @enderror" id="nro_package"
                                    name="nro_package" placeholder="Ingrese el nro de paquetes.."
                                    oninput="validarInputNumber(this)"
                                    value="{{ isset($routing) ? $routing->nro_package : '' }}">
                                @error('nro_package')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="id_packaging_type">Tipo de embalaje</label>

                                <x-adminlte-select2 name="id_packaging_type" data-placeholder="Seleccione una opcion...">
                                    <option />
                                    @foreach ($packingTypes as $packingType)
                                        <option value="{{ $packingType->id }}">
                                            {{ $packingType->name }}
                                        </option>
                                    @endforeach
                                </x-adminlte-select2>

                            </div>
                        </div>

                        <div class="col-6 transporte-hide">
                            <div class="form-group row">
                                <label for="load_value">Valor de factura </label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-bold @error('load_value') is-invalid @enderror">
                                            $
                                        </span>
                                    </div>
                                    <input type="text"
                                        class="form-control CurrencyInput @error('load_value') is-invalid @enderror "
                                        name="load_value" data-type="currency" placeholder="Ingrese valor de la carga"
                                        value="{{ isset($routing->load_value) ? $routing->load_value : old('load_value') }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="volumen">Volumen </label>

                            {{-- Volumen --}}
                            <input type="text"
                                class="form-control CurrencyInput @error('volumen') is-invalid @enderror" id="volumen"
                                name="volumen" data-type="currency" placeholder="Ingrese el nro de paquetes.."
                                value="{{ isset($routing->volumen) ? $routing->volumen : old('volumen') }}">

                            @error('volumen')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                        <div class="col-6">
                            <label for="kilograms">Peso Total </label>

                            <input type="text"
                                class="form-control CurrencyInput @error('kilograms') is-invalid @enderror" id="kilograms"
                                name="kilograms" data-type="currency" placeholder="Ingrese el peso.."
                                value="{{ isset($routing->kilograms) ? $routing->kilograms : old('kilograms') }}">
                            @error('kilograms')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div id="container_measures" class="col-12 mt-3">

                            <div id="div-measures-fcl" class="row justify-content-center mb-2">

                                <div class="col-2">
                                    <input type="number" class="form-control" step="1" id="amount_package"
                                        name="amount_package" placeholder="Ingresa la cantidad">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control CurrencyInput" data-type="currency"
                                        id="width" name="width" placeholder="Ancho">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control CurrencyInput" data-type="currency"
                                        id="length" name="length" placeholder="Largo">
                                </div>
                                <div class="col-2">
                                    <input type="text" class="form-control CurrencyInput" data-type="currency"
                                        id="height" name="height" placeholder="Alto">
                                </div>
                                <div class="col-2">
                                    <select class="form-control" id="units_measurements" name="units_measurements">
                                        <option value="cm">cm</option>
                                        <option value="in">in</option>
                                        <option value="lbs">lbs</option>
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-indigo btn-sm" onclick="addMeasuresFCL()"><i
                                            class="fa fa-plus"></i>Agregar</button>
                                </div>

                            </div>

                            <table id="measures-fcl" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Ancho</th>
                                        <th>Largo</th>
                                        <th>Alto</th>
                                        <th>Unidad</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                            </table>
                            <input id="value_measures" type="hidden" name="value_measures" />
                            @error('value_measures')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="addedContainer(this)">Agregar</button>
                </div>

            </div>
        </div>
    </div>


@stop


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModal = new bootstrap.Modal(document.getElementById('modalSelectServices'), {
                backdrop: 'static', // Evita cierre al hacer clic fuera
                keyboard: false // Evita cierre con la tecla ESC
            });

            myModal.show();

            document.getElementById('btnGenerarServicios').addEventListener('click', function() {

                const selectedServices = Array.from(document.querySelectorAll(
                        'input[name="type_service[]"]:checked'))
                    .map(cb => cb.value);


                document.getElementById('type_service_checked').value = JSON.stringify(selectedServices);

                myModal.hide();
                updateFormFieldsVisibility();
            });


        })


        function selectAllServices() {
            const selectAllCheckbox = document.getElementById('servicio_integral');
            const serviceCheckboxes = document.querySelectorAll('input[name="type_service[]"]');

            serviceCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
                checkbox.disabled = selectAllCheckbox.checked;
            });

            updateFormFieldsVisibility();
        }


        document.querySelectorAll('input[name="type_service[]"]').forEach(cb => {
            cb.addEventListener('change', updateFormFieldsVisibility);
        });


        function updateFormFieldsVisibility() {
            // Obtén los checkboxes seleccionados
            const checked = Array.from(document.querySelectorAll('input[name="type_service[]"]:checked')).map(cb => cb.value
                .toLowerCase());

            // Lógica: si solo está seleccionado "transporte", ocultar campos
            const onlyTransport = checked.length === 1 && checked[0] === 'transporte';

            // Oculta o muestra los campos según la lógica
            document.querySelectorAll('.transporte-hide').forEach(el => {
                el.style.display = onlyTransport ? 'none' : '';
            });
        }
    </script>
@endpush

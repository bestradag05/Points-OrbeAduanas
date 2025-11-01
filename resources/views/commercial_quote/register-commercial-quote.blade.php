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




    <div id="modalSelectServices" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalSelectServices-title"
        aria-hidden="true">
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
                    <a class="btn btn-secondary" href="{{ route('quote.index') }}">Cancelar</a>
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
                                <x-adminlte-select2 name="id_incoterms" class="required" label="Incoterms" igroup-size="md"
                                    data-placeholder="Seleccione una opcion..."
                                    onchange="toggleExwPickupAddressConsolidated(this)">
                                    <option />
                                    @foreach ($incoterms as $incoter)
                                        <option value="{{ $incoter->id }}" data-code="{{ $incoter->code }}"
                                            {{ (isset($routing->id_incoterms) && $routing->id_incoterms == $incoter->id) || old('id_incoterms') == $incoter->id ? 'selected' : '' }}>
                                            {{ $incoter->code }}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                            <div id="pickup_address_at_origin_consolidated_container" class="col-12 my-4 d-none">
                                <p class="text-muted text-center mb-0">*Dirección de recojo para realizar el pickup en
                                    origen*</p>
                                <div class="form-group">
                                    <label for="pickup_address_at_origin_consolidated">Direccion de recojo</label>
                                    <input type="text"
                                        class="form-control @error('pickup_address_at_origin_consolidated') is-invalid @enderror "
                                        name="pickup_address_at_origin_consolidated"
                                        id="pickup_address_at_origin_consolidated"
                                        placeholder="Ingrese la dirección de recojo"
                                        value="{{ isset($routing->pickup_address_at_origin_consolidated) ? $routing->pickup_address_at_origin_consolidated : old('pickup_address_at_origin_consolidated') }}">

                                    @error('pickup_address_at_origin_consolidated')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="shipper_name">Proveedor:</label>
                                    <input id="shipper_name" class="form-control required" type="text"
                                        name="shipper_name" onchange="searchSupplier(this)">
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
                                    <input id="shipper_address" class="form-control" type="text"
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
                                        class="form-control required" type="text" name="nro_packages_consolidated">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="id_packaging_type_consolidated">Tipo Embalaje:</label>
                                    {{-- <input id="id_packaging_type_consolidated" class="form-control"
                                        type="text" name="id_packaging_type_consolidated"> --}}

                                    <x-adminlte-select2 id="id_packaging_type_consolidated"
                                        name="id_packaging_type_consolidated" class="required"
                                        data-placeholder="Seleccione una opcion...">
                                        <option />
                                        @foreach ($packingTypes as $packingType)
                                            <option value="{{ $packingType->id }}">
                                                {{ $packingType->name }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            </div>

                            <div id="contenedor_weight_consolidated" class="col-6">
                                <div class="form-group ">
                                    <label for="weight" class="col-form-label">Peso</label>

                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control CurrencyInput @error('weight') is-invalid @enderror"
                                            data-type="currency" id="weight" name="weight"
                                            value="{{ isset($routing->weight) ? $routing->weight : old('weight') }}">
                                        <div class="input-group-prepend">
                                            <select class="form-control" name="unit_of_weight" id="unit_of_weight">
                                                <option>kg</option>
                                                <option>ton</option>
                                            </select>
                                        </div>
                                    </div>


                                    @error('weight')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="contenedor_volumen_consolidated" class="col-6">
                                <div class="form-group">
                                    <label for="volumen_kgv" class="col-form-label">Volumen</label>

                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control CurrencyInput @error('volumen_kgv') is-invalid @enderror"
                                            data-type="currency" id="volumen_kgv" name="volumen_kgv"
                                            value="{{ isset($routing->volumen_kgv) ? $routing->volumen_kgv : old('volumen_kgv') }}">
                                        <div class="input-group-prepend">
                                            <select class="form-control" name="unit_of_volumen_kgv"
                                                id="unit_of_volumen_kgv">
                                                <option>m³</option>
                                                <option>kgv</option>
                                            </select>
                                        </div>
                                    </div>

                                    @error('volumen_kgv')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
                                <label for="nro_package_container">N° Paquetes / Bultos</label>
                                <input type="number" min="0" step="1"
                                    class="form-control @error('nro_package_container') is-invalid @enderror"
                                    id="nro_package_container" name="nro_package_container" data-required="true"
                                    placeholder="Ingrese el nro de paquetes.." oninput="validarInputNumber(this)"
                                    value="{{ isset($routing) ? $routing->nro_package_container : '' }}">
                                @error('nro_package_container')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="id_packaging_type">Tipo de embalaje</label>

                                <x-adminlte-select2 name="id_packaging_type" data-placeholder="Seleccione una opcion..."
                                    data-required="true">
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
                                        name="load_value" data-type="currency" data-required="true"
                                        placeholder="Ingrese valor de la carga"
                                        value="{{ isset($routing->load_value) ? $routing->load_value : old('load_value') }}">
                                </div>
                            </div>
                        </div>

                        <div id="contenedor_weight_fcl" class="col-6">
                            <div class="form-group ">
                                <label for="weight" class="col-form-label">Peso</label>

                                <div class="input-group">
                                    <input type="text"
                                        class="form-control CurrencyInput @error('weight') is-invalid @enderror"
                                        data-type="currency" id="weight" name="weight"
                                        value="{{ isset($routing->weight) ? $routing->weight : old('weight') }}">
                                    <div class="input-group-prepend">
                                        <select class="form-control" name="unit_of_weight" id="unit_of_weight">
                                            <option>kg</option>
                                            <option>ton</option>
                                        </select>
                                    </div>
                                </div>


                                @error('weight')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div id="contenedor_volumen_fcl" class="col-6">
                            <div class="form-group">
                                <label for="volumen_kgv" class="col-form-label">Volumen</label>

                                <div class="input-group">
                                    <input type="text"
                                        class="form-control CurrencyInput @error('volumen_kgv') is-invalid @enderror"
                                        data-type="currency" id="volumen_kgv" name="volumen_kgv"
                                        value="{{ isset($routing->volumen_kgv) ? $routing->volumen_kgv : old('volumen_kgv') }}">
                                    <div class="input-group-prepend">
                                        <select class="form-control" name="unit_of_volumen_kgv" id="unit_of_volumen_kgv">
                                            <option>m³</option>
                                            <option>kgv</option>
                                        </select>
                                    </div>
                                </div>

                                @error('volumen_kgv')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

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
                            <input id="value_measures_container" type="hidden" name="value_measures_container" />
                            @error('value_measures_container')
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

    <div class="col-md-12 mt-5">
        <div id="stepperCommercialQuote" class="bs-stepper">
            <div class="bs-stepper-header">
                <div class="step" data-target="#step0">
                    <button type="button" class="btn step-trigger">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">Información</span>
                    </button>
                </div>
                <div class="line"></div>
                <div class="step" data-target="#step1">
                    <button type="button" class="btn step-trigger">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">Detalle del producto</span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">

                <form id="formCommercialQuote" onsubmit="return false;" action="/commercial/quote" method="post"
                    enctype="multipart/form-data">

                    @csrf
                    @include ('commercial_quote.form-commercial-quote', ['formMode' => 'create'])


                </form>


            </div>
        </div>
    </div>

@stop


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const previousServices = document.getElementById('type_service_checked').value;


            if (!previousServices) {
                // Solo mostrar el modal si no hay servicios seleccionados previamente
                var myModal = new bootstrap.Modal(document.getElementById('modalSelectServices'), {
                    backdrop: 'static',
                    keyboard: false
                });
                myModal.show();
            } else {
                // Si hay servicios previos, restaurar la selección
                try {
                    const selectedServices = JSON.parse(previousServices);
                    selectedServices.forEach(service => {
                        const checkbox = document.querySelector(`input[value="${service}"]`);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                    // Actualizar visibilidad de campos
                    updateFormFieldsVisibility();
                } catch (e) {
                    console.error('Error parsing previous services:', e);
                }
            }


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

            //🔹 Ajustar los data-required de todos los .transporte-hide de una vez
            setSectionRequired('.transporte-hide', !onlyTransport);
        }

        function searchSupplier(e) {

            let name_businessname_supplier = e.value;
            let formFillData = $('#form-consolidated');


            // Hacer una llamada AJAX para obtener los datos del cliente desde el servidor
            $.ajax({
                url: `/suppliers/${name_businessname_supplier}`,
                method: 'GET',
                success: function(response) {

                    if (response.success && response.supplier) {
                        // Si el cliente existe, llenamos los campos
                        formFillData.find('#shipper_contact_email').val(response.supplier.address).prop(
                            'readonly',
                            true);
                        formFillData.find('#shipper_contact').val(response.supplier.contact_name).prop(
                            'readonly',
                            true);
                        formFillData.find('#shipper_contact_phone').val(response.supplier.contact_number)
                            .prop(
                                'readonly', true);
                        formFillData.find('#shipper_contact_email').val(response.supplier.contact_email).prop(
                            'readonly', true);
                        formFillData.find('#shipper_address').val(response.supplier.address)
                            .prop(
                                'readonly', true);;
                    } else {
                        // Si el cliente no existe, limpiar los campos
                        formFillData.find('#shipper_contact_email').val('').prop('readonly', false);
                        formFillData.find('#shipper_contact').val('').prop('readonly', false);
                        formFillData.find('#shipper_contact_phone').val('').prop('readonly', false);
                        formFillData.find('#shipper_contact_email').val('').prop('readonly', false);
                        formFillData.find('#shipper_address').val('').prop('readonly', false);

                        // También podrías mostrar un mensaje si no se encuentra el cliente
                        toastr.info(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al buscar cliente:', error);
                }
            });

        }
    </script>

    {{-- Stepper --}}

    <script>
        var stepper1Node = document.querySelector('#stepperCommercialQuote')
        var stepperCommercialQuote = new Stepper(document.querySelector('#stepperCommercialQuote'));



        function validateStep(stepSelector) {
            let valid = true;
            const stepFields = document.querySelectorAll(
                `${stepSelector} input, ${stepSelector} select, ${stepSelector} textarea`);
            stepFields.forEach(function(field) {
                if (field.dataset.required === 'true') {
                    if (field.type === 'radio') {
                        const radioGroup = document.querySelectorAll(`input[name="${field.name}"]`);
                        const isChecked = Array.from(radioGroup).some(radio => radio.checked);
                        if (!isChecked) {
                            radioGroup.forEach(radio => radio.classList.add('is-invalid'));
                            valid = false;
                        } else {
                            radioGroup.forEach(radio => radio.classList.remove('is-invalid'));
                        }
                    } else if (field.value.trim() === '') {
                        field.classList.add('is-invalid');
                        valid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            return valid;
        }


        stepper1Node.addEventListener('show.bs-stepper', function(event) {
            const currentStep = event.detail.from; // Paso actual
            let valid = false;

            // Validar el paso actual antes de permitir avanzar
            if (currentStep === 0) {
                valid = validateStep('#step0');
            } else if (currentStep === 1) {
                valid = validateStep('#step1');
            }

            // Si la validación falla, evitar el avance
            if (!valid) {
                event.preventDefault();

                // Enfocar el primer campo inválido
                const invalidFields = document.querySelectorAll('.is-invalid');
                if (invalidFields.length > 0) {
                    invalidFields[0].focus(); // Enfocar el primer campo inválido
                }
            }

        });



        function isConsolidatedSelected() {
            return document.querySelector('input[name="is_consolidated"]:checked')?.value === '1';
        }


        function hasConsolidatedItems() {
            const hidden = document.getElementById('shippers_consolidated')?.value || '[]';
            try {
                const arr = JSON.parse(hidden);
                return Array.isArray(arr) && arr.length > 0;
            } catch {
                return false;
            }
        }

        function hasConsolidatedItemsFCL() {
            const hidden = document.getElementById('shippers_fcl_consolidated')?.value || '[]';
            try {
                const arr = JSON.parse(hidden);
                return Array.isArray(arr) && arr.length > 0;
            } catch {
                return false;
            }
        }

        function isMaritima() {
            const idTypeShipmentSelect = document.querySelector('select[name="id_type_shipment"]');
            var typeShipments = @json($type_shipments);
            var typeShipmentCurrent = typeShipments.find(typeShipment => typeShipment.id === parseInt(idTypeShipmentSelect
                .value));


            return typeShipmentCurrent.name === "Marítima"
        }

        function isFCLSelected() {
            return document.querySelector('input[name="lcl_fcl"]:checked')?.value === 'FCL';
        }


        function hasFCLItems() {
            const hidden = document.getElementById('data_containers')?.value || '[]';
            try {
                const arr = JSON.parse(hidden);
                return Array.isArray(arr) && arr.length > 0;
            } catch {
                return false;
            }
        }

        function hasFCLItemsConsolidated() {
            const hidden = document.getElementById('data_containers_consolidated')?.value || '[]';
            try {
                const arr = JSON.parse(hidden);
                return Array.isArray(arr) && arr.length > 0;
            } catch {
                return false;
            }
        }

        function submitForm() {
            const form = document.getElementById('formCommercialQuote');
            let valid = true;


            const step1 = validateStep('#step0');
            const step2 = validateStep('#step1');

            valid = step1 && step2;



            if (valid) {

                if (isConsolidatedSelected()) {

                    if (isMaritima() && isFCLSelected()) {

                        if (!hasConsolidatedItemsFCL()) {
                            toastr.error("Por favor, agregue al menos un shipper consolidado.");
                            return;
                        }

                        if (!hasFCLItemsConsolidated()) {
                            toastr.error("Por favor, agregue al menos un contenedor.");
                            return;
                        }

                    } else {

                        if (!hasConsolidatedItems()) {
                            toastr.error("Por favor, agregue al menos un shipper consolidado.");
                            return;
                        }
                    }

                } else {
                    if (isFCLSelected()) {
                        if (!hasFCLItems()) {
                            toastr.error("Por favor, agregue al menos un contenedor.");
                            return;
                        }

                    } else {

                        const valueMeasures = document.getElementById('value_measures').value.trim();
                        const volumen = $('#contenedor_volumen #volumen_kgv').val().trim();
                        const weight = $('#contenedor_weight #weight').val().trim();

                        if (!((volumen && weight) || valueMeasures)) {
                            toastr.error("Por favor, complete al menos uno de los siguientes: Volumen y Peso, o Medidas.");
                            return;
                        }

                    }
                }

                form.submit();

            } else {
                const invalidFields = document.querySelectorAll('.is-invalid');
                if (invalidFields.length > 0) {
                    invalidFields[0].focus();
                }
            }
        }


        function validarInputNumber(input) {
            if (input.value < 0) {
                input.value = '';
            }
        }
    </script>
@endpush

        {{-- Aduanas --}}
        <div class="modal fade" id="modalAduanas" tabindex="-1" aria-labelledby="modalAduanasLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAduanasLabel">Aduana</h5>
                        <button type="button" class="close" onclick="closeToModal('modalAduanas')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/customs" method="POST">
                            @csrf

                            <input type="hidden" name="nro_quote_commercial"
                                value="{{ $comercialQuote->nro_quote_commercial }}">
                            <input type="hidden" name="typeService" id="typeService">
                            <input type="hidden" name="value_utility" id="value_utility">


                            <div class="col-12 px-0">
                                <div class="accordion" id="accordionImpuestos">
                                    <div class="card" style="background: #dbdbe175">
                                        <div class="card-header m-0 p-1" id="headingImpuestos">
                                            <h6
                                                class=" pb-0 mb-0  pl-2 d-flex justify-content-between align-items-center">
                                                <span class="text-uppercase">
                                                    Detalle de impuestos
                                                </span>
                                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                                    data-target="#collapseImpuestos" aria-expanded="true"
                                                    aria-controls="collapseImpuestos">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </h6>
                                        </div>

                                        <div id="collapseImpuestos" class="collapse show"
                                            aria-labelledby="headingImpuestos" data-parent="#accordionImpuestos">
                                            <div class="card-body">
                                                <!-- Primer campo: Valor FOB -->
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="load_value">Valor FOB</label>
                                                            <div class="input-group">
                                                                <input type="text"
                                                                    class="form-control  @error('load_value') is-invalid @enderror "
                                                                    {{ isset($comercialQuote->load_value) ? 'readonly' : '' }}
                                                                    name="load_value"
                                                                    placeholder="Ingrese valor de la carga"
                                                                    value="{{ isset($comercialQuote->load_value) ? number_format($comercialQuote->load_value, 2) : old('load_value') }}">
                                                            </div>
                                                            @error('load_value')
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Segundo campo: Valor CIF -->
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="cif_value">Valor CIF</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control CurrencyInput"
                                                                    name="cif_value"
                                                                    placeholder="Ingrese valor de la carga"
                                                                    data-type="currency"
                                                                    value="{{ isset($comercialQuote->cif_value) ? number_format($comercialQuote->cif_value, 2) : old('cif_value') }}">
                                                            </div>
                                                            @error('cif_value')
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- Tercer campo: Impuestos de Aduanas -->
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="customs_taxes">Impuestos de Aduanas</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control CurrencyInput"
                                                                    name="customs_taxes"
                                                                    placeholder="Ingrese valor de la carga"
                                                                    data-type="currency"
                                                                    value="{{ isset($customs_taxes->customs_taxes) ? $customs_taxes->customs_taxes : '' }}">
                                                            </div>
                                                            @error('customs_taxes')
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Cuarto campo: Percepción Aduanas -->
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label for="customs_perception">Percepción Aduanas</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control CurrencyInput"
                                                                    name="customs_perception"
                                                                    placeholder="Ingrese valor de la carga"
                                                                    data-type="currency"
                                                                    value="{{ isset($customs_taxes->customs_perception) ? $customs_taxes->customs_perception : old('customs_perception') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-12">

                                    <x-adminlte-select2 name="modality" id="modality" label="Modalidad"
                                        data-placeholder="Seleccione un concepto...">
                                        <option />
                                        @foreach ($modalitys as $modality)
                                            <option value="{{ $modality->id }}">{{ $modality->name }}</option>
                                        @endforeach
                                    </x-adminlte-select2>

                                </div>
                            </div>

                            <hr>
                            <div id="formConceptsAduanas" class="formConcepts row">
                                <div class="col-4">

                                    <label for="concept">Conceptos</label>
                                    <button class="btn btn-indigo btn-xs" type="button"
                                        onclick="openModalConcept('modalAduanas', 'modalAddConcept')">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    :
                                    <x-adminlte-select2 name="concept" id="concept_aduana"
                                        data-placeholder="Seleccione un concepto...">
                                        <option />
                                        @foreach ($concepts as $concept)
                                            @if ($concept->typeService->name == 'Aduanas' && $comercialQuote->type_shipment->id == $concept->id_type_shipment)
                                                @if ($concept->name != 'AGENCIAMIENTO DE ADUANAS' && $concept->name != 'GASTOS OPERATIVOS')
                                                    <option value="{{ $concept->id }}">{{ $concept->name }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </x-adminlte-select2>

                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="value_concept">Valor del concepto</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-bold">
                                                    $
                                                </span>
                                            </div>
                                            <input type="text" class="form-control CurrencyInput "
                                                name="value_concept" data-type="currency"
                                                placeholder="Ingrese valor del concepto" value="">
                                        </div>
                                    </div>

                                </div>

                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="value_concept">Valor venta</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-bold">
                                                    $
                                                </span>
                                            </div>
                                            <input type="text" class="form-control CurrencyInput "
                                                name="value_sale" data-type="currency"
                                                placeholder="Ingrese valor venta" value="0">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 d-flex justify-content-center align-items-center pt-3 mb-2">
                                    <button class="btn btn-indigo" type="button" id="btnAddConcept"
                                        onclick="addConceptCustom(this)">
                                        Agregar
                                    </button>

                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Concepto</th>
                                            <th>Valor del concepto</th>
                                            <th>Valor venta</th>
                                            <th>x</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyAduanas">


                                    </tbody>
                                </table>

                                <div class="row w-100 mt-2">

                                    <div class="col-6 row justify-content-center align-items-center">

                                        <div class="row">
                                            <label for="profit"
                                                class="col-sm-6 col-form-label text-success">Ganancia $$</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="profit" name="profit" value="0.00" @readonly(true)>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-6 row flex-column">
                                        <div class="row">
                                            <label for="custom_insurance" class="col-sm-6 col-form-label ">Total a
                                                cobrar:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    name="custom_insurance" id="custom_insurance" value="0.00"
                                                    @readonly(true)>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="sub_total_value_sale" class="col-sm-6 col-form-label">Total
                                                venta / Sub Total:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="sub_total_value_sale" name="sub_total_value_sale"
                                                    value="0.00" @readonly(true)>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="igv" class="col-sm-6 col-form-label">IGV:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="igv" name="igv" value="0.00" @readonly(true)>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="value_sale" class="col-sm-6 col-form-label">Total:</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control form-control-sm"
                                                    id="value_sale" name="value_sale" value="0.00"
                                                    @readonly(true)>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-indigo" id="btnGuardarCustom" type="button"
                                    onclick="submitCustomsForm(event)">Guardar</button>
                                <button class="btn btn-secondary" onclick="closeToModal('modalAduanas')">Cerrar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div id="modalAddConcept" class="modal fade" tabindex="-1" role="dialog"
            aria-labelledby="modalAddConceptTitle" aria-hidden="true">
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
                                        id="name" name="name" placeholder="Ingrese el nombre"
                                        value="">
                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-select2 name="id_type_shipment" label="Tipo de embarque"
                                        igroup-size="md" readonly="true" data-placeholder="Selecciona una opcion...">
                                        <option />
                                        @foreach ($typeShipments as $typeShipment)
                                            <option value="{{ $typeShipment->id }}"
                                                {{ $comercialQuote->type_shipment->name === $typeShipment->name ? 'selected' : '' }}>
                                                {{ $typeShipment->name }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>

                                </div>
                                <div class="col-md-6">
                                    <x-adminlte-select2 name="id_type_service" label="Tipo de servicio"
                                        igroup-size="md" readonly="true" data-placeholder="Selecciona una opcion...">
                                        <option />
                                        @foreach ($type_services as $typeService)
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
                                onclick="closeToModalAddConcept('modalAduanas', 'modalAddConcept')">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="saveConceptToDatabase()">Guardar
                                Concepto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        @push('scripts')
            <script>
                let conceptsCustomArray = [];
                let countCustomConcepts = 0;
                let value_insurance_custom = 0;
                let valuea_added_insurance_custom = 0;
                let concepts = @json($concepts);
                let comercialQuote = @json($comercialQuote);
                let type_services = @json($type_services);
                let filteredConcepts = @json($filteredConcepts);
                let customService = type_services.filter(type_service => type_service.name === 'Aduanas')[0];
                let totalUtilityCustom = null;
                let TotalCustomsConcepts = 0;
                let TotalCustomNetAmount = 0;

                $(document).ready(function() {

                    filteredConcepts.forEach(concept => {
                        conceptsCustomArray.push({
                            'id': concept.id,
                            'name': concept.name,
                            'value': concept.value.toFixed(2),
                            'value_sale': 0,
                        });

                        totalUtilityCustom += concept.value;
                    });

                    //Agregamos la utilidad dejada para orbe, para enviarlo al formulario:

                    $('#value_utility').val(totalUtilityCustom);

                    updateTableCustom(conceptsCustomArray);


                });



                $('.modalAduanas').on('hide.bs.modal', function(e) {
                    conceptsCustomArray = {};
                    TotalCustomsConcepts = 0;
                    TotalCustomNetAmount = 0;
                    value_insurance_custom = 0;
                    valuea_value_sale_insurance_custom = 0;
                    countConcepts = 0;

                    updateTable(conceptsArray, e.target.id);

                    $(`#${e.target.id}`).find('form')[0].reset();
                    $('.contentInsurance').addClass('d-none').removeClass('d-flex');

                });

                function enableCustomsInsurance(checkbox) {
                    const contenedorInsurance = $(`#content_${checkbox.id}`);
                    if (checkbox.checked) {
                        contenedorInsurance.addClass('d-flex').removeClass('d-none');
                        contenedorInsurance.find("input").removeClass('d-none');
                        contenedorInsurance.find('select').removeClass('d-none');

                    } else {
                        contenedorInsurance.addClass('d-none').removeClass('d-flex');
                        contenedorInsurance.find("input").val('').addClass('d-none').removeClass('is-invalid');
                        contenedorInsurance.find('select').val('').addClass('d-none').removeClass('is-invalid');

                        value_insurance_custom = 0;
                        valuea_added_insurance_custom = 0;

                        calcCustomTotal(TotalCustomNetAmount, TotalCustomsConcepts, value_insurance_custom,
                            valuea_added_insurance_custom);

                    }
                }


                function selectInsurance(select) {

                    let typesInsurance = @json($type_insurace);
                    let fobValue = parseFloat(@json($comercialQuote->load_value));
                    let typeShipment = @json($comercialQuote->type_shipment);
                    let selectValue = parseInt(select.value);

                    let insurance = typesInsurance.find(type => type.id === selectValue);
                    let rate = insurance.insurance_rate.find(rate => rate.shipment_type_description === typeShipment.description);

                    let minValue = parseFloat(rate.min_value);

                    if (!rate) {
                        Swal.fire({
                            title: "No existe tarifa registrada para calcular el seguro",
                            text: "Por favor comunicate con el administrador, para que pueda registrar las tarifas de los seguros.",
                            icon: "info"
                        });
                        return;
                    }

                    let total = 0;

                    if (fobValue <= minValue) {
                        total = parseFloat(rate.fixed_cost);
                    } else {
                        total = (fobValue * (rate.percentage / 100));
                    }


                    $('#insurance-detail-label').text(insurance.name);
                    $('#value_insurance').val(total.toFixed(2));

                    value_insurance_custom = total;


                    calcCustomTotal(TotalCustomNetAmount, TotalCustomsConcepts, value_insurance_custom,
                        valuea_added_insurance_custom);

                }


                function updateInsuranceTotal(element) {

                    if (element.value === '') {
                        value_insurance_custom = 0;
                    } else {
                        value_insurance_custom = parseFloat(element.value.replace(/,/g, ''));
                    }

                    calcCustomTotal(TotalCustomNetAmount, TotalCustomsConcepts, value_insurance_custom,
                        valuea_added_insurance_custom);
                }


                function updateInsuranceSalesValue(element) {


                    if (element.value === '') {
                        valuea_added_insurance_custom = 0;
                    } else {
                        valuea_added_insurance_custom = parseFloat(element.value.replace(/,/g, ''));
                    }


                    //Cada que actualicemos el insurance_add borramos los puntos para poder volver a generar un maximo.
                    $(`#${container.id} #insurance_points`).val("");

                    calcCustomTotal(TotalCustomNetAmount, TotalCustomsConcepts, value_insurance_custom,
                        valuea_added_insurance_custom);
                }


                function addConceptCustom(buton) {

                    let divConcepts = containerResult.find('.formConcepts');
                    const inputs = divConcepts.find('input:not(.points), select');

                    // Busca todos los campos de entrada dentro del formulario
                    inputs.each(function(index, input) {
                        // Verifica si el campo de entrada está vacío
                        if ($(this).val() === '') {
                            // Si está vacío, agrega la clase 'is-invalid'
                            $(this).addClass('is-invalid');
                        } else {
                            // Si no está vacío, remueve la clase 'is-invalid' (en caso de que esté presente)
                            $(this).removeClass('is-invalid');

                        }
                    });
                    // Verifica si hay algún campo con la clase 'is-invalid'
                    var camposInvalidos = divConcepts.find('.is-invalid').length;

                    if (camposInvalidos === 0) {
                        // Si no hay campos inválidos, envía el formulario

                        const index = conceptsCustomArray.findIndex(item => item.id === parseInt(inputs[0].value));

                        if (index !== -1) {

                            conceptsCustomArray[index] = {
                                'id': parseInt(inputs[0].value),
                                'name': inputs[0].options[inputs[0].selectedIndex].text,
                                'value': formatValue(inputs[1].value),
                                'value_sale': formatValue(inputs[2].value),
                            };

                        } else {

                            conceptsCustomArray.push({
                                'id': parseInt(inputs[0].value),
                                'name': inputs[0].options[inputs[0].selectedIndex].text,
                                'value': formatValue(inputs[1].value),
                                'value_sale': formatValue(inputs[2].value),
                            });
                        }

                        updateTableCustom(conceptsCustomArray);

                        inputs[0].value = '';
                        inputs[1].value = '';
                        inputs[2].value = '';
                    }
                };

                function updateTableCustom(conceptsCustomArray) {

                    let tbodyRouting = $(`#formConceptsAduanas`).find('tbody')[0];

                    if (tbodyRouting) {

                        tbodyRouting.innerHTML = '';
                    }
                    TotalCustomsConcepts = 0;
                    TotalCustomNetAmount = 0;

                    let contador = 0;

                    for (let clave in conceptsCustomArray) {

                        let item = conceptsCustomArray[clave];

                        if (conceptsCustomArray.hasOwnProperty(clave)) {
                            contador++; // Incrementar el contador en cada iteración
                            // Crear una nueva fila
                            let fila = tbodyRouting.insertRow();

                            // Insertar el número de iteración en la primera celda de la fila
                            let celdaNumero = fila.insertCell(0);
                            celdaNumero.textContent = contador;

                            // Insertar la clave en la segunda celda de la fila
                            let celdaClave = fila.insertCell(1);
                            celdaClave.textContent = item.name;

                            // Insertar el valor en la tercera celda de la fila
                            let celdaValor = fila.insertCell(2);
                            celdaValor.textContent = item.value;


                            // Insertar el valor en la cuarta celda de la fila
                            let celdaValueSale = fila.insertCell(3);
                            if (filteredConcepts.some(concept => concept.name === item.name)) {
                                // Si customAgency existe, muestra un input editable
                                let inputValueSale = document.createElement('input');
                                inputValueSale.type = 'number';
                                inputValueSale.value = item.value_sale;
                                inputValueSale.min = 0;
                                inputValueSale.classList.add('form-control');
                                celdaValueSale.appendChild(inputValueSale);

                                inputValueSale.addEventListener('input', (e) => {
                                    let newValue = parseFloat(e.target.value) || 0;

                                    // Actualiza el valor en `conceptsCustomArray`
                                    conceptsCustomArray[clave].value_sale = newValue;

                                    TotalCustomsConcepts = 0; // Resetear total antes de recalcular
                                    for (let item of Object.values(conceptsCustomArray)) {
                                        TotalCustomsConcepts += parseFloat(item.value_sale); // Sumar los nuevos valores
                                    }

                                    calcCustomTotal(TotalCustomNetAmount, TotalCustomsConcepts, value_insurance_custom,
                                        valuea_added_insurance_custom);


                                });
                            } else {
                                celdaValueSale.textContent = item.value_sale;
                            }



                            if (!filteredConcepts.some(concept => concept.name === item.name)) {

                                // Insertar un botón para eliminar la fila en la cuarta celda de la fila
                                let celdaEliminar = fila.insertCell(4);
                                let botonEliminar = document.createElement('a');
                                botonEliminar.href = '#';
                                botonEliminar.innerHTML = '<p class="text-danger">X</p>';
                                botonEliminar.addEventListener('click', function() {

                                    // Eliminar la fila correspondiente al hacer clic en el botón
                                    let fila = this.parentNode.parentNode;
                                    let indice = fila.rowIndex -
                                        1; // Restar 1 porque el índice de las filas en tbody comienza en 0
                                    conceptsCustomArray.splice(indice, 1);
                                    updateTableCustom(conceptsCustomArray);
                                });
                                celdaEliminar.appendChild(botonEliminar);

                            }

                            TotalCustomNetAmount += parseFloat(item.value);
                            TotalCustomsConcepts += parseFloat(item.value_sale);
                        }
                    }

                    calcCustomTotal(TotalCustomNetAmount, TotalCustomsConcepts, value_insurance_custom,
                        valuea_added_insurance_custom);
                    $('#TotalCustomNetAmount').val(TotalCustomNetAmount);

                }


                function calcCustomTotal(TotalCustomNetAmount, TotalCustomsConcepts, value_insurance_custom,
                    valuea_added_insurance_custom) {

                    let totalReceivable = TotalCustomNetAmount;
                    let totalSale = TotalCustomsConcepts + valuea_added_insurance_custom;

                    let inputTotal = $('#sub_total_value_sale');
                    let btnGuardar = $('#btnGuardarCustom');


                    let insurance = value_insurance_custom;
                    let customInsuranceReceivable = insurance + totalReceivable;


                    if (totalSale >= customInsuranceReceivable && customInsuranceReceivable > 0) {
                        btnGuardar.prop('disabled', false);
                    } else {
                        btnGuardar.prop('disabled', true);
                        btnGuardar.removeClass('btn-default');
                    }

                    //Sacamos el IGV

                    let igv = totalSale * 0.18;
                    let totalValueSale = totalSale + igv;


                    let ganancia = totalSale - customInsuranceReceivable;
                    if (ganancia < 0) ganancia = 0;

                    inputTotal.val(totalSale.toFixed(2));
                    $('#igv').val(igv.toFixed(2));
                    $('#value_sale').val(totalValueSale.toFixed(2));
                    $('#profit').val(ganancia.toFixed(2));

                    /*  $('#cost_receivable').val(totalReceivable.toFixed(2)); */

                    /*  $('#insurance_value').val((insurance).toFixed(2)); */
                    $('#custom_insurance').val((customInsuranceReceivable).toFixed(2));

                }


                function formatValue(value) {
                    // Verifica si el valor es una cadena (string)
                    if (typeof value === 'string') {
                        return value.replace(/,/g, '');
                    }
                    // Si es un número, simplemente lo retorna tal cual
                    return value;
                }

                const preventeDefaultAction = (e) => {
                    e.preventDefault();
                }


                function submitCustomsForm(e) {
                    e.preventDefault();
                    let form = $(`#${container.id}`).find('form');
                    const inputs = form.find('input, select').not(
                        '.formConcepts  input, .formConcepts select, input.d-none, #collapseImpuestos input');

                    inputs.each(function(index, input) {

                        if (!$(this).hasClass('d-none')) {

                            // Verifica si el campo de entrada está vacío
                            if ($(this).val() === '') {
                                // Si está vacío, agrega la clase 'is-invalid'
                                $(this).addClass('is-invalid');

                            } else {
                                // Si no está vacío, remueve la clase 'is-invalid' (en caso de que esté presente)
                                $(this).removeClass('is-invalid');

                            }
                        }

                    });

                    var camposInvalidos = form.find('.is-invalid').length;


                    if (camposInvalidos == 0) {

                        let conceptops = JSON.stringify(conceptsCustomArray);

                        form.append(`<input type="hidden" name="concepts" value='${conceptops}' />`);

                        form[0].submit();
                        
                    }
                }


                function submitFormInsurance() {

                    let form = $('#form_insurance');
                    const inputs = form.find('input, select').not('');


                    inputs.each(function(index, input) {

                        if (!$(this).hasClass('d-none')) {

                            // Verifica si el campo de entrada está vacío
                            if ($(this).val() === '') {
                                // Si está vacío, agrega la clase 'is-invalid'
                                $(this).addClass('is-invalid');

                            } else {
                                // Si no está vacío, remueve la clase 'is-invalid' (en caso de que esté presente)
                                $(this).removeClass('is-invalid');

                            }
                        }

                    });


                    var camposInvalidos = form.find('.is-invalid').length;

                    if (camposInvalidos == 0) {

                        let conceptops = JSON.stringify(conceptsCustomArray);

                        form.append(`<input type="hidden" name="concepts" value='${conceptops}' />`);
                        form[0].submit();
                    }
                }
            </script>
        @endpush

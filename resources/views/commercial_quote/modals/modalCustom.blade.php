        {{-- Aduanas --}}
        <x-adminlte-modal id="modalAduanas" class="modal" title="Aduana" size='lg' scrollable>
            <form action="/customs" method="POST">
                @csrf

                <input type="hidden" name="nro_quote_commercial" value="{{ $comercialQuote->nro_quote_commercial }}">
                <input type="hidden" name="typeService" id="typeService">

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

                    <div class="col-6">

                        <div class="form-group">
                            <label for="cif_value">Valor FOB</label>

                            <div class="input-group">

                                <input type="text" class="form-control  @error('cif_value') is-invalid @enderror "
                                    {{ isset($comercialQuote->load_value) ? 'readonly' : '' }} name="load_value"
                                    placeholder="Ingrese valor de la carga"
                                    value="{{ isset($comercialQuote->load_value) ?  number_format($comercialQuote->load_value, 2) : old('load_value') }}">
                            </div>
                            @error('load_value')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="form-group">
                            <label for="cif_value">Valor CIF</label>

                            <div class="input-group">

                                <input type="text" class="form-control "
                                    {{ isset($comercialQuote->cif_value) ? 'readonly' : '' }} name="cif_value"
                                    placeholder="Ingrese valor de la carga"
                                    value="{{ isset($comercialQuote->cif_value) ? number_format($comercialQuote->cif_value, 2) : old('cif_value') }}">
                            </div>
                            @error('cif_value')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="form-group">
                            <label for="customs_taxes">Impuestos de Aduanas</label>

                            <div class="input-group">

                                <input type="text" class="form-control"
                                    {{ isset($customs_taxes->customs_taxes) ? 'readonly' : '' }} name="customs_taxes"
                                    placeholder="Ingrese valor de la carga"
                                    value="{{ isset($customs_taxes->customs_taxes) ? $customs_taxes->customs_taxes : '' }}">
                            </div>
                            @error('customs_taxes')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                    </div>

                    <div class="col-6">

                        <div class="form-group">
                            <label for="customs_perception">Percepción Aduanas</label>

                            <div class="input-group">

                                <input type="text" class="form-control"
                                    {{ isset($customs_taxes->customs_perception) ? 'readonly' : '' }}
                                    name="customs_perception" placeholder="Ingrese valor de la carga"
                                    value="{{ isset($customs_taxes->customs_perception) ? $customs_taxes->customs_perception : old('customs_perception') }}">
                            </div>

                        </div>

                    </div>



                </div>


                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="state_insurance" class="custom-control-input" id="seguroCustom"
                            onchange="enableCustomsInsurance(this)">
                        <label class="custom-control-label" for="seguroCustom">Agregar Seguro</label>
                    </div>
                </div>
                <hr>
                <div class="row d-none justify-content-center" id="content_seguroCustom">
                    <div class="col-3">
                        <label for="type_insurance">Tipo de seguro</label>
                        <select name="type_insurance" class="d-none form-control" label="Tipo de seguro"
                            igroup-size="md" data-placeholder="Seleccione una opcion...">
                            <option />
                            @foreach ($type_insurace as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="load_value">Valor del seguro</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold">
                                        $
                                    </span>
                                </div>
                                <input type="text" class="form-control CurrencyInput d-none " name="value_insurance"
                                    data-type="currency" placeholder="Ingrese valor de la carga"
                                    onchange="updateCustomsInsuranceTotal(this)">
                            </div>

                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="load_value">Valor ha agregar</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold">
                                        $
                                    </span>
                                </div>
                                <input type="text" class="form-control CurrencyInput d-none" id="insurance_added"
                                    name="insurance_added" data-type="currency" value="0"
                                    placeholder="Ingrese valor de la carga"
                                    onchange="updateCustomsInsuranceAddedTotal(this)">
                            </div>

                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="load_value">Puntos</label>

                            <div class="input-group">
                                <input type="number" class="form-control d-none" id="insurance_points"
                                    name="insurance_points" min="0" onkeydown="preventeDefaultAction(event)"
                                    oninput="addCustomsPointsInsurance(this)">
                            </div>

                        </div>
                    </div>
                </div>

                <hr>
                <div id="formConceptsAduanas" class="formConcepts row">
                    <div class="col-4">

                        <x-adminlte-select2 name="concept" id="concept_aduana" label="Conceptos"
                            data-placeholder="Seleccione un concepto...">
                            <option />
                            @foreach ($concepts as $concept)
                                @if ($concept->typeService->name == 'Aduanas' && $comercialQuote->type_shipment->id == $concept->id_type_shipment)
                                    @if ($concept->name != 'AGENCIAMIENTO DE ADUANAS')
                                        <option value="{{ $concept->id }}">{{ $concept->name }}</option>
                                    @endif
                                @endif
                            @endforeach
                        </x-adminlte-select2>

                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="value_concept">Valor del neto del concepto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold">
                                        $
                                    </span>
                                </div>
                                <input type="text" class="form-control CurrencyInput " name="value_concept"
                                    data-type="currency" placeholder="Ingrese valor del concepto" value="">
                            </div>
                        </div>

                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="value_concept">Valor ha agregar</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-bold">
                                        $
                                    </span>
                                </div>
                                <input type="text" class="form-control CurrencyInput " name="value_added"
                                    data-type="currency" placeholder="Ingrese valor agregado" value="0">
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
                                <th>Valor agregado</th>
                                <th>Puntos</th>
                                <th>x</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyAduanas">


                        </tbody>
                    </table>

                    <div class="row w-100 justify-content-end">

                        <div class="col-4 row">
                            <label for="total" class="col-sm-4 col-form-label">Total:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="total" name="totalCustom"
                                    value="0.00" @readonly(true)>
                            </div>
                        </div>

                    </div>


                </div>

                <x-slot name="footerSlot">
                    <x-adminlte-button class="btn btn-indigo" id="btnSubmit" type="submit"
                        onclick="submitCustomsForm(this)" label="Guardar" />
                    <x-adminlte-button theme="secondary" label="Cerrar" data-dismiss="modal" />
                </x-slot>

            </form>
        </x-adminlte-modal>

        @push('scripts')
            <script>
                let conceptsCustomArray = [];
                let countCustomConcepts = 0;
                let value_insurance_custom = 0;
                let valuea_added_insurance_custom = 0;
                let concepts = @json($concepts);
                let comercialQuote = @json($comercialQuote);
                let type_services = @json($type_services);
                let customAgencyValue = @json($customs_agency);
                let customService = type_services.filter(type_service => type_service.name === 'Aduanas')[0];
                let conceptCustomAgency = null;


             
                concepts.forEach(concept => {

                    if (concept.name === 'AGENCIAMIENTO DE ADUANAS' && comercialQuote.type_shipment.id === concept
                        .id_type_shipment && concept.id_type_service === customService.id) {
                        //Obtenemos el agenciamiento de aduanas
                        conceptCustomAgency = concept;
                    }

                });

                /* console.log(formatValue(customAgencyValue)); */
                conceptsCustomArray.push({
                    'id': conceptCustomAgency.id,
                    'name': conceptCustomAgency.name,
                    'value': formatValue(customAgencyValue),
                    'added': 0,
                });


                updateTableCustom(conceptsCustomArray);


                $('.modalAduanas').on('hide.bs.modal', function(e) {
                    conceptsCustomArray = {};
                    TotalCustomsConcepts = 0;
                    total = 0;
                    value_insurance_custom = 0;
                    valuea_added_insurance_custom = 0;
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

                        calcCustomTotal(TotalCustomsConcepts, value_insurance_custom, valuea_added_insurance_custom);

                    }
                }


                function updateCustomsInsuranceTotal(element) {

                    if (element.value === '') {
                        value_insurance_custom = 0;
                    } else {
                        value_insurance_custom = parseFloat(element.value.replace(/,/g, ''));
                    }

                    calcCustomTotal(TotalCustomsConcepts, value_insurance_custom, valuea_added_insurance_custom);
                }


                function updateCustomsInsuranceAddedTotal(element) {


                    if (element.value === '') {
                        valuea_added_insurance_custom = 0;
                    } else {
                        valuea_added_insurance_custom = parseFloat(element.value.replace(/,/g, ''));
                    }


                    //Cada que actualicemos el insurance_add borramos los puntos para poder volver a generar un maximo.
                    $(`#${container.id} #insurance_points`).val("");

                    calcCustomTotal(TotalCustomsConcepts, value_insurance_custom, valuea_added_insurance_custom);
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
                                'added': formatValue(inputs[2].value),
                            };

                        } else {

                            conceptsCustomArray.push({
                                'id': parseInt(inputs[0].value),
                                'name': inputs[0].options[inputs[0].selectedIndex].text,
                                'value': formatValue(inputs[1].value),
                                'added': formatValue(inputs[2].value),
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

                            let celdaAdded = fila.insertCell(3);
                            if (item.name === conceptCustomAgency.name) {
                                // Si customAgency existe, muestra un input editable
                                let inputAdded = document.createElement('input');
                                inputAdded.type = 'number';
                                inputAdded.value = item.added;
                                inputAdded.min = 0;
                                inputAdded.classList.add('form-control');
                                celdaAdded.appendChild(inputAdded);

                                inputAdded.addEventListener('input', (e) => {
                                    let newValue = parseFloat(e.target.value) || 0;

                                    // Actualiza el valor en `conceptsCustomArray`
                                    conceptsCustomArray[clave].added = newValue;

                                    // Actualiza el máximo para `inputPA`
                                    let maxPoints = Math.floor(newValue / 45);
                                    inputPA.max = maxPoints;

                                    // Ajusta el valor actual de `pa` si excede el nuevo máximo
                                    if (conceptsCustomArray[clave].pa > maxPoints) {
                                        conceptsCustomArray[clave].pa = maxPoints;
                                        inputPA.value = maxPoints;
                                    }


                                    // Recalcula el total
                                    TotalCustomsConcepts = calculateCustomsTotal(conceptsCustomArray);
                                    calcCustomTotal(TotalCustomsConcepts, value_insurance_custom,
                                        valuea_added_insurance_custom);

                                });
                            } else {
                                // Si customAgency no existe, muestra el valor como texto plano
                                celdaAdded.textContent = item.added;
                            }



                            let celdaPA = fila.insertCell(4);
                            celdaPA.style.width = '15%';
                            let inputPA = document.createElement('input');
                            inputPA.type = 'number';
                            inputPA.value = (conceptsCustomArray[clave].pa) ? conceptsCustomArray[clave].pa : '';
                            inputPA.name = 'pa';
                            inputPA.classList.add('form-control', 'points');
                            inputPA.classList.remove('is-invalid');
                            inputPA.min = 0;
                            celdaPA.appendChild(inputPA);


                            inputPA.addEventListener('input', (e) => {

                                if (conceptCustomAgency) {

                                    conceptsCustomArray[clave].pa = e.target.value

                                } else {

                                    preventeDefaultAction(e);
                                }
                            });

                            if (Math.floor(item.added / 45) === 0) {

                                inputPA.max = 0;
                            } else {
                                inputPA.addEventListener('input', (e) => {
                                    // Indicamos cual es el maximo de puntos que puede asignarle
                                    inputPA.max = Math.floor(item.added / 45);
                                    // Agregamos este valor del punto al objeto, para que cuando dibujemos la tabla nuevamente, no se eliminen
                                    conceptsCustomArray[clave].pa = e.target.value
                                })
                            }

                            if (item.name != conceptCustomAgency.name) {

                                // Insertar un botón para eliminar la fila en la cuarta celda de la fila
                                let celdaEliminar = fila.insertCell(5);
                                let botonEliminar = document.createElement('a');
                                botonEliminar.href = '#';
                                botonEliminar.innerHTML = '<p class="text-danger">X</p>';
                                botonEliminar.addEventListener('click', function() {

                                    // Eliminar la fila correspondiente al hacer clic en el botón
                                    let fila = this.parentNode.parentNode;
                                    let indice = fila.rowIndex -
                                        1; // Restar 1 porque el índice de las filas en tbody comienza en 0
                                    delete conceptsCustomArray[Object.keys(conceptsCustomArray)[indice]];
                                    updateTableCustom(conceptsCustomArray);
                                });
                                celdaEliminar.appendChild(botonEliminar);

                            }


                            TotalCustomsConcepts += parseFloat(item.value) + parseFloat(item.added);
                        }
                    }

                    calcCustomTotal(TotalCustomsConcepts, value_insurance_custom, valuea_added_insurance_custom);

                }


                function calcCustomTotal(TotalCustomsConcepts, value_insurance_custom, valuea_added_insurance_custom) {

                    total = TotalCustomsConcepts + value_insurance_custom + valuea_added_insurance_custom;

                    //Buscamos dentro del contenedor el campo total

                    let inputTotal = $(`#modalAduanas`).find('#total');

                    inputTotal.val(total.toFixed(2));

                }

                function calculateCustomsTotal(conceptsCustomArray) {
                    return Object.values(conceptsCustomArray).reduce((acc, concept) => {
                        return acc + parseFloat(concept.value || 0) + parseFloat(concept.added || 0);
                    }, 0);
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


                const addCustomsPointsInsurance = (input) => {

                    let value_added = 0;

                    if (container != '') {
                        value_added = $(`#${container.id} #insurance_added`).val();
                    } else {
                        value_added = $(`#content_seguro #insurance_added`).val();
                    }


                    if (!value_added.trim()) {
                        input.value = 0;
                        input.max = 0;
                    } else {

                        //Indicamos el modal donde estemos trabajando y luego seleccionamos el campo.

                        let value_added_number = parseFloat(value_added.replace(/,/g, ''));

                        if (Math.floor(value_added_number / 45) === 0) {
                            input.value = 0;
                            input.max = 0;

                        } else {
                            input.max = Math.floor(value_added_number / 45);
                        }

                    }

                }

                const addPointsTransport = (input) => {


                    let value_added = $(`#${container.id} #transport_added`).val();

                    if (!value_added.trim()) {
                        input.value = 0;
                        input.max = 0;
                    } else {


                        let value_added_number = parseFloat(value_added.replace(/,/g, ''));

                        //Indicamos el modal donde estemos trabajando y luego seleccionamos el campo.

                        if (Math.floor(value_added_number / 45) === 0) {
                            input.value = 0;
                            input.max = 0;

                        } else {
                            input.max = Math.floor(value_added_number / 45);
                        }


                    }


                }

                // Asegúrate de que la función se ejecute cada vez que el valor de #insurance_added cambie
                $('#insurance_added').on('input', function() {

                    let insurancePointsInput = $('#insurance_points')[
                        0]; // Obtén el elemento de entrada de puntos de value_insurance
                    addCustomsPointsInsurance(insurancePointsInput); // Llama a la función con el elemento de entrada
                });


                function submitCustomsForm() {

                    let form = $(`#${container.id}`).find('form');
                    const inputs = form.find('input, select').not('.formConcepts  input, .formConcepts select, input.d-none');

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



                //Modal de seguro

                var modalInsurance = new bootstrap.Modal(document.getElementById("modalSeguro"), {});

                function openModalInsurance(service, index) {

                    modalInsurance.show();

                    $('#modalSeguro #typeService').val("Seguro");
                    $('#modalSeguro #service_insurance').val(index);
                    $('#modalSeguro #id_insurable_service').val(JSON.parse(service).id);


                }


                $('#modalSeguro').on('hidden.bs.modal', function() {

                    const formInsurance = $('#modalSeguro form')[0];
                    formInsurance.reset();
                })
            </script>
        @endpush

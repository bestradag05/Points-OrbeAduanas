<div class="row p-3">

    <input type="hidden" name="nro_quote_commercial"
        value="{{ isset($commercial_quote->nro_quote_commercial) ? $commercial_quote->nro_quote_commercial : '' }}">
    <input type="hidden" name="typeService" id="typeService">

    <div class="col-12 row">

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
                <label for="load_value">Valor FOB</label>

                <div class="input-group">

                    <input type="text" class="form-control  @error('load_value') is-invalid @enderror "
                        {{ isset($commercial_quote->load_value) ? 'readonly' : '' }} name="load_value"
                        placeholder="Ingrese valor de la carga"
                        value="{{ isset($commercial_quote->load_value) ? number_format($commercial_quote->load_value, 2) : old('load_value') }}">
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
                        {{ isset($commercial_quote->cif_value) ? 'readonly' : '' }} name="cif_value"
                        placeholder="Ingrese valor de la carga"
                        value="{{ isset($commercial_quote->cif_value) ? number_format($commercial_quote->cif_value, 2) : old('cif_value') }}">
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
                        {{ isset($customs_taxes->customs_perception) ? 'readonly' : '' }} name="customs_perception"
                        placeholder="Ingrese valor de la carga"
                        value="{{ isset($customs_taxes->customs_perception) ? $customs_taxes->customs_perception : old('customs_perception') }}">
                </div>

            </div>

        </div>

        <div class="col-12">

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="state_insurance" class="custom-control-input" id="seguroCustom"
                        onchange="enableInsurance(this)">
                    <label class="custom-control-label" for="seguroCustom">Agregar Seguro</label>
                </div>
            </div>
            <hr>
            <div class="row {{ isset($insurance) ? '' : 'd-none' }} d-none justify-content-center"
                id="content_seguroCustom">
                <div class="col-4">
                    <label for="type_insurance">Tipo de seguro</label>
                    <select name="type_insurance" onchange="selectInsurance(this)"
                        class="{{ isset($insurance) ? '' : 'd-none' }} form-control" label="Tipo de seguro"
                        igroup-size="md" data-placeholder="Seleccione una opcion..." data-required="true">
                        <option />
                        @foreach ($type_insurace as $type)
                            <option value="{{ $type->id }}"
                                {{ isset($insurance) && $insurance->id_type_insurance === $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="load_value">Valor del seguro</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-bold">
                                    $
                                </span>
                            </div>
                            <input type="text"
                                class="form-control CurrencyInput {{ isset($insurance) ? '' : 'd-none' }} "
                                id="value_insurance" name="value_insurance" data-type="currency" @readonly(true)
                                placeholder="Ingrese valor del seguro"
                                value="{{ isset($insurance) ? $insurance->insurance_value : '' }}"
                                onchange="updateInsuranceTotal(this)" data-required="true">
                        </div>

                    </div>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="load_value">Valor venta</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-bold">
                                    $
                                </span>
                            </div>
                            <input type="text"
                                class="form-control CurrencyInput {{ isset($insurance) ? '' : 'd-none' }} "
                                id="insurance_sales_value" name="insurance_sales_value" data-type="currency"
                                placeholder="Ingrese valor del seguro adicional"
                                value="{{ isset($insurance) ? $insurance->insurance_sales_value : '' }}"
                                onchange="updateInsuranceSalesValue(this)" data-required="true">
                        </div>

                    </div>
                </div>

            </div>

        </div>




    </div>

    <div id="formConceptsAduanas" class="col-12 formConcepts row">
        <div class="col-4">

            <x-adminlte-select2 name="concept" id="concept_aduana" label="Conceptos"
                data-placeholder="Seleccione un concepto...">
                <option />
                @foreach ($concepts as $concept)
                    @if ($concept->typeService->name == 'Aduanas' && $commercial_quote->type_shipment->id == $concept->id_type_shipment)
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
            <button class="btn btn-indigo" type="button" id="btnAddConcept" onclick="addConcept(this)">
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
                    <input type="text" class="form-control" id="total" name="totalCustom" value="0.00"
                        @readonly(true)>
                </div>
            </div>

        </div>


    </div>

    <div class="col-12 text-center mt-5">
        <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
    </div>
</div>

@push('scripts')
    <script>
        let conceptsArray = [];
        let countCustomConcepts = 0;
        let value_insurance = 0;
        let valuea_added_insurance = 0;
        let commercial_quote = @json($commercial_quote);
        let conceptCustom = null



        @if (isset($formMode) && $formMode === 'edit')
            conceptCustom = @json($conceptCustom);
            //Obtenemos los valores del seguro para sumarlo al total
            @if ($custom->insurance)
                value_insurance = parseFloat(@json($custom->insurance->insurance_value));
                valuea_added_insurance = parseFloat(@json($custom->insurance->insurance_value_added));

                //Obtenemos el insurance added para poder calcular el maximo de puntos: 

                let inputInsurancePoints = $('#insurance_points');

                if (!valuea_added_insurance) {
                    inputInsurancePoints.val(0); // Usamos .val() para establecer el valor
                    inputInsurancePoints.attr('max', 0); // Usamos .attr() para establecer el atributo max
                } else {
                    if (Math.floor(valuea_added_insurance / 45) === 0) {
                        inputInsurancePoints.val(0);
                        inputInsurancePoints.attr('max', 0);
                    } else {
                        inputInsurancePoints.attr('max', Math.floor(valuea_added_insurance / 45));
                    }
                }
            @endif


            @if (isset($custom->concepts))

                let concepts = @json($custom->concepts)



                concepts.forEach((concept, index) => {

                    if (concept.name != "SEGURO") {

                        conceptsArray.push({
                            'id': concept.id,
                            'name': concept.name,
                            'value': formatValue(concept.pivot.value_concept),
                            'added': formatValue(concept.pivot.added_value),
                            'pa': concept.pivot.additional_points > 0 ? concept.pivot
                                .additional_points : 0
                        });

                    }

                });
            @endif
        @endif


        updateTable(conceptsArray);



        function enableInsurance(checkbox) {

            const contenedorInsurance = $(`#content_seguroCustom`);
            if (checkbox.checked) {
                contenedorInsurance.addClass('d-flex').removeClass('d-none');
                contenedorInsurance.find("input").removeClass('d-none');
                contenedorInsurance.find('select').removeClass('d-none');

            } else {
                contenedorInsurance.addClass('d-none').removeClass('d-flex');
                contenedorInsurance.find("input").val('').addClass('d-none').removeClass('is-invalid');
                contenedorInsurance.find('select').val('').addClass('d-none').removeClass('is-invalid');

                value_insurance = 0;
                valuea_added_insurance = 0;

                calcTotal(TotalConcepts, value_insurance, valuea_added_insurance);

            }
        }

        function selectInsurance(select) {

            let typesInsurance = @json($type_insurace);
            let fobValue = @json($commercial_quote->load_value);
            let typeShipment = @json($commercial_quote->type_shipment);
            let selectValue = parseInt(select.value);

            let insurance = typesInsurance.find(type => type.id === selectValue);
            let rate = insurance.insurance_rate.find(rate => rate.shipment_type_description === typeShipment.description);

            if (!rate) {
                Swal.fire({
                    title: "No existe tarifa registrada para calcular el seguro",
                    text: "Por favor comunicate con el administrador, para que pueda registrar las tarifas de los seguros.",
                    icon: "info"
                });
                return;
            }

            let total = 0;

            if (fobValue <= rate.min_value) {
                total = parseFloat(rate.fixed_cost);
            } else {
                total = (fobValue * (rate.percentage / 100));
            }

            $('#insurance-detail-label').text(insurance.name);
            $('#value_insurance').val(total.toFixed(2));

            value_insurance = total;


            calcTotal(TotalConcepts, value_insurance);



        }


        function updateInsuranceTotal(element) {
            if (element.value === '') {
                value_insurance = 0;
            } else {
                value_insurance = parseFloat(element.value.replace(/,/g, ''));
            }

            calcTotal(TotalConcepts, value_insurance, valuea_added_insurance);
        }


        function updateInsuranceAddedTotal(element) {

            if (element.value === '') {
                valuea_added_insurance = 0;
            } else {
                valuea_added_insurance = parseFloat(element.value.replace(/,/g, ''));
            }

            //Cada que actualicemos el insurance_add borramos los puntos para poder volver a generar un maximo.
            $(`#insurance_points`).val("");

            calcTotal(TotalConcepts, value_insurance, valuea_added_insurance);
        }


        function calcTotal(TotalConcepts, value_insurance, valuea_added_insurance) {

            total = TotalConcepts + value_insurance + valuea_added_insurance;

            //Buscamos dentro del contenedor el campo total

            let inputTotal = $('#total');

            inputTotal.val(total.toFixed(2));

        }


        const addPointsInsurance = (input) => {

            let value_added = 0;


            value_added = $(`#insurance_added`).val();


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


        function addConcept(buton) {

            let divConcepts = $('.formConcepts');
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

                //Verificamos si el concepto ya existe en el array 

                const index = conceptsArray.findIndex(item => item.id === parseInt(inputs[0].value));

                if (index !== -1) {

                    conceptsArray[index] = {
                        'id': parseInt(inputs[0].value),
                        'name': inputs[0].options[inputs[0].selectedIndex].text,
                        'value': formatValue(inputs[1].value),
                        'added': formatValue(inputs[2].value),
                    };

                } else {

                    conceptsArray.push({
                        'id': parseInt(inputs[0].value),
                        'name': inputs[0].options[inputs[0].selectedIndex].text,
                        'value': formatValue(inputs[1].value),
                        'added': formatValue(inputs[2].value),
                    });
                }



                updateTable(conceptsArray);

                inputs[0].value = '';
                inputs[1].value = '';
                inputs[2].value = '';
            }
        };




        function updateTable(conceptsArray) {

            let tbodyRouting = $(`#formConceptsAduanas`).find('tbody')[0];

            if (tbodyRouting) {

                tbodyRouting.innerHTML = '';
            }
            TotalConcepts = 0;

            let contador = 0;

            for (let clave in conceptsArray) {


                let item = conceptsArray[clave];

                if (conceptsArray.hasOwnProperty(clave)) {
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


                    if (item.name === conceptCustom.name) {
                        // Si ocean_freight existe, muestra un input editable
                        let inputAdded = document.createElement('input');
                        inputAdded.type = 'text';
                        inputAdded.value = item.added;
                        inputAdded.classList.add('form-control', 'CurrencyInput'); // Agregar clases
                        inputAdded.setAttribute('data-type', 'currency'); // Establecer el atributo data-type
                        celdaAdded.appendChild(inputAdded);

                        inputAdded.addEventListener('input', (e) => {
                            let newValue = parseFloat(e.target.value) || 0;

                            // Actualiza el valor en `conceptsArray`
                            conceptsArray[clave].added = newValue;


                            // Actualiza el máximo para `inputPA`
                            let maxPoints = Math.floor(newValue / 45);
                            inputPA.max = maxPoints;

                            // Ajusta el valor actual de `pa` si excede el nuevo máximo
                            if (conceptsArray[clave].pa > maxPoints) {
                                conceptsArray[clave].pa = maxPoints;
                                inputPA.value = maxPoints;
                            }

                            // Recalcula el total
                            TotalConcepts = calculateTotal(conceptsArray);

                            calcTotal(TotalConcepts, value_insurance, valuea_added_insurance);

                        });
                    } else {
                        // Si ocean_freight no existe, muestra el valor como texto plano
                        celdaAdded.textContent = item.added;
                    }


                    let celdaPA = fila.insertCell(4);
                    celdaPA.style.width = '15%';
                    let inputPA = document.createElement('input');
                    inputPA.type = 'number';
                    inputPA.value = (conceptsArray[clave].pa) ? conceptsArray[clave].pa : '';
                    inputPA.name = 'pa';
                    inputPA.classList.add('form-control', 'points');
                    inputPA.classList.remove('is-invalid');
                    inputPA.min = 0;
                    celdaPA.appendChild(inputPA);

                    inputPA.addEventListener('keydown', (e) => {
                        // Permitimos solo las flechas (arriba: 38, abajo: 40), Tab (9), Enter (13)
                        const allowedKeys = ['ArrowUp', 'ArrowDown', 'Tab', 'Enter'];
                        if (!allowedKeys.includes(e.key)) {
                            e.preventDefault();
                        }
                    });


                    inputPA.addEventListener('input', (e) => {

                        conceptsArray[clave].pa = e.target.value


                    });

                    if (Math.floor(item.added / 45) === 0) {

                        inputPA.max = 0;
                    } else {
                        inputPA.max = Math.floor(item.added / 45);
                    }



                    if (item.name != conceptCustom.name) {

                        // Insertar un botón para eliminar la fila en la cuarta celda de la fila
                        let celdaEliminar = fila.insertCell(5);
                        let botonEliminar = document.createElement('a');
                        botonEliminar.href = '#';
                        botonEliminar.innerHTML = '<p class="text-danger">X</p>';
                        botonEliminar.addEventListener('click', function(event) {
                            event.preventDefault();
                            // Eliminar la fila correspondiente al hacer clic en el botón
                            let fila = this.parentNode.parentNode;
                            let indice = fila.rowIndex -
                                1; // Restar 1 porque el índice de las filas en tbody comienza en 0
                            conceptsArray.splice(indice, 1); // Eliminar el elemento en el índice correspondiente
                            updateTable(conceptsArray);
                        });
                        celdaEliminar.appendChild(botonEliminar);

                    }



                    TotalConcepts += parseFloat(item.value) + parseFloat(item.added);
                }
            }

            calcTotal(TotalConcepts, value_insurance, valuea_added_insurance);



        }


        function calculateTotal(conceptsArray) {
            return Object.values(conceptsArray).reduce((acc, concept) => {
                return acc + parseFloat(concept.value || 0) + parseFloat(concept.added || 0);
            }, 0);
        }


        function formatValue(value) {
            return value.replace(/,/g, '');
        }




        $('#formCustom').on('submit', (e) => {

            e.preventDefault();

            let form = $('#formCustom');
            let conceptops = JSON.stringify(conceptsArray);

            form.append(`<input type="hidden" name="concepts" value='${conceptops}' />`);

            form[0].submit();

        });
    </script>
@endpush

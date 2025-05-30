    {{-- Flete --}}
    <x-adminlte-modal id="modalFlete" class="modal" title="Flete" size='lg' scrollable>
        <form action="/routing_service" method="POST">
            @csrf

            <input type="hidden" name="nro_operation" value="{{ $comercialQuote->nro_quote_commercial }}">
            <input type="hidden" name="typeService" id="typeService">

            <div class="row">

                <div class="col-12">

                    <div class="form-group">
                        <label for="utility">Utilidad Orbe</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-bold">
                                    $
                                </span>
                            </div>
                            <input type="text" class="form-control CurrencyInput" id="utility" name="utility"
                                data-type="currency" placeholder="Ingrese valor de la utilidad">

                        </div>

                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" name="state_insurance" class="custom-control-input" id="seguroFreight"
                        onchange="enableInsurance(this)">
                    <label class="custom-control-label" for="seguroFreight">Agregar Seguro</label>
                </div>
            </div>

            <hr>
            <div class="row d-none justify-content-center" id="content_seguroFreight">
                <div class="col-3">
                    <label for="type_insurance">Tipo de seguro</label>
                    <select name="type_insurance" class="d-none form-control" label="Tipo de seguro" igroup-size="md"
                        data-placeholder="Seleccione una opcion...">
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
                                onchange="updateInsuranceTotal(this)">
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
                                placeholder="Ingrese valor de la carga" onchange="updateInsuranceAddedTotal(this)">
                        </div>

                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="load_value">Puntos</label>

                        <div class="input-group">
                            <input type="number" class="form-control d-none" id="insurance_points"
                                name="insurance_points" min="0" onkeydown="preventeDefaultAction(event)"
                                oninput="addPointsInsurance(this)">
                        </div>

                    </div>
                </div>
            </div>

            <hr>

            <div id="formConceptsFlete" class="formConcepts row">
                <div class="col-4">

                    <x-adminlte-select2 name="concept" id="concept_flete" label="Conceptos"
                        data-placeholder="Seleccione un concepto...">
                        <option />
                        @foreach ($concepts as $concept)
                            @if ($concept->typeService->name == 'Flete' && $comercialQuote->type_shipment->id == $concept->id_type_shipment)
                                <option value="{{ $concept->id }}">{{ $concept->name }}</option>
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
                            <th>Puntos Adicionales</th>
                            <th>x</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyFlete">


                    </tbody>
                </table>


                <div class="row w-100 justify-content-end">

                    <div class="col-4 row">
                        <label for="total" class="col-sm-4 col-form-label">Total:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="total" id="total" value="0.00"
                                @readonly(true)>
                        </div>
                    </div>

                </div>

            </div>

            <x-slot name="footerSlot">
                <x-adminlte-button class="btn btn-indigo" id="btnSubmit" type="submit" onclick="submitForm(this)"
                    label="Guardar" />
                <x-adminlte-button theme="secondary" label="Cerrar" data-dismiss="modal" />
            </x-slot>

        </form>

    </x-adminlte-modal>


{{--     <script>

        $('.modal').on('hide.bs.modal', function(e) {
            conceptsArray = {};
            TotalConcepts = 0;
            total = 0;
            flete = 0;
            value_insurance = 0;
            valuea_added_insurance = 0;
            countConcepts = 0;

            updateTable(conceptsArray, e.target.id);

            $(`#${e.target.id}`).find('form')[0].reset();
            $('.contentInsurance').addClass('d-none').removeClass('d-flex');

        });

        function enableInsurance(checkbox) {

            const contenedorInsurance = $(`#content_${checkbox.id}`);
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

                calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);

            }
        }


        function updateFleteTotal(element) {

            if (element.value === "") {
                flete = 0;
            } else {
                flete = parseFloat(formatValue(element.value));
            }

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }


        function updateInsuranceTotal(element) {

            if (element.value === '') {
                value_insurance = 0;
            } else {
                value_insurance = parseFloat(element.value.replace(/,/g, ''));
            }

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }


        function updateInsuranceAddedTotal(element) {


            if (element.value === '') {
                valuea_added_insurance = 0;
            } else {
                valuea_added_insurance = parseFloat(element.value.replace(/,/g, ''));
            }


            //Cada que actualicemos el insurance_add borramos los puntos para poder volver a generar un maximo.
            $(`#${container.id} #insurance_points`).val("");

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }

        function updateTransportTotal(element) {

            if (element.value === '') {
                value_insurance = 0;
            } else {
                value_insurance = parseFloat(element.value.replace(/,/g, ''));
            }

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }

        function updateTransportAddedTotal(element) {


            if (element.value === '') {
                valuea_added_insurance = 0;
            } else {
                valuea_added_insurance = parseFloat(element.value.replace(/,/g, ''));
            }


            //Cada que actualicemos el insurance_add borramos los puntos para poder volver a generar un maximo.
            $(`#${container.id} #additional_points`).val("");

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }


        function addConcept(buton) {

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

                conceptsArray[countConcepts] = {
                    'id': inputs[0].value,
                    'name': inputs[0].options[inputs[0].selectedIndex].text,
                    'value': formatValue(inputs[1].value),
                    'added': formatValue(inputs[2].value),
                }

                countConcepts++;

                updateTable(conceptsArray, container.id);

                inputs[0].value = '';
                inputs[1].value = '';
                inputs[2].value = '';
            }
        };

        function updateTable(conceptsArray, idContent, cost_transport = null) {

            let tbodyRouting = $(`#${idContent}`).find('tbody')[0];

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
                    if (cost_transport) {
                        // Si cost_transport existe, muestra un input editable
                        let inputAdded = document.createElement('input');
                        inputAdded.type = 'number';
                        inputAdded.value = item.added;
                        inputAdded.min = 0;
                        inputAdded.classList.add('form-control');
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
                            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);

                        });
                    } else {
                        // Si cost_transport no existe, muestra el valor como texto plano
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


                    inputPA.addEventListener('input', (e) => {

                        if (cost_transport) {

                            conceptsArray[clave].pa = e.target.value

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
                            conceptsArray[clave].pa = e.target.value
                        })
                    }



                    if (!cost_transport) {

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
                            delete conceptsArray[Object.keys(conceptsArray)[indice]];
                            updateTable(conceptsArray, idContent);
                        });
                        celdaEliminar.appendChild(botonEliminar);

                    }


                    TotalConcepts += parseFloat(item.value) + parseFloat(item.added);
                }
            }

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);

        }


        function calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, idContent) {

            total = TotalConcepts + flete + value_insurance + valuea_added_insurance;

            //Buscamos dentro del contenedor el campo total

            let inputTotal = $(`#${idContent}`).find('#total');

            inputTotal.val(total.toFixed(2));

        }

        function calculateTotal(conceptsArray) {
            return Object.values(conceptsArray).reduce((acc, concept) => {
                return acc + parseFloat(concept.value || 0) + parseFloat(concept.added || 0);
            }, 0);
        }

        function formatValue(value) {
            return value.replace(/,/g, '');
        }

        const preventeDefaultAction = (e) => {
            e.preventDefault();
        }


        const addPointsInsurance = (input) => {

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
            addPointsInsurance(insurancePointsInput); // Llama a la función con el elemento de entrada
        });


        function submitForm() {

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

                let conceptops = JSON.stringify(conceptsArray);

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

                let conceptops = JSON.stringify(conceptsArray);

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

        let cost_transport = @json($cost_transport ?? '');

        if (cost_transport && cost_transport != '') {
            var typeServices = @json($type_services);
            const selectElement = document.getElementById('type_service');

            typeServices.forEach(typeService => {

                if (typeService.name === 'Transporte') {
                    selectElement.value = typeService.id;
                }

            });

            const event = new Event('change');
            selectElement.dispatchEvent(event);


            $('#transport_value').val(cost_transport).prop('readonly', true);
            $('#origin').val("{{ $origin ?? '' }}").prop('readonly', true);
            $('#destination').val("{{ $destination ?? '' }}").prop('readonly', true);
            $('#quote_transport_id').val('{{ $quote_transport_id ?? '' }}')
            $('#withdrawal_date').val('{{ $withdrawal_date ?? '' }}').prop('readonly', true);


            let cost_gang = @json($cost_gang ?? null);
            let cost_guard = @json($cost_guard ?? null);

            @if (isset($cost_gang))

                if (cost_gang && cost_gang != '') {
                    let id_gang_concept = @json($id_gang_concept);

                    conceptsArray[id_gang_concept] = {
                        'id': id_gang_concept,
                        'name': 'CUADRILLA',
                        'value': formatValue("{{ $cost_gang }}"),
                        'added': 0,
                    }

                    updateTable(conceptsArray, container.id, cost_transport);

                }
            @endif


            @if (isset($cost_guard))

                if (cost_guard && cost_guard != '') {
                    let id_guard_concept = @json($id_guard_concept);

                    conceptsArray[id_guard_concept] = {
                        'id': id_guard_concept,
                        'name': 'RESGUARDO',
                        'value': formatValue("{{ $cost_guard }}"),
                        'added': 0,
                    }

                    updateTable(conceptsArray, container.id, cost_guard);

                }
            @endif




            value_insurance = parseFloat(cost_transport);

            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }




        function openModalTransport(quote) {
            let modalTransport = $('#modalTransport');
            let data = JSON.parse(quote);

            $('#modalTransport form').attr('action', '/quote/transport/complete/' + data.id);

            if (data.lcl_fcl != 'FCL') {
                $('#container-guard').addClass('d-none');
                $('#container-guard').find('input').addClass('d-none');
                $('#container-stackable').removeClass('d-none');
                $('#container-stackable').find('input').removeClass('d-none');
                $('#container_return').addClass('d-none');
                $('#container_return').find('input').addClass('d-none');
            } else {
                $('#container-guard').removeClass('d-none');
                $('#container-guard').find('input').removeClass('d-none');
                $('#container-stackable').addClass('d-none');
                $('#container-stackable').find('input').addClass('d-none');
                $('#container_return').removeClass('d-none');
                $('#container_return').find('input').removeClass('d-none');
            }


            modalTransport.modal('show');
        }

        function submitTransport(e) {
            e.preventDefault();

            let isValid = true;
            let form = $('#modalTransport form')[0];

            const inputs = Array.from(form.querySelectorAll('input')).filter(input => input.type !== 'hidden');

            inputs.forEach((input) => {
                // Ignorar campos ocultos (d-none)
                if (input.closest('.d-none')) {
                    return;
                }

                if (input.type === 'radio') {
                    // Obtener el grupo de radios
                    let radioGroup = form.querySelectorAll(`input[name="${input.name}"]`);
                    let isChecked = Array.from(radioGroup).some(radio => radio.checked);

                    if (!isChecked) {
                        radioGroup.forEach(radio => radio.classList.add('is-invalid'));
                        isValid = false;
                    } else {
                        radioGroup.forEach(radio => radio.classList.remove('is-invalid'));
                    }
                } else {
                    // Validar si el campo está vacío (excepto radios)
                    if (input.value.trim() === '') {
                        input.classList.add('is-invalid');
                        isValid = false; // Cambiar bandera si algún campo no es válido
                        showError(input, 'Debe completar este campo');
                    } else {
                        input.classList.remove('is-invalid');
                        hideError(input);
                    }
                }
            });

            if (isValid) {
                form.submit();
            }


        }

        // Mostrar mensaje de error
        function showError(input, message) {
            let errorSpan = input.nextElementSibling;
            if (!errorSpan || !errorSpan.classList.contains('invalid-feedback')) {
                errorSpan = document.createElement('span');
                errorSpan.classList.add('invalid-feedback');
                input.after(errorSpan);
            }
            errorSpan.textContent = message;
            errorSpan.style.display = 'block';
        }


        // Ocultar mensaje de error
        function hideError(input) {
            let errorSpan = input.nextElementSibling;
            if (errorSpan && errorSpan.classList.contains('invalid-feedback')) {
                errorSpan.style.display = 'none';
            }
        }
    </script> --}}

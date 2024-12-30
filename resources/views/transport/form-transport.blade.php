    <div class="row">

        <div class="col-4">
            <div class="form-group">
                <label for="transport_value">Valor del Transporte</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput" id="transport_value" name="transport_value"
                        onchange="updateTransportTotal(this)" data-type="currency" placeholder="Ingrese valor del flete"
                        @readonly(true) value="{{ isset($quote->cost_transport) ? $quote->cost_transport : '' }}">

                    @error('transport_value')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
                <label for="load_value">Valor ha agregar</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text text-bold">
                            $
                        </span>
                    </div>
                    <input type="text" class="form-control CurrencyInput" id="transport_added" name="transport_added"
                        data-type="currency" placeholder="Ingrese valor de la carga"
                        onchange="updateTransportAddedTotal(this)">

                </div>

            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="load_value">Puntos</label>

                <div class="input-group">
                    <input type="number" class="form-control" id="additional_points" name="additional_points"
                        min="0" oninput="addPointsTransport(this)">
                </div>

            </div>
        </div>



        <div class="col-4">

            <div class="form-group">
                <label for="origin">Recojo</label>
                <input type="text" class="form-control" id="origin" name="origin" placeholder="Ingrese el origin"
                    @readonly(true) value="{{ isset($quote->pick_up) ? $quote->pick_up : '' }}">

                @error('origin')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

            </div>

        </div>
        <div class="col-4">

            <div class="form-group">
                <label for="destination">Destino</label>

                <input type="text" class="form-control" id="destination" name="destination"
                    placeholder="Ingrese el destino" @readonly(true)
                    value="{{ isset($quote->delivery) ? $quote->delivery : '' }}">


                @error('destination')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

            </div>

        </div>
        <div class="col-4">


            <div class="form-group">
                <label for="withdrawal_date">Fecha de retiro</label>


                <input type="date" class="form-control" id="withdrawal_date" name="withdrawal_date"
                    placeholder="Ingrese el destino" @readonly(true)
                    value="{{ isset($quote->withdrawal_date) ? $quote->withdrawal_date : '' }}">


                @error('withdrawal_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

            </div>

        </div>

        <div id="formConceptsTransport" class="formConcepts row">

            @if (!isset($quote->cost_transport))
                <div class="col-3">

                    <x-adminlte-select2 name="concept" id="concept_transport" label="Conceptos"
                        data-placeholder="Seleccione un concepto...">
                        <option />
                        @foreach ($concepts as $concept)
                            @if ($concept->typeService->name == 'Transporte' && $quote->type_shipment->id == $concept->id_type_shipment)
                                <option value="{{ $concept->id }}">{{ $concept->name }}</option>
                            @endif
                        @endforeach
                    </x-adminlte-select2>

                </div>
                <div class="col-3">
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

                <div class="col-3">
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
                <div class="col-2 d-flex justify-content-center align-items-center pt-3 mb-2">
                    <button class="btn btn-indigo" type="button" id="btnAddConcept" onclick="addConcept(this)">
                        Agregar
                    </button>

                </div>
            @endif
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
                <tbody id="tbodyTransport">


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

    </div>

    <div class="container text-center mt-5">
        <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
    </div>

    @push('scripts')
        <script>
            let conceptsArray = {};
            let TotalConcepts = 0;
            let valuea_added = 0;
            let transporte = parseFloat($('#transport_value').val() || 0);

            let cost_gang = @json($quote->cost_gang ?? null);
            let cost_guard = @json($quote->cost_guard ?? null);



            calcTotal(TotalConcepts, transporte, valuea_added);


            function updateTransportAddedTotal(element) {


                if (element.value === '') {
                    valuea_added = 0;
                } else {
                    valuea_added = parseFloat(element.value.replace(/,/g, ''));
                }

                $(`#additional_points`).val("");


                calcTotal(TotalConcepts, transporte, valuea_added);
            }

            function calcTotal(TotalConcepts, transporte, valuea_added) {

                total = TotalConcepts + transporte + valuea_added;

                //Buscamos dentro del contenedor el campo total

                let inputTotal = $(`#total`);

                inputTotal.val(total.toFixed(2));

            }

            function addConcept(buton) {

                let divConcepts = $('#formConceptsTransport');
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

                    conceptsArray[inputs[0].value] = {
                        'id': inputs[0].value,
                        'name': inputs[0].options[inputs[0].selectedIndex].text,
                        'value': formatValue(inputs[1].value),
                        'added': formatValue(inputs[2].value),
                    }


                    updateTable(conceptsArray);

                    inputs[0].value = '';
                    inputs[1].value = '';
                    inputs[2].value = '';
                }
            };


            function updateTable(conceptsArray, cost_transport = null) {

                let tbodyRouting = $(`#formConceptsTransport`).find('tbody')[0];

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
                                calcTotal(TotalConcepts, transporte, valuea_added);

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

                                e.preventDefault();
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
                                updateTable(conceptsArray);
                            });
                            celdaEliminar.appendChild(botonEliminar);

                        }



                        TotalConcepts += parseFloat(item.value) + parseFloat(item.added);
                    }
                }

                calcTotal(TotalConcepts, transporte, valuea_added);

            }



            function calculateTotal(conceptsArray) {
                return Object.values(conceptsArray).reduce((acc, concept) => {
                    return acc + parseFloat(concept.value || 0) + parseFloat(concept.added || 0);
                }, 0);
            }




            const addPointsTransport = (input) => {


                let value_added = $(`#transport_added`).val();


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



            @if (isset($quote->cost_gang))

                if (cost_gang && cost_gang != '') {
                    let id_gang_concept = @json($params['id_gang_concept']);

                    conceptsArray[id_gang_concept] = {
                        'id': id_gang_concept,
                        'name': 'CUADRILLA',
                        'value': formatValue(cost_gang),
                        'added': 0,
                    }

                    updateTable(conceptsArray, transporte);

                }
            @endif


            @if (isset($quote->cost_guard))

                if (cost_guard && cost_guard != '') {
                    let id_guard_concept = @json($params['id_guard_concept']);

                    conceptsArray[id_guard_concept] = {
                        'id': id_guard_concept,
                        'name': 'RESGUARDO',
                        'value': formatValue(cost_guard),
                        'added': 0,
                    }

                    updateTable(conceptsArray, transporte);

                }
            @endif



            function formatValue(value) {
                return value.replace(/,/g, '');
            }
        </script>
    @endpush

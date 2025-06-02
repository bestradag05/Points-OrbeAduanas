<div class="row">


    {{-- <input type="hidden" name="nro_operation"
        value="{{ isset($routing->nro_operation) ? $routing->nro_operation : '' }}">
    <input type="hidden" name="id_quote_freight" value="{{ isset($quote->id) ? $quote->id : '' }}"> --}}

    <input type="hidden" name="nro_quote_commercial"
        value="{{ isset($commercial_quote->nro_quote_commercial) ? $commercial_quote->nro_quote_commercial : '' }}">
    <input type="hidden" name="quote_transport_id" value="{{ isset($quote->id) ? $quote->id : '' }}">

    {{-- <input type="hidden" name="typeService" id="typeService"> --}}


    <div class="col-6">
        <div class="form-group">
            <label for="utility">Recojo</label>
            <input type="text" class="form-control" id="pick_up" name="pick_up" @readonly(true)
                placeholder="Ingrese la direccion de recojo"
                value="{{ isset($quote->pick_up) ? $quote->pick_up : old('pick_up') }}">
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="utility">Entrega</label>
            <input type="text" class="form-control" id="delivery" name="delivery" @readonly(true)
                placeholder="Ingrese la direccion de entrega"
                value="{{ isset($quote->delivery) ? $quote->delivery : old('delivery') }}">

        </div>
    </div>

    @if ($quote->container_return)
        <div class="col-6">
            <div class="form-group">
                <label for="utility">Devolucion de contenedor</label>
                <input type="text" class="form-control" id="delivery" name="container_return" @readonly(true)
                    placeholder="Ingrese la devolucion del contenedor"
                    value="{{ isset($quote->container_return) ? $quote->container_return : old('container_return') }}">
            </div>
        </div>
    @endif


    <div class="col-6">
        <div class="form-group">
            <label for="utility">Fecha de retiro</label>
            <input type="text" class="form-control" id="delivery" name="withdrawal_date" @readonly(true)
                placeholder="Fecha de retiro"
                value="{{ isset($quote->withdrawal_date) ? \Carbon\Carbon::parse($quote->withdrawal_date)->format('d/m/Y') : old('withdrawal_date') }}">
        </div>
    </div>

    <div class="col-12 d-flex justify-content-center align-items-center pt-3 mb-2">
    </div>
    <div id="formConceptsTransport" class="col-12 d-flex formConcepts row">
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
            <tbody id="tbodyConcepts">


            </tbody>
        </table>


        <div class="row w-100 justify-content-end">

            <div class="col-4 row">
                <label for="total" class="col-sm-4 col-form-label">Total:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="total" name="total" value="0.00" readonly>
                </div>
            </div>
        </div>
        {{-- Mensaje de advertencia (se inyectará por JS si Total < response.total) --}}
        <div id="errorMinimo" class="p-3 text-center text-danger" style="display: none;">
            El valor total no puede ser menor que el total de la respuesta aceptada (
            {{ number_format($response->total, 2, '.', '') }}).
        </div>

    </div>



    <div class="container text-center mt-5">
        <input class="btn btn-primary" type="submit" id="btnGuardar"
            value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
    </div>

    {{--     {{dd($response->conceptResponses)}} --}}

    @push('scripts')
        <script>
            let conceptsArray = [];
            let TotalConcepts = 0;
            let total = 0;
            let countConcepts = 0;
            let conceptsTransport = null;

            // ——— LÍNEAS NUEVAS: traigo comisión y totalRespuesta desde PHP ———
            const commission = parseFloat(@json($response->commission)) || 0; // ← NUEVO
            const totalRespuesta = parseFloat(@json($response->total)) || 0; // ← NUEVO

            //PAra editar, verificamos si tiene conceptos el transporte: 
            @if (isset($formMode) && $formMode === 'edit')

                conceptTransport = @json($conceptTransport);

                @if (isset($response->conceptResponses))

                    let concepts = @json($response->conceptResponses);

                    concepts.forEach((concept, index) => {

                        console.log(concept);
                        conceptsArray.push({
                            'id': concept.concept.id,
                            'name': concept.concept.name,
                            'value': formatValue(concept.pivot.value_concept),
                            'added': formatValue(concept.pivot.added_value),
                            'pa': concept.pivot.additional_points > 0 ? concept.pivot
                                .additional_points : 0
                        });

                    });
                @endif
            @else

                value_transport = @json($quote->cost_transport);
                conceptTransport = @json($response->conceptResponses);

                // Ordenamiento corregido
                conceptTransport.sort((a, b) => {
                    const nameA = a.concept?.name?.toUpperCase() || '';
                    const nameB = b.concept?.name?.toUpperCase() || '';

                    if (nameA === "TRANSPORTE") return -1;
                    if (nameB === "TRANSPORTE") return 1;
                    return nameA.localeCompare(nameB);
                });

                conceptTransport.forEach(concept => {
                    // ——— MODIFICACIÓN NUEVA: sumo commission al net_amount si es "TRANSPORTE" ———
                    let base = parseFloat(concept.net_amount) || 0; // ← NUEVO
                    if ((concept.concept.name || '').toUpperCase() === 'TRANSPORTE') { // ← NUEVO
                        base += commission; // ← NUEVO
                    } // ← NUEVO

                    conceptsArray.push({
                        'id': concept.concepts_id,
                        'name': concept.concept.name,
                        'value': parseFloat(base.toFixed(2)), // ← REEMPLAZA formatValue(concept.net_amount)
                        'added': 0,
                        'pa': 0 // ← NUEVO: inicializamos puntos en 0
                    });
                });
            @endif

            updateTable(conceptsArray);

            function calcTotal(TotalConcepts) {
                total = TotalConcepts;

                //Buscamos dentro del contenedor el campo total
                let inputTotal = $('#total');
                inputTotal.val(total.toFixed(2));
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
                        console.log(tbodyRouting);
                        let fila = tbodyRouting.insertRow();

                        // Insertar el número de iteración en la primera celda de la fila
                        let celdaNumero = fila.insertCell(0);
                        celdaNumero.textContent = contador;

                        // Insertar el nombre del concepto en la segunda celda de la fila
                        let celdaClave = fila.insertCell(1);
                        celdaClave.textContent = item.name;

                        // Insertar el valor del concepto (net_amount) en la tercera celda
                        let celdaValor = fila.insertCell(2);
                        celdaValor.textContent = parseFloat(item.value).toFixed(2);

                        // Insertar el campo Valor agregado en la cuarta celda
                        let celdaAdded = fila.insertCell(3);

                        if (conceptTransport.some(concept => concept.concept.name === item.name)) {
                            // Si concepto existe, muestra un input editable
                            let inputAdded = document.createElement('input');
                            inputAdded.type = 'text';
                            inputAdded.value = item.added;
                            inputAdded.classList.add('form-control', 'CurrencyInput'); // Agregar clases
                            inputAdded.setAttribute('data-type', 'currency'); // Establecer el atributo data-type
                            inputAdded.setAttribute('data-index', clave); // ← NUEVO: guardo índice para el listener
                            celdaAdded.appendChild(inputAdded);

                            inputAdded.addEventListener('input', function(e) {
                                const index = parseInt(this.getAttribute('data-index'), 10);
                                let newValue = parseFloat(this.value) || 0;

                                // Actualiza el valor en el array
                                conceptsArray[index].added = newValue;

                                // Calcula nuevos puntos
                                const newPoints = Math.floor(newValue / 45);
                                conceptsArray[index].pa = newPoints;

                                // Actualiza el campo de puntos directamente
                                const pointsInput = this.parentNode.parentNode.cells[4].querySelector('input');
                                pointsInput.value = newPoints;

                                // Actualiza el total
                                TotalConcepts = calculateTotal(conceptsArray);
                                calcTotal(TotalConcepts);
                            });
                        } else {
                            // Si no existe en conceptTransport, muestra el valor agregado como texto plano
                            celdaAdded.textContent = item.added;
                        }

                        // Insertar el campo de Puntos Adicionales (input readonly) en la quinta celda
                        let celdaPA = fila.insertCell(4);
                        celdaPA.style.width = '15%';
                        let inputPA = document.createElement('input');
                        inputPA.type = 'number';
                        inputPA.value = item.pa; // pa pudo haber cambiado en el listener anterior
                        inputPA.name = 'pa';
                        inputPA.classList.add('form-control', 'points');
                        inputPA.readOnly = true; // siempre readonly
                        celdaPA.appendChild(inputPA);

                        // Evitamos que escriban en Puntos, solo flechas/tab
                        inputPA.addEventListener('keydown', (e) => {
                            const allowedKeys = ['ArrowUp', 'ArrowDown', 'Tab', 'Enter'];
                            if (!allowedKeys.includes(e.key)) {
                                e.preventDefault();
                            }
                        });

                        // Insertar botón de eliminar fila si aplica
                        if (!conceptTransport.some(concept => concept.name === item.name)) {
                            let celdaEliminar = fila.insertCell(5);
                            let botonEliminar = document.createElement('a');
                            botonEliminar.href = '#';
                            botonEliminar.innerHTML = '<p class="text-danger">X</p>';
                            botonEliminar.addEventListener('click', function(event) {
                                event.preventDefault();
                                let fila = this.parentNode.parentNode;
                                let indice = fila.rowIndex - 1;
                                conceptsArray.splice(indice, 1);
                                updateTable(conceptsArray);
                            });
                            celdaEliminar.appendChild(botonEliminar);
                        }

                        // ——— ACUMULO AL TOTAL GENERAL: (net_amount + added) ———
                        TotalConcepts += parseFloat(item.value) + parseFloat(item.added);
                    }
                }

                // ——— Actualizo el campo Total (input) y el span Total General en la vista ———
                calcTotal(TotalConcepts);
                $('#totalGeneral').text(TotalConcepts.toFixed(2)); // ← NUEVO

                // ——— MOSTRAR U OCULTAR MENSAJE Y HABILITAR/DESHABILITAR BOTÓN ———
                if (TotalConcepts < totalRespuesta) { // ← NUEVO
                    $('#errorMinimo').show(); // ← NUEVO
                    $('#btnGuardar').prop('disabled', true); // ← NUEVO
                } else {
                    $('#errorMinimo').hide(); // ← NUEVO
                    $('#btnGuardar').prop('disabled', false); // ← NUEVO
                }
            }

            function calculateTotal(conceptsArray) {
                return Object.values(conceptsArray).reduce((acc, concept) => {
                    return acc + parseFloat(concept.value || 0) + parseFloat(concept.added || 0);
                }, 0);
            }

            function formatValue(value) {
                return value.replace(/,/g, '');
            }

            // ——— Inicializar los listeners en los inputs “added-value” ———
            function attachListeners() {
                $('.added-value').each(function() {
                    $(this).off('input').on('input', function() {
                        let idx = parseInt($(this).attr('data-index'), 10);
                        let newVal = parseFloat($(this).val().replace(/,/g, '')) || 0;
                        conceptsArray[idx].added = newVal;
                        conceptsArray[idx].pa = Math.floor(newVal / 45);

                        updateTable(conceptsArray);
                        attachListeners(); // Re-vincular porque updateTable regenera la tabla
                    });
                });
            }

            // Al cargar, vinculamos los listeners una vez
            attachListeners();

            // ——— Al enviar el formulario, agregamos el JSON y permitimos envío ———
            $('#formTransport').on('submit', (e) => {
                // Creamos el hidden con el JSON sólo si pasa la validación de total ≥ totalRespuesta
                let hiddenJson = $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'concepts')
                    .val(JSON.stringify(conceptsArray));
                $(this).append(hiddenJson);
                // El submit procederá normalmente porque el botón estará habilitado sólo si totalGeneral ≥ totalRespuesta
            });
        </script>
    @endpush

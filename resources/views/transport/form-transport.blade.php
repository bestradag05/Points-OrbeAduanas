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

    <div class="col-12">
        <div class="row align-items-end">
            <div class="col-md-4">
                <label for="conceptSelect">Agregar nuevo concepto</label>
                <select id="conceptSelect" class="form-control">
                    <option value="">Seleccione...</option>
                    @foreach ($concepts as $concept)
                        @if (
                            $concept->typeService->name == 'Transporte' &&
                                $commercial_quote->type_shipment->id == $concept->id_type_shipment &&
                                $concept->name != 'TRANSPORTE')
                            <option value="{{ $concept->id }}">
                                {{ $concept->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="conceptValue">Valor del concepto</label>
                <input type="text" class="form-control CurrencyInput" id="conceptValue"
                    placeholder="Ingrese Valor de Concepto">
            </div>
            <div class="col-md-3">
                <label for="addedValue">Valor agregado</label>
                <input type="text" class="form-control CurrencyInput" id="addedValue"
                    placeholder="Ingrese Valor Agregado">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success" onclick="addConceptFromDropdown()">Agregar</button>
            </div>
        </div>
    </div>


    <div class="col-12 d-flex justify-content-center align-items-center pt-3 mb-2">
    </div>
    <div id="formConceptsTransport" class="col-12 d-flex formConcepts row">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 35%;">Concepto</th>
                    <th style="width: 20%;">Valor del concepto</th>
                    <th style="width: 20%;">Valor agregado</th>
                </tr>
            </thead>
            <tbody id="tbodyConcepts">
            </tbody>
        </table>


        <div class="container mt-3">
            <div class="row justify-content-end">
                <div class="col-md-6">

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="totalRespuesta" class="form-label fw-bold mb-0">Total de la respuesta:</label>
                        <input type="text" id="totalRespuesta" class="form-control text-end ms-2"
                            style="width: 150px;" readonly value="{{ number_format($response->total, 2) }}">
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="total" class="form-label fw-bold mb-0">Total:</label>
                        <input type="text" id="total" class="form-control text-end ms-2" style="width: 150px;"
                            readonly value="0.00">
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <label for="gananciaCalculada" class="form-label fw-bold mb-0">Ganancia:</label>
                        <input type="text" id="gananciaCalculada" class="form-control text-end ms-2"
                            style="width: 150px;" readonly value="0.00">
                    </div>

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


                @if (isset($transport->concepts))

                    let concepts = @json($transport->concepts);
                    console.log(concepts);

                    concepts.forEach((concept, index) => {
                        console.log(concept);

                        conceptsArray.push({
                            'id': concept.id,
                            'name': concept.name,
                            'value': formatValue(concept.pivot.net_amount_response || 0),
                            'added': formatValue(concept.pivot.added_value || 0),
                        });

                    });
                @endif
            @else

                value_transport = @json($quote->cost_transport);
                conceptsTransport = @json($response->conceptResponseTransports);

                // Ordenamiento corregido
                conceptsTransport.sort((a, b) => {
                    const nameA = a.concept?.name?.toUpperCase() || '';
                    const nameB = b.concept?.name?.toUpperCase() || '';

                    if (nameA === "TRANSPORTE") return -1;
                    if (nameB === "TRANSPORTE") return 1;
                    return nameA.localeCompare(nameB);
                });

                conceptsTransport.forEach(concept => {


                    conceptsArray.push({
                        'id': concept.concepts_id,
                        'name': concept.concept.name,
                        'value': '', // ← REEMPLAZA formatValue(concept.net_amount)
                        'added': '',
                    });
                });
            @endif

            const isEditMode = "{{ $formMode ?? '' }}" === "edit";

            updateTable(conceptsArray);

            function calcTotal(TotalConcepts, totalRespuestaParam = totalRespuesta) {
                total = TotalConcepts;

                const btnGuardar = document.querySelector('#btnGuardar'); // Asegúrate de tener este ID en tu botón


                $('#total').val((total || 0).toFixed(2));

                // Calcular ganancia real
                let ganancia = total - totalRespuestaParam;
                if (ganancia < 0) ganancia = 0;

                if (total >= totalRespuesta) {
                    btnGuardar.removeAttribute('disabled');
                } else {
                    btnGuardar.setAttribute('disabled', 'true');
                }

                $('#gananciaCalculada').val((ganancia || 0).toFixed(2));
            }

            function addConcept(buton) {
                let divConcepts = $('.formConcepts');
                const inputs = divConcepts.find('input, select');

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
                let tbodyRouting = $('#formConceptsTransport').find('tbody')[0];

                if (tbodyRouting) {
                    tbodyRouting.innerHTML = '';
                }
                TotalConcepts = 0;

                let contador = 0;

                for (let clave in conceptsArray) {
                    let item = conceptsArray[clave];

                    if (conceptsArray.hasOwnProperty(clave)) {
                        contador++;
                        let fila = tbodyRouting.insertRow();

                        // Celda 1: número
                        let celdaNumero = fila.insertCell(0);
                        celdaNumero.textContent = contador;

                        // Celda 2: nombre del concepto
                        let celdaClave = fila.insertCell(1);
                        celdaClave.textContent = item.name;

                        // Celda 3: valor del concepto
                        let celdaValor = fila.insertCell(2);

                        // Celda 4: valor agregado
                        let celdaAdded = fila.insertCell(3);

                        // Mostrar campos como inputs si es modo edición o vienen desde la respuesta
                        if (isEditMode || (conceptsTransport && conceptsTransport.some(concept => concept.concept.name === item
                                .name))) {
                            // Input de valor
                            let inputValor = document.createElement('input');
                            inputValor.type = 'text';
                            inputValor.value = item.value;
                            inputValor.classList.add('form-control', 'CurrencyInput');
                            inputValor.setAttribute('data-type', 'currency');
                            celdaValor.appendChild(inputValor);

                            // Input de valor agregado
                            let inputAdded = document.createElement('input');
                            inputAdded.type = 'text';
                            inputAdded.value = item.added;
                            inputAdded.classList.add('form-control', 'CurrencyInput');
                            inputAdded.setAttribute('data-type', 'currency');
                            celdaAdded.appendChild(inputAdded);

                            // Eventos
                            inputValor.addEventListener('input', (e) => {
                                const fila = e.target.closest('tr');
                                const index = fila.rowIndex - 1;
                                const newValue = formatValue(e.target.value);
                                conceptsArray[index].value = newValue;

                                const totalConceptos = calculateTotal(conceptsArray);
                                TotalConcepts = totalConceptos;
                                calcTotal(totalConceptos, totalRespuesta);
                            });

                            inputAdded.addEventListener('input', (e) => {
                                const fila = e.target.closest('tr');
                                const index = fila.rowIndex - 1;
                                const newValue = formatValue(e.target.value);
                                conceptsArray[index].added = newValue;

                                const totalConceptos = calculateTotal(conceptsArray);
                                TotalConcepts = totalConceptos;
                                calcTotal(totalConceptos, totalRespuesta);
                            });
                        } else {
                            // Mostrar valores como texto plano
                            celdaValor.textContent = item.value;
                            celdaAdded.textContent = item.added;
                        }

                        TotalConcepts += parseFloat(item.value || 0) + parseFloat(item.added || 0);
                    }
                }

                calcTotal(TotalConcepts);
            }


            function calculateTotal(conceptsArray) {
                return Object.values(conceptsArray).reduce((acc, concept) => {
                    return acc + parseFloat(concept.value || 0) + parseFloat(concept.added || 0);
                }, 0);
            }

            function formatValue(value) {
                if (typeof value === 'number') return value;
                return parseFloat(value.toString().replace(/,/g, '')) || 0;
            }


            // Imprime un mensaje para asegurarte de que el DOM ya está listo:
            $(document).ready(function() {
                console.log('FormTransport listo para inyectar conceptsArray');
            });

            $('#formTransport').on('submit', function(e) {
                e.preventDefault();

                let form = $(this);

                let conceptops = JSON.stringify(conceptsArray);


                // Inyecta el <input type="hidden" name="concepts" ...>
                form.append(`<input type="hidden" name="concepts" value='${conceptops}' />`);

                let acceptedAnswerValue = parseFloat($('#totalRespuesta').val().replace(/,/g, '')) || 0;
                let totalTransportValue = parseFloat($('#total').val().replace(/,/g, '')) || 0;
                let profitValue = parseFloat($('#gananciaCalculada').val().replace(/,/g, '')) || 0;

                form.append(`<input type="hidden" name="accepted_answer_value" value='${acceptedAnswerValue.toFixed(2)}'>`);
                form.append(`<input type="hidden" name="value_sale" value='${totalTransportValue.toFixed(2)}'>`); -
                form.append(`<input type="hidden" name="profit"                value='${profitValue.toFixed(2)}'>`);


                // Ahora sí envía normalmente
                form.off('submit'); // para evitar loop infinito
                form.submit();
            });


            function addConceptFromDropdown() {
                const conceptSelect = document.getElementById('conceptSelect');
                const conceptValueInput = document.getElementById('conceptValue');
                const addedValueInput = document.getElementById('addedValue');

                const conceptId = parseInt(conceptSelect.value);
                const conceptName = conceptSelect.options[conceptSelect.selectedIndex].text;
                const value = formatValue(conceptValueInput.value);
                const added = formatValue(addedValueInput.value);

                if (!conceptId || !value) {
                    conceptSelect.classList.add('is-invalid');
                    conceptValueInput.classList.add('is-invalid');
                    return;
                }

                conceptSelect.classList.remove('is-invalid');
                conceptValueInput.classList.remove('is-invalid');

                const index = conceptsArray.findIndex(item => item.id === conceptId);
                if (index !== -1) {
                    conceptsArray[index].value = formatValue(inputs[1].value);
                    conceptsArray[index].added = formatValue(inputs[2].value);
                } else {
                    conceptsArray.push({
                        id: conceptId,
                        name: conceptName,
                        value: value,
                        added: added,
                    });
                }

                conceptSelect.value = '';
                conceptValueInput.value = '';
                addedValueInput.value = '';

                updateTable(conceptsArray);
            }
        </script>
    @endpush

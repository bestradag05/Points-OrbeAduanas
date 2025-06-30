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


                @if (isset($transport->concepts))

                    let concepts = @json($transport->concepts);
                    console.log(concepts);

                    concepts.forEach((concept, index) => {
                        console.log(concept);

                        conceptsArray.push({
                            'id': concept.id,
                            'name': concept.name,
                            'value': formatValue(concept.pivot.net_amount_response), // CAMBIO AQUÍ
                            'added': formatValue(concept.pivot.added_value),
                            'pa': concept.pivot.additional_points > 0 ? concept.pivot.additional_points : 0
                        });

                    });
                @endif
            @else

                value_transport = @json($quote->cost_transport);
                conceptsTransport = @json($response->conceptResponses);

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
                        'value': formatValue(concept.net_amount), // ← REEMPLAZA formatValue(concept.net_amount)
                        'added': 0,
                        'pa': 0 // ← NUEVO: inicializamos puntos en 0
                    });
                });
            @endif

            const isEditMode = "{{ $formMode ?? '' }}" === "edit";

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

                let tbodyRouting = $('#formConceptsTransport').find('tbody')[0];

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


                        if (isEditMode || (conceptsTransport && conceptsTransport.some(concept => concept.concept.name === item.name))) {

                            // Si concepto existe, muestra un input editable
                            let inputAdded = document.createElement('input');
                            inputAdded.type = 'text';
                            inputAdded.value = item.added;
                            inputAdded.classList.add('form-control', 'CurrencyInput'); // Agregar clases
                            inputAdded.setAttribute('data-type', 'currency'); // Establecer el atributo data-type
                            celdaAdded.appendChild(inputAdded);

                            console.log('Edit Mode:', isEditMode);


                            inputAdded.addEventListener('input', (e) => {
                                let newValue = parseFloat(e.target.value) || 0;

                                // Actualiza el valor en conceptsArray
                                conceptsArray[clave].added = newValue;


                                // Actualiza el máximo para inputPA
                                let maxPoints = Math.floor(newValue / 45);
                                inputPA.max = maxPoints;

                                // Ajusta el valor actual de pa si excede el nuevo máximo
                                if (conceptsArray[clave].pa > maxPoints) {
                                    conceptsArray[clave].pa = maxPoints;
                                    inputPA.value = maxPoints;
                                }

                                // Recalcula el total
                                TotalConcepts = calculateTotal(conceptsArray);

                                calcTotal(TotalConcepts);

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


                        if (isEditMode || !conceptsTransport || !conceptsTransport.some(concept => concept.name === item.name)) {


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

                calcTotal(TotalConcepts);



            }

            function calculateTotal(conceptsArray) {
                return Object.values(conceptsArray).reduce((acc, concept) => {
                    return acc + parseFloat(concept.value || 0) + parseFloat(concept.added || 0);
                }, 0);
            }

            function formatValue(value) {
                return value.replace(/,/g, '');
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

                // Ahora sí envía normalmente
                form.off('submit'); // para evitar loop infinito
                form.submit();
            });
        </script>
    @endpush

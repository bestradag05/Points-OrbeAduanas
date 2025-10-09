<div class="row">


    {{-- <input type="hidden" name="nro_operation"
        value="{{ isset($routing->nro_operation) ? $routing->nro_operation : '' }}">
    <input type="hidden" name="id_quote_freight" value="{{ isset($quote->id) ? $quote->id : '' }}"> --}}

    <input type="hidden" name="nro_quote_commercial"
        value="{{ isset($commercial_quote->nro_quote_commercial) ? $commercial_quote->nro_quote_commercial : '' }}">
    <input type="hidden" name="quote_transport_id" value="{{ isset($quote->id) ? $quote->id : '' }}">
    <input type="hidden" name="total_usd"
        value="{{ isset($acceptedResponse->total_usd) ? $acceptedResponse->total_usd : '' }}">
    <input type="hidden" name="total_prices_usd"
        value="{{ isset($acceptedResponse->total_prices_usd) ? $acceptedResponse->total_prices_usd : '' }}">
    <input type="hidden" name="value_utility"
        value="{{ isset($acceptedResponse->value_utility) ? $acceptedResponse->value_utility : '' }}">

    {{-- <input type="hidden" name="typeService" id="typeService"> --}}


    <div class="col-6">
        <div class="form-group">
            <label for="utility">Recojo</label>
            <input type="text" class="form-control" id="pick_up" name="pick_up" @readonly(true)
                placeholder="Ingrese la direccion de recojo"
                value="{{ isset($quote->pick_up) ? $quote->pick_up : $quote->pickupWarehouse->name_businessname }}">
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label for="utility">Entrega</label>
            <input type="text" class="form-control" id="delivery" name="delivery" @readonly(true)
                placeholder="Ingrese la direccion de entrega"
                value="{{ isset($quote->delivery) ? $quote->delivery : $quote->deliveryWarehouse->name_businessname }}">

        </div>
    </div>

    @if ($quote->container_return)
        <div class="col-6">
            <div class="form-group">
                <label for="utility">Devolucion de contenedor</label>
                <input type="text" class="form-control" id="delivery" name="container_return" @readonly(true)
                    placeholder="Ingrese la devolucion del contenedor"
                    value="{{ isset($quote->container_return) ? $quote->returnWarehouse->name_businessname : old('container_return') }}">
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
                <button class="btn btn-indigo btn-xs" type="button" onclick="openToModal('modalAddConcept')">
                    <i class="fas fa-plus"></i>
                </button>
                :
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
                    <th style="width: 30%;">Costo Neto ($)</th>
                    <th style="width: 30%;">Valor del concepto</th>
                    <th style="width: 30%;">Acciones</th>
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
                            style="width: 150px;" readonly
                            value="{{ number_format($acceptedResponse->total_prices_usd, 2) }}">
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="value_sale" class="form-label fw-bold mb-0">Total:</label>
                        <input type="text" id="value_sale" name="value_sale" class="form-control text-end ms-2"
                            style="width: 150px;" readonly value="0.00">
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <label for="profit" class="form-label fw-bold mb-0">Ganancia sin Igv:</label>
                        <input type="text" id="profit" name="profit" class="form-control text-end ms-2"
                            style="width: 150px;" readonly value="0.00">
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <input type="hidden" id="subtotal" name="subtotal" class="form-control text-end ms-2"
                            style="width: 150px;">
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <input type="hidden" id="igv" name="igv" class="form-control text-end ms-2"
                            style="width: 150px;">
                    </div>

                </div>
            </div>
        </div>


        {{-- Mensaje de advertencia (se inyectará por JS si Total < response.total) --}}
        <div id="errorMinimo" class="p-3 text-center text-danger" style="display: none;">
            El valor total no puede ser menor que el total de la respuesta aceptada (
            {{ number_format($acceptedResponse->total, 2, '.', '') }}).
        </div>
    </div>

    <div class="container text-center mt-5">
        <input class="btn btn-indigo" type="submit" id="btnGuardar"
            value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
    </div>

</div>

{{--     {{dd($response->conceptResponses)}} --}}

@push('scripts')
    <script>
        let conceptsArray;
        let conceptsTransport;
        let total;
        const totalRespuesta = parseFloat(@json($acceptedResponse->total_prices_usd)) || 0;
        const totalUsd = parseFloat(@json($acceptedResponse->total_usd)) || 0;
        const isEditMode = "{{ $formMode ?? '' }}" === "edit";

        const includesIgv = (parseFloat(@json($acceptedResponse->igv)) || 0) > 0;
        const exchangeRate = parseFloat(@json($acceptedResponse->exchange_rate)) || 1;
        const providercost = parseFloat(@json($acceptedResponse->provider_cost)) || 0;



        $(document).ready(function() {
            conceptsArray = [];

            @if ($formMode === 'edit')

                conceptsTransport = @json($transport->concepts);
                total = 0;

                conceptsTransport.forEach(c => {
                    conceptsArray.push({
                        id: c.id,
                        name: c.name,
                        value: formatValue(c.pivot.value_concept),
                        pivotValue: c.pivot.response_value
                    });

                });

                updateTable(conceptsArray);
            @else

                conceptsTransport = @json($conceptsTransport);
                total = 0;

                conceptsTransport.forEach(c => {
                    conceptsArray.push({
                        id: c.concepts_id,
                        name: c.concept.name,
                        value: 0,
                        pivotValue: c.pivot.sale_price
                    });
                });

                updateTable(conceptsArray);
            @endif

        });

        function formatValue(value) {
            if (value === null || value === undefined) return 0;
            if (typeof value === 'number') return value;
            return parseFloat(value.toString().replace(/,/g, '')) || 0;
        }

        function calculateTotal(conceptsArray) {
            return conceptsArray.reduce((acc, c) => acc + parseFloat(c.value || 0), 0);
        }

        function calcTotal(TotalConcepts, totalRespuestaParam = totalRespuesta) {
            total = TotalConcepts;
            $('#value_sale').val(total.toFixed(2));

            let subtotalValue, igvValue, ganancia;

            if (includesIgv) {
                subtotalValue = +(total / 1.18).toFixed(2);
                igvValue = +(total - subtotalValue).toFixed(2);
                ganancia = (total - totalRespuestaParam) / 1.18;
            } else {
                subtotalValue = +total.toFixed(2);
                igvValue = 0.00;
                ganancia = (total - totalRespuestaParam);
            }

            if (ganancia < 0) ganancia = 0;

            $('#igv').val(igvValue.toFixed(2));
            $('#subtotal').val(subtotalValue.toFixed(2));
            $('#profit').val(ganancia.toFixed(2));

            const btn = document.querySelector('#btnGuardar');
            if (total >= totalRespuesta) {
                btn.removeAttribute('disabled');
            } else {
                btn.setAttribute('disabled', 'true');
            }
        }


        function updateTable(conceptsArray) {
            const tbody = $('#formConceptsTransport tbody')[0];
            if (!tbody) return;
            tbody.innerHTML = '';

            let contador = 0;
            let sumaLocal = 0;

            conceptsArray.forEach(item => {
                contador++;
                const fila = tbody.insertRow();

                // 1) Nº
                fila.insertCell(0).textContent = contador;

                // 2) Concepto
                fila.insertCell(1).textContent = item.name;

                // 3) Costo Neto ($) ⇒ readonly
                const celdaUsd = fila.insertCell(2);
                const usdVal = formatValue(item?.pivotValue ?? 0);
                const inpUsd = document.createElement('input');
                inpUsd.type = 'text';
                inpUsd.value = usdVal.toFixed(2);
                inpUsd.classList.add('form-control', 'text-end');
                inpUsd.readOnly = true;
                celdaUsd.appendChild(inpUsd);

                // 4) Valor del concepto ⇒ editable solo en edit

                const celdaVal = fila.insertCell(3);
                if (isEditMode || (conceptsTransport && conceptsTransport.some(c => c.concept.name === item
                        .name))) {
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.value = item.value;
                    input.classList.add('form-control', 'CurrencyInput');
                    input.setAttribute('data-type', 'currency');
                    input.addEventListener('input', e => {
                        const idx = e.target.closest('tr').rowIndex - 1;
                        const newVal = formatValue(e.target.value);
                        conceptsArray[idx].value = newVal;
                        const tot = calculateTotal(conceptsArray);
                        calcTotal(tot);
                    });
                    celdaVal.appendChild(input);
                } else {
                    celdaVal.textContent = item.value;
                }

                let celdaEliminar = fila.insertCell(4);
                let botonEliminar = document.createElement('a');
                botonEliminar.href = '#';
                botonEliminar.innerHTML = '<p class="text-danger">X</p>';
                botonEliminar.addEventListener('click', function(event) {
                    event.preventDefault();
                    // Eliminar la fila correspondiente al hacer clic en el botón
                    let fila = this.parentNode.parentNode;
                    let indice = fila.getAttribute('data-index');
                    console.log(fila);
                    console.log(indice);

                    conceptsArray.splice(indice, 1); // Eliminar el elemento en el índice correspondiente
                    updateTable(conceptsArray);
                });
                celdaEliminar.appendChild(botonEliminar);
                fila.setAttribute('data-index', contador - 1);


                sumaLocal += parseFloat(item.value || 0);
            });

            calcTotal(sumaLocal);
        }

        function addConceptFromDropdown() {
            const sel = document.getElementById('conceptSelect');
            const inp = document.getElementById('conceptValue');
            const conceptId = parseInt(sel.value);
            const conceptName = sel.options[sel.selectedIndex].text;
            const value = formatValue(inp.value);

            if (!conceptId || !value) {
                sel.classList.add('is-invalid');
                inp.classList.add('is-invalid');
                return;
            }
            sel.classList.remove('is-invalid');
            inp.classList.remove('is-invalid');

            const idx = conceptsArray.findIndex(c => c.id === conceptId);
            if (idx !== -1) {
                conceptsArray[idx].value = value;
                conceptsArray[idx].isNew = true;
            } else {
                conceptsArray.push({
                    id: conceptId,
                    name: conceptName,
                    value: value,
                    pivotValue: 0,
                    isNew: true
                });
            }
            sel.value = '';
            inp.value = '';
            updateTable(conceptsArray);
        }

        function openModalConcept(firstModal, secondModal) {
            $(`#${firstModal}`).modal('hide');
            $(`#${firstModal}`).on('hidden.bs.modal', function() {
                $(`#${secondModal}`).modal('show');
            });
        }

        function closeToModalAddConcept(firstModal, secondModal) {
            $(`#${secondModal}`).modal('hide');
            $(`#${secondModal}`).on('hidden.bs.modal', function() {
                $(`#${firstModal}`).modal('show');
            });
        }

        function openToModal(modalId) {
            $(`#${modalId}`).modal('show');
        }

        function closeToModal(modalId) {
            $(`#${modalId}`).modal('hide');
        }



        function saveConceptToDatabase(data) {

            if (validateModalAddConcept()) {
                let data = $('#formAddConcept').find('input, select'); // Obtener los datos del formulario

                // Enviar el concepto al backend (guardar en la base de datos)
                $.ajax({
                    url: '/concepts/async', // Reemplaza con la ruta de tu backend
                    type: 'POST',
                    data: data, // Enviar los datos del concepto
                    success: function(response) {

                        const newOption = new Option(response.name, response.id, true,
                            true); // 'true' selecciona el concepto
                        $('#conceptSelect').append(newOption).trigger('change');

                        toastr.success("Concepto agregado");

                        closeToModalAddConcept('modalTransport', 'modalAddConcept');
                        $('#formAddConcept #name').val('');

                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 400) {
                            toastr.error(xhr.responseJSON.error); // Mostrar el error retornado desde el backend
                        } else {
                            toastr.error("Error al guardar el concepto en la base de datos");
                        }
                    }
                });
            }
        }

        function validateModalAddConcept() {
            let isValid = true; // Bandera para saber si todo es válido
            const inputs = $('#formAddConcept').find('input, select'); // Obtener todos los inputs y selects
            inputs.each(function() {
                const input = $(this);
                // Si el campo es obligatorio
                if (input.val().trim() === '' || (input.is('select') && input.val() == null)) {
                    input.addClass('is-invalid'); // Agregar clase para marcar como inválido
                    isValid = false; // Si algún campo no es válido, marcar como false
                } else {
                    input.removeClass('is-invalid'); // Eliminar la clase de error si es válido
                }
            });

            return isValid; // Si todo es válido, devuelve true; si no, false
        }


        $('#formTransport').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            form.append(
                `<input type="hidden" name="concepts" value='${JSON.stringify(conceptsArray)}' />`,
            );
            form.off('submit').submit();
        });
    </script>
@endpush

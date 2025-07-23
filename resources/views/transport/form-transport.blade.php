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
            {{ number_format($acceptedResponse->total, 2, '.', '') }}).
        </div>
    </div>

    <div class="container text-center mt-5">
        <input class="btn btn-primary" type="submit" id="btnGuardar"
            value="{{ $formMode === 'edit' ? 'Actualizar' : 'Guardar' }}">
    </div>


    {{--     {{dd($response->conceptResponses)}} --}}

    @push('scripts')
<script>
    // —– VARIABLES GLOBALES (disponibles para funciones) —–
    let conceptsArray;
    let conceptsTransport;
    let total;
    const totalRespuesta = parseFloat(@json($acceptedResponse->total_prices_usd)) || 0;
    const totalUsd       = parseFloat(@json($acceptedResponse->total_usd))       || 0;
    const isEditMode     = "{{ $formMode ?? '' }}" === "edit";

    // —– FUNCIONES AUXILIARES —–

    function formatValue(value) {
        if (typeof value === 'number') return value;
        return parseFloat(value.toString().replace(/,/g, '')) || 0;
    }

    function calculateTotal(conceptsArray) {
        return Object.values(conceptsArray).reduce((acc, concept) => {
            return acc + parseFloat(concept.value || 0);
        }, 0);
    }

    function calcTotal(TotalConcepts, totalRespuestaParam = totalRespuesta) {
        total = TotalConcepts;
        const btnGuardar = document.querySelector('#btnGuardar');
        $('#total').val((total || 0).toFixed(2));

        let ganancia = total - totalRespuestaParam;
        if (ganancia < 0) ganancia = 0;

        if (total >= totalRespuesta) {
            btnGuardar.removeAttribute('disabled');
        } else {
            btnGuardar.setAttribute('disabled', 'true');
        }

        $('#gananciaCalculada').val((ganancia).toFixed(2));
    }

    function updateTable(conceptsArray) {
        const tbody = $('#formConceptsTransport').find('tbody')[0];
        if (tbody) tbody.innerHTML = '';

        let TotalConcepts = 0;
        let contador = 0;

        conceptsArray.forEach(item => {
            contador++;
            const fila = tbody.insertRow();

            // Nº
            const celdaNum = fila.insertCell(0);
            celdaNum.textContent = contador;

            // Nombre
            const celdaName = fila.insertCell(1);
            celdaName.textContent = item.name;

            // Valor
            const celdaVal = fila.insertCell(2);
            if (isEditMode || (conceptsTransport && conceptsTransport.some(c => c.concept.name === item.name))) {
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

            TotalConcepts += parseFloat(item.value || 0);
        });

        calcTotal(TotalConcepts);
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

        const idx = conceptsArray.findIndex(item => item.id === conceptId);
        if (idx !== -1) {
            conceptsArray[idx].value = value;
        } else {
            conceptsArray.push({
                id: conceptId,
                name: conceptName,
                value
            });
        }
        sel.value = '';
        inp.value = '';
        updateTable(conceptsArray);
    }

    function addConcept(buton) {
        let divConcepts = $('.formConcepts');
        const inputs = divConcepts.find('input, select');

        inputs.each(function() {
            if ($(this).val() === '') {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        var camposInvalidos = divConcepts.find('.is-invalid').length;

        if (camposInvalidos === 0) {
            const index = conceptsArray.findIndex(item => item.id === parseInt(inputs[0].value));

            if (index !== -1) {
                conceptsArray[index] = {
                    id:    parseInt(inputs[0].value),
                    name:  inputs[0].options[inputs[0].selectedIndex].text,
                    value: formatValue(inputs[1].value),
                };
            } else {
                conceptsArray.push({
                    id:    parseInt(inputs[0].value),
                    name:  inputs[0].options[inputs[0].selectedIndex].text,
                    value: formatValue(inputs[1].value),
                });
            }

            updateTable(conceptsArray);

            inputs[0].value = '';
            inputs[1].value = '';
            inputs[2].value = '';
        }
    }

    // —– INICIALIZACIÓN & HOOKS —–
    $(document).ready(function() {
        // reiniciamos el array y demás
        conceptsArray    = [];
        conceptsTransport = null;
        total = 0;

        // Carga inicial de conceptos desde PHP
        @if (isset($formMode) && $formMode === 'edit')
            @if (isset($transport->concepts))
                @json($transport->concepts).forEach(concept => {
                    conceptsArray.push({
                        id: concept.concepts_id,
                        name: concept.concept.name,
                        value: formatValue(concept.net_amount_response || 0),
                    });
                });
            @endif
        @else
            conceptsTransport = @json($conceptsTransport);
            conceptsTransport.sort((a, b) => {
                const A = (a.concept.name || '').toUpperCase();
                const B = (b.concept.name || '').toUpperCase();
                if (A === 'TRANSPORTE') return -1;
                if (B === 'TRANSPORTE') return 1;
                return A.localeCompare(B);
            });
            conceptsTransport.forEach(concept => {
                conceptsArray.push({
                    id: concept.concepts_id,
                    name: concept.concept.name,
                    value: formatValue(concept.pivot.net_amount_response || 0),
                });
            });
        @endif

        // Poblamos la tabla por primera vez
        updateTable(conceptsArray);

        // Manejador de submit
        $('#formTransport').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const jsonConcepts = JSON.stringify(conceptsArray);

            form.append(`<input type="hidden" name="concepts" value='${jsonConcepts}' />`);

            const totalPricesUsd      = parseFloat($('#totalRespuesta').val().replace(/,/g, ''))      || 0;
            const totalTransportValue = parseFloat($('#total').val().replace(/,/g, ''))               || 0;
            const profitValue         = parseFloat($('#gananciaCalculada').val().replace(/,/g, ''))   || 0;


            form.append(`<input type="hidden" name="total_transport_value" value='${totalTransportValue.toFixed(2)}' />`);
            form.append(`<input type="hidden" name="profit"                value='${profitValue.toFixed(2)}' />`);

            form.off('submit').submit();
        });
    });
</script>
@endpush

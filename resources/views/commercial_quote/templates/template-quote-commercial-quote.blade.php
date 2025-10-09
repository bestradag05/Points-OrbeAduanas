<div class="col-12">

    <h4 class="text-indigo text-center text-bold text-uppercase my-4">Cotizaciones </h4>


    <div class="col-4 offset-4">

        {{--         @if ($comercialQuote->state === 'Pendiente') --}}

        {{--             <div class="form-group row">
                <label class="col-sm-4 col-form-label">Agregar Cotizacion : </label>
                <div class="col-sm-8">
                    <select name="type_quote_service" id="type_quote_service" class="form-control"
                        onchange="createTypeQuote(this)">
                        <option disabled selected></option>
                        @if ($comercialQuote->quote_freight()->exists())
                            <option value="Flete" disabled>Flete</option>
                        @else
                            <option value="Flete">Flete</option>
                        @endif

                        @if ($comercialQuote->quote_transport()->whereNotIn('state', ['Rechazado', 'Anulado'])->exists())
                            <option value="Transporte" disabled>Transporte</option>
                        @else
                            <option value="Transporte">Transporte</option>
                        @endif

                    </select>


                </div>

            </div> --}}

        {{--         @endif --}}



    </div>

    {{-- Tabla para cotizaciones de flete --}}
    @if ($comercialQuote->quote_freight()->exists())
        <div class="col-12 mt-4">
            <h5 class="text-indigo  text-center">Flete</h5>

            <table class="table table-sm text-sm">
                <thead class="thead-dark">
                    <th>#</th>
                    <th>N° cotizacion</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Producto</th>
                    <th class="{{ $comercialQuote->type_shipment->name === 'Marítima' ? '' : 'd-none' }}">
                        LCL / FCL</th>
                    <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Volumen</th>
                    <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Peso</th>
                    <th>N° de operacion</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>
                <tbody>


                    @foreach ($comercialQuote->quote_freight as $quote)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $quote->nro_quote }}</td>
                            <td>{{ $quote->origin }}</td>
                            <td>{{ $quote->destination }}</td>
                            <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                {{ $quote->commodity }}</td>
                            <td class="{{ $comercialQuote->type_shipment->name === 'Marítima' ? '' : 'd-none' }}">
                                {{ $quote->commercial_quote->lcl_fcl }}</td>
                            <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                {{ $quote->volumen_kgv }} {{ $quote->unit_of_volumen_kgv }}</td>
                            <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                {{ $quote->weight }} {{ $quote->unit_of_weight }}</td>
                            <td>{{ $quote->nro_quote_commercial }}</td>
                            <td>{{ \Carbon\Carbon::parse($quote->created_at)->format('d/m/Y') }}</td>
                            <td>
                                <div class="custom-badge status-{{ strtolower($quote->state) }}">
                                    {{ $quote->state }}
                                </div>
                            </td>


                            <td style="width: 150px">
                                <select name="acction_transport" class="form-control form-control-sm"
                                    onchange="changeAcction(this, {{ $quote }}, 'Flete')">
                                    <option value="" disabled selected>Seleccione una acción...</option>
                                    <option>Detalle</option>
                                    <option class="{{ $quote->state != 'Pendiente' ? 'd-none' : '' }}">Anular
                                    </option>
                                    @if ($comercialQuote->state === 'Pendiente')
                                        <option class="{{ $quote->state != 'Aceptado' ? 'd-none' : '' }}">Rechazar
                                        </option>
                                    @endif
                                </select>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    @endif


    {{-- Tabla para cotizaciones de Transporte --}}
    @if ($comercialQuote->quote_transport()->exists())
        <div class="col-12 mt-4">
            <h5 class="text-indigo text-center">Transporte</h5>

            <table class="table table-sm text-sm">
                <thead class="thead-dark">
                    <th>#</th>
                    <th>N° cotizacion</th>
                    <th>Recojo</th>
                    <th>Entrega</th>
                    <th class="{{ $comercialQuote->type_shipment->name === 'Marítima' ? '' : 'd-none' }}">
                        LCL / FCL</th>
                    <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Volumen</th>
                    <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Peso</th>
                    <th>N° de operacion</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>
                <tbody>

                    @foreach ($comercialQuote->quote_transport as $quote)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $quote->nro_quote }}</td>
                            <td>
                                {!! $quote->pick_up
                                    ? e($quote->pick_up)
                                    : ($quote->pickupWarehouse && $quote->pickupWarehouse->name_businessname
                                        ? e($quote->pickupWarehouse->name_businessname)
                                        : '<span class="text-muted">Falta información</span>') !!}
                            </td>
                            <td>{!! $quote->delivery
                                ? e($quote->delivery)
                                : ($quote->deliveryWarehouse && $quote->deliveryWarehouse->name_businessname
                                    ? e($quote->deliveryWarehouse->name_businessname)
                                    : '<span class="text-muted">Falta información</span>') !!}</td>
                            <td class="{{ $comercialQuote->type_shipment->name === 'Marítima' ? '' : 'd-none' }}">
                                {{ $quote->commercial_quote->lcl_fcl }}
                            </td>
                            <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                {{ $quote->volumen_kgv }} {{ $quote->unit_of_volumen_kgv }}
                            </td>
                            <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                {{ $quote->weight }} {{ $quote->unit_of_weight }}
                            </td>
                            <td>{{ $quote->nro_quote_commercial }}</td>
                            <td>{{ \Carbon\Carbon::parse($quote->created_at)->format('d/m/Y') }}</td>
                            <td>
                                <div class="custom-badge status-{{ strtolower($quote->state) }}">
                                    {{ $quote->state }}
                                </div>
                            </td>
                            <td style="width: 150px">
                                <select name="acction_transport" class="form-control form-control-sm"
                                    onchange="changeAcction(this, {{ $quote }}, 'Transporte')">
                                    <option value="">Acciones</option>

                                    {{-- Mostrar "Detalle" solo si NO está anulada/rechazada --}}
                                    @if (!in_array($quote->state, ['Anulado', 'Rechazado']))
                                        <option value="Detalle">Detalle</option>
                                    @endif

                                    {{-- Anular solo cuando esté Pendiente (ajusta a tu regla) --}}
                                    @if ($quote->state === 'Pendiente')
                                        <option value="Anular">Anular</option>
                                    @endif

                                    {{-- Rechazar solo cuando aplique en tu flujo (ajusta si difiere) --}}
                                    @if (in_array($quote->state, ['Respondido', 'Aceptado']))
                                        <option value="Rechazar">Rechazar</option>
                                    @endif
                                </select>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    @endif


</div>


{{-- Modal para completar informacion del transporte --}}

<div id="modalTransport" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTransport-title"
    aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" id="formQuoteTransport">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTransport-title">Cotización de transporte</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-warning text-center">Para completar la cotizacion de transporte, por favor brinde la
                        siguiente información: </p>

                    <div class="row mb-3">
                        <div class="col-12">

                            <label for="pickup_warehouse">Dirección de Recojo:</label>
                        </div>
                        <div class="col-12 row">

                            <div class="col-8">

                                <!-- Lista de almacenes -->
                                <select id="pickup_warehouse" class="form-control" name="pickup_warehouse">
                                    <option value="">Seleccione una dirección...</option>
                                    @foreach ($warehouses as $warehouse)
                                        @if ($comercialQuote->type_shipment->name === $warehouse->warehouses_type)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name_businessname }} -
                                                {{ $warehouse->ruc }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <!-- Campo para dirección personalizada que se muestra cuando se selecciona "Otra Dirección" -->

                                <input id="pickup" class="form-control d-none" type="text" name="pickup">

                            </div>
                            <div class="col-4">
                                <!-- Checkbox para elegir "Otra Dirección" -->
                                <div class="input-group-append mx-5">
                                    <div class="form-check">
                                        <input type="checkbox" id="other_pickup" class="form-check-input"
                                            onchange="togglePickUpAddress()">
                                        <label class="form-check-label" for="other_pickup">Otra Dirección</label>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="row mb-3">
                        <div class="col-12">

                            <label for="delivery">Dirección de entrega:</label>
                        </div>
                        <div class="col-12 row">

                            <div class="col-8">

                                <!-- Lista de almacenes -->
                                <select id="delivery_warehouse" class="form-control" name="delivery_warehouse">
                                    <option value="">Seleccione una dirección...</option>
                                    @foreach ($warehouses as $warehouse)
                                        @if ($comercialQuote->type_shipment->name === $warehouse->warehouses_type)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->name_businessname }} -
                                                {{ $warehouse->ruc }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <!-- Campo para dirección personalizada que se muestra cuando se selecciona "Otra Dirección" -->

                                <input id="delivery" class="form-control d-none" type="text" name="delivery">

                            </div>
                            <div class="col-4">
                                <!-- Checkbox para elegir "Otra Dirección" -->
                                <div class="input-group-append mx-5">
                                    <div class="form-check">
                                        <input type="checkbox" id="other_delivery" class="form-check-input"
                                            onchange="toggleDeliveryAddress()">
                                        <label class="form-check-label" for="other_delivery">Otra Dirección</label>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div class="form-group" id="container_return">
                        <label for="container_return">Devolución de contenedor</label>
                        <select id="container_return" class="form-control" name="container_return">
                            <option value="">Seleccione una opcion...</option>
                            @foreach ($warehouses as $warehouse)
                                @if ($comercialQuote->type_shipment->name === $warehouse->warehouses_type)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name_businessname }} -
                                        {{ $warehouse->ruc }}</option>
                                @endif
                            @endforeach
                        </select>

                    </div>


                    <div class="form-group row" id="container-stackable">
                        <label for="stackable" class="col-sm-4 col-form-label">Apilable</label>
                        <div class="col-sm-8">
                            <div class="form-check d-inline">
                                <input type="radio" id="radioStackable" name="stackable" value="SI"
                                    class="form-check-input">
                                <label for="radioStackable" class="form-check-label">
                                    SI
                                </label>
                            </div>
                            <div class="form-check d-inline">
                                <input type="radio" id="radioStackable" name="stackable" value="NO"
                                    class="form-check-input">
                                <label for="radioStackable" class="form-check-label">
                                    NO
                                </label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="conceptsTransportModal" name="conceptsTransportModal" />

                    <!-- Nuevo bloque de conceptos de transporte -->
                    <div id="formConceptsTransport" class="formConcepts row mt-4 align-items-center">
                        <div class="col-md-8">
                            <label for="concept">Conceptos</label>
                            <button class="btn btn-indigo btn-xs" type="button"
                                onclick="openModalConcept('modalTransport', 'modalAddConcept')">
                                <i class="fas fa-plus"></i>
                            </button>
                            :
                            <x-adminlte-select2 name="concept" id="concept_transport"
                                data-placeholder="Seleccione un concepto...">
                                <option />
                                @foreach ($concepts as $concept)
                                    @if (
                                        $concept->typeService->name == 'Transporte' &&
                                            $comercialQuote->type_shipment->id == $concept->id_type_shipment &&
                                            $concept->name != 'TRANSPORTE')
                                        <option value="{{ $concept->id }}">
                                            {{ $concept->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </x-adminlte-select2>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" class="btn btn-indigo btn-sm mt-3  w-100"
                                onclick="addConceptQuoteTransport()">
                                <i class="fas fa-plus-circle"></i> Agregar
                            </button>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="list-group" id="conceptsList">
                                <div
                                    class="list-group-item bg-light d-flex justify-content-between align-items-center">
                                    <div class="fw-bold">Conceptos a cotizar</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="submitTransport(event)" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modalAddConcept" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalAddConceptTitle"
    aria-hidden="true">
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
                                id="name" name="name" placeholder="Ingrese el nombre" value="">
                        </div>
                        <div class="col-md-6">
                            <x-adminlte-select2 name="id_type_shipment" label="Tipo de embarque" igroup-size="md"
                                readonly="true" data-placeholder="Selecciona una opcion...">
                                <option />
                                @foreach ($typeShipments as $typeShipment)
                                    <option value="{{ $typeShipment->id }}"
                                        {{ $quote->commercial_quote->type_shipment->name === $typeShipment->name ? 'selected' : '' }}>
                                        {{ $typeShipment->name }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>

                        </div>
                        <div class="col-md-6">
                            <x-adminlte-select2 name="id_type_service" label="Tipo de servicio" igroup-size="md"
                                readonly="true" data-placeholder="Selecciona una opcion...">
                                <option />
                                @foreach ($typeServices as $typeService)
                                    <option value="{{ $typeService->id }}"
                                        {{ $typeService->name === 'Transporte' ? 'selected' : '' }}>
                                        {{ $typeService->name }}
                                    </option>
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        onclick="closeToModalAddConcept('modalTransport', 'modalAddConcept')">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="saveConceptToDatabase()">Guardar
                        Concepto</button>
                </div>
            </form>
        </div>
    </div>
</div>



@push('scripts')
    <script>
        let conceptosQuoteTransport = [];
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar select2 dentro del modal
            $('#modalTransport').on('shown.bs.modal', function() {
                $('#concept_transport').select2();
            });

            // Manejar el cierre del modal
            $('#modalTransport').on('hidden.bs.modal', function(e) {
                // Resetear variables
                conceptsArray = {};
                TotalConcepts = 0;
                total = 0;
                flete = 0;
                value_insurance = 0;
                valuea_added_insurance = 0;
                countConcepts = 0;

                // Limpiar componentes
                $('#tbodyFlete').empty();
                $('#formConceptsTransport form')[0]?.reset();
                $('#concept_transport').val(null).trigger('change');
                $('#total').val('0.00');
            });

            // Formateador de moneda
            $('.CurrencyInput').on('blur', function() {
                const value = parseFloat($(this).val().replace(/[^0-9.]/g, ''));
                $(this).val(isNaN(value) ? '0.00' : value.toFixed(2));
            });
        });

        // Función para agregar conceptos (implementación básica)
        function addConcept() {
            // Obtener elementos del DOM correctamente
            const conceptSelect = $('#concept_transport');
            const baseValueInput = $('#value_concept');
            const addedValueInput = $('#value_added');
            const tbody = $('#conceptsTable tbody');

            // Validar campos requeridos
            if (conceptSelect.val() === '' || baseValueInput.val() === '') {
                alert('¡Complete los campos obligatorios!');
                return;
            }

            // Calcular puntos (1 punto por cada $40)
            const addedValue = parseFloat(addedValueInput.val()) || 0;
            const points = Math.floor(addedValue / 40);

            // Crear nueva fila
            const newRow = `
        <tr>
            <td>${tbody.children().length + 1}</td>
            <td>${conceptSelect.find('option:selected').text()}</td>
            <td>${parseFloat(baseValueInput.val()).toFixed(2)}</td>
            <td>${addedValue.toFixed(2)}</td>
            <td>${points}</td>
            <td>
                <button class="btn btn-sm btn-danger" onclick="$(this).closest('tr').remove()">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>`;

            // Agregar a la tabla
            tbody.append(newRow);

            // Limpiar campos
            conceptSelect.val('').trigger('change');
            baseValueInput.val('');
            addedValueInput.val('0.00');
        }

        function addConceptQuoteTransport() {
            const select = $('#concept_transport');
            const selectedOption = select.find('option:selected');

            if (!selectedOption.val()) {
                alert('Seleccione un concepto válido');
                return;
            }


            const concepto = {
                id: selectedOption.val(),
                nombre: selectedOption.text().trim()

            };

            // Verificar si el concepto ya fue agregado
            if (conceptosQuoteTransport.some(c => c.id === concepto.id)) {
                alert('Este concepto ya fue agregado');
                return;
            }

            conceptosQuoteTransport.push(concepto);
            updateConceptList();
            select.val('').trigger('change');
        }


        function updateConceptList() {
            const list = $('#conceptsList');
            list.empty();

            $('#conceptsTransportModal').val(JSON.stringify(conceptosQuoteTransport));

            // Header
            list.append(`
            <div class="list-group-item bg-light fw-bold">
                Conceptos a cotizar (${conceptosQuoteTransport.length})
            </div>
        `);

            // Items
            conceptosQuoteTransport.forEach((concepto, index) => {
                list.append(`
                <div class="list-group-item d-flex justify-content-between align-items-center" 
                     data-id="${concepto.id}">
                    <div>
                        <span class="me-2">${index + 1}.</span>
                        ${concepto.nombre}
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" 
                            onclick="deleteQuoteTransport(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <input type="hidden" />
                

            `);
            });
        }


        function deleteQuoteTransport(index) {
            conceptosQuoteTransport.splice(index, 1);
            updateConceptList();
        }



        function updateTable(conceptsArray, idContent, cost_transport = null) {
            let tbodyRouting = $(`#${idContent}`).find('tbody')[0];
            tbodyRouting.innerHTML = '';
            TotalConcepts = 0;

            let contador = 0;

            for (let clave in conceptsArray) {
                let item = conceptsArray[clave];
                if (conceptsArray.hasOwnProperty(clave)) {
                    contador++;

                    // ... (código para crear filas)

                    // Cálculo de puntos
                    let maxPoints = Math.floor(item.added / 45); // Cambiar 45 por 40 según requerimiento
                    inputPA.max = maxPoints;

                    // Manejo de eventos para puntos
                    inputPA.addEventListener('input', (e) => {
                        conceptsArray[clave].pa = e.target.value;
                        updateTotals();
                    });
                }
            }
            calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, container.id);
        }
        // Actualizar total
        function updateTotal() {
            let sum = 0;
            $('#tbodyFlete tr').each(function() {
                sum += parseFloat($(this).find('td:eq(2)').text()) + parseFloat($(this).find('td:eq(3)').text());
            });
            $('#total').val(sum.toFixed(2));
        }


        function calcTotal(TotalConcepts, flete, value_insurance, valuea_added_insurance, idContent) {
            // Calcular puntos totales
            let totalPuntos = Object.values(conceptsArray).reduce((acc, concept) => {
                return acc + parseInt(concept.pa || 0);
            }, 0);

            // Actualizar campo de puntos
            $(`#${idContent} #total-points`).val(totalPuntos);

            // Calcular total monetario
            total = TotalConcepts + flete + value_insurance + valuea_added_insurance;
            $(`#${idContent} #total`).val(total.toFixed(2));
        }



        //Ejecutar acciones de las cotizaciones

        function changeAcction(select, quote, typeQuote) {

            const actionText = select.value === 'Anular' ? 'anular' : 'rechazar';

            switch (select.value) {
                case 'Detalle':
                    // Para ver el detalle
                    if (typeQuote === 'Transporte') {
                        if ((!quote.pick_up && !quote.pickup_warehouse) || (!quote.delivery && !quote.delivery_warehouse)) {
                            openModalTransport(quote);
                        } else {
                            window.location.href = `/quote/transport/${quote.id}`;
                        }
                    } else {
                        window.location.href = `/quote/freight/${quote.id}`;
                    }
                    break;

                case 'Anular':

                    toggleAction(actionText, quote, typeQuote);
                    break;


                case 'Rechazar': // Puedes agrupar ambos si tienen una lógica similar

                    toggleAction(actionText, quote, typeQuote);
                    break;

                default:
                    console.warn("Acción no reconocida:", select.value);
            }

        }


        function toggleAction(actionText, quote, typeQuote) {


            Swal.fire({
                title: `¿Seguro que deseas ${actionText} la cotización ${quote.nro_quote}?`,
                text: "Esta acción cambiará el estado de la cotización.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: `Sí, ${actionText}`,
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: typeQuote === 'Flete' ?
                            `/quote/freight/${quote.id}/${actionText}` :
                            `/quote/transport/${quote.id}/${actionText}`,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        dataType: "JSON",
                        success: function(response) {
                            Swal.fire({
                                title: `${response.message}`,
                                icon: "success",
                                allowOutsideClick: false
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });


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



        function openModalTransport(quote) {
            let modalTransport = $('#modalTransport');

            $('#modalTransport form').attr('action', '/quote/transport/complete/' + quote.id);

            if (quote.lcl_fcl != 'FCL') {
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
                        $('#concept_transport').append(newOption).trigger('change');

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



        function togglePickUpAddress() {
            var checkBox = document.getElementById('other_pickup');
            var selectField = document.getElementById('pickup_warehouse');
            var customField = document.getElementById('pickup');

            if (checkBox.checked) {
                selectField.classList.remove('d-block'); // Ocultar la lista de almacenes
                selectField.classList.add('d-none');

                customField.classList.remove('d-none'); // Mostrar el campo para dirección personalizada
                customField.classList.add('d-block');
                selectField.value = '';
            } else {
                selectField.classList.remove('d-none'); // Mostrar la lista de almacenes
                selectField.classList.add('d-block');

                customField.classList.remove('d-block'); // Ocultar el campo para dirección personalizada
                customField.classList.add('d-none');

                customField.value = '';
            }
        }

        // Función para mostrar u ocultar el campo de dirección personalizada para Entrega
        function toggleDeliveryAddress() {
            var checkBox = document.getElementById('other_delivery');
            var selectField = document.getElementById('delivery_warehouse');
            var customField = document.getElementById('delivery');

            if (checkBox.checked) {
                selectField.classList.remove('d-block'); // Ocultar la lista de almacenes
                selectField.classList.add('d-none');

                customField.classList.remove('d-none'); // Mostrar el campo para dirección personalizada
                customField.classList.add('d-block');
                selectField.value = '';
            } else {
                selectField.classList.remove('d-none'); // Mostrar la lista de almacenes
                selectField.classList.add('d-block');

                customField.classList.remove('d-block'); // Ocultar el campo para dirección personalizada
                customField.classList.add('d-none');

                customField.value = '';
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

        function hideError(input) {
            let errorSpan = input.nextElementSibling;
            if (errorSpan && errorSpan.classList.contains('invalid-feedback')) {
                errorSpan.style.display = 'none';

            }

        }



        //Confirmacion para crear una nueva cotizacion de Transporte - Flete

        function createTypeQuote(select) {

            let nro_quote_commercial = @json($comercialQuote->nro_quote_commercial);

            Swal.fire({
                title: `Crearas una cotizacion para ${select.value}`,
                text: "Se enviara una nueva cotizacion para el area correspondiente",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, crear cotización",
                cancelButtonText: "Cancelar",
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        type: "GET",
                        url: `/commercial/createQuote/${nro_quote_commercial}`,
                        data: {
                            type_quote: select.value
                        },
                        dataType: "JSON",
                        success: function(response) {

                            Swal.fire({
                                title: `${response.message}`,
                                icon: "success",
                                allowOutsideClick: false // Evita que se cierre al hacer clic fuera
                            }).then((result) => {
                                location.reload(); // Recarga la página
                            });

                        }
                    });


                } else {
                    select.value = '';
                }


            });

        }
    </script>
@endpush

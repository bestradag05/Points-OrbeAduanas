<div class="row mt-3">
    <div class="col-6">

        <h5 class="text-indigo mb-2 text-center py-3">
            <i class="fa-regular fa-circle-info"></i>
            Información de la operacion
        </h5>

        <div class="row">

            <div class="col-12 border-bottom border-bottom-2">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nro Cotización: </label>
                    <div class="col-sm-8 d-inline">
                        <p id="nro_quote_commercial" class="form-control-plaintext text-indigo d-inline">
                            {{ $comercialQuote->nro_quote_commercial }}</p>
                        <a href="{{ url('/commercial/quote/getPDF/' . $comercialQuote->id) }}"
                            class="text-indigo d-inline">
                            <i class="fas fa-file-pdf"></i>
                        </a>

                    </div>

                </div>
            </div>

            <div class="col-12 border-bottom border-bottom-2">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Origen : </label>
                    <div class="col-sm-8">

                        <p class="form-control-plaintext">{{ $comercialQuote->origin }}</p>
                    </div>

                </div>
            </div>
            <div class="col-12 border-bottom border-bottom-2">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Destino : </label>
                    <div class="col-sm-8">

                        <p class="form-control-plaintext">{{ $comercialQuote->destination }}</p>
                    </div>

                </div>
            </div>
            <div
                class="col-12 border-bottom border-bottom-2 {{ $comercialQuote->customer_company_name ? '' : 'd-none' }}">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Cliente : </label>
                    <div class="col-sm-8">

                        <p class="form-control-plaintext">{{ $comercialQuote->customer_company_name }}</p>
                    </div>

                </div>
            </div>
            @if ($comercialQuote->is_consolidated)
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Carga Consolidada : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">SI</p>
                        </div>

                    </div>
                </div>

                @foreach ($comercialQuote->consolidatedCargos as $consolidated)
                    @php
                        $shipper = json_decode($consolidated->supplier_temp);
                        $measures = json_decode($consolidated->value_measures);
                    @endphp


                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="accordion" id="accordionConsolidated">
                            <div>
                                <h2 class="mb-0">
                                    <button
                                        class="btn btn-link btn-block px-0 text-dark text-semibold text-left d-flex align-items-center"
                                        type="button" data-toggle="collapse"
                                        data-target="#collapse{{ $consolidated->id }}" aria-expanded="true">
                                        <span class="text-indigo text-bold">Shipper {{ $loop->iteration }}</span>:
                                        {{ $shipper->shipper_name }}
                                        <i class="fas fa-sort-down mx-3"></i>
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse{{ $consolidated->id }}" class="collapse"
                                data-parent="#accordionConsolidated">

                                <div class="row text-muted px-5">
                                    <div class="col-12  {{ $shipper->shipper_name ? '' : 'd-none' }}">
                                        <p class="text-sm">Proovedor :
                                            <b class="d-block">{{ $shipper->shipper_name }}</b>
                                        </p>
                                    </div>

                                    <div class="col-4">
                                        <p class="text-sm">Contacto :
                                            <b class="d-block">{{ $shipper->shipper_contact }}</b>
                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-sm">Email :
                                            <b class="d-block">{{ $shipper->shipper_contact_email }}</b>
                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-sm">Telefono :
                                            <b class="d-block">{{ $shipper->shipper_contact_phone }}</b>
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-sm">Direccion :
                                            <b class="d-block">{{ $shipper->shipper_address }}</b>
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-sm">Descripcion de carga :
                                            <b class="d-block">{{ $consolidated->commodity }}</b>
                                        </p>
                                    </div>
                                    <div class="col-12">
                                        <p class="text-sm">Valor del producto :
                                            <b class="d-block">{{ $consolidated->load_value }}</b>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-sm">N° de Bultos :
                                            <b class="d-block">{{ $consolidated->nro_packages }}</b>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-sm">Tipo de embalaje :
                                            <b class="d-block">{{ $consolidated->packaging_type }}</b>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-sm">Volumen :
                                            <b class="d-block">{{ $consolidated->volumen }}</b>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-sm">Peso :
                                            <b class="d-block">{{ $consolidated->kilograms }}</b>
                                        </p>
                                    </div>

                                    <table class="table table-striped">
                                        <thead>
                                            <th>Cantidad</th>
                                            <th>Ancho (cm)</th>
                                            <th>Largo (cm)</th>
                                            <th>Alto (cm)</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($measures as $measure)
                                                <tr>
                                                    <td>{{ $measure->amount }}</td>
                                                    <td>{{ $measure->width }}</td>
                                                    <td>{{ $measure->length }}</td>
                                                    <td>{{ $measure->height }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Producto / Mercancía : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->commodity }}</p>
                        </div>

                    </div>
                </div>

                @if ($comercialQuote->type_shipment->description === 'Aérea')
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Peso KG : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">{{ $comercialQuote->kilograms }}</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">KGV : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">{{ $comercialQuote->kilogram_volumen }}</p>
                            </div>

                        </div>
                    </div>
                @endif

                @if ($comercialQuote->type_shipment->description === 'Marítima')
                    @if ($comercialQuote->lcl_fcl === 'FCL')
                        <div class="col-12 border-bottom border-bottom-2">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Contenedor : </label>
                                <div class="col-sm-8">

                                    <p class="form-control-plaintext">{{ $comercialQuote->container_type }}</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 border-bottom border-bottom-2">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Toneladas : </label>
                                <div class="col-sm-8">

                                    <p class="form-control-plaintext">{{ $comercialQuote->tons }}</p>
                                </div>

                            </div>
                        </div>
                    @else
                        <div class="col-12 border-bottom border-bottom-2">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Peso : </label>
                                <div class="col-sm-8">

                                    <p class="form-control-plaintext">{{ $comercialQuote->kilograms }}</p>
                                </div>

                            </div>
                        </div>
                    @endif
                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Volumen : </label>
                            <div class="col-sm-8">

                                <p class="form-control-plaintext">{{ $comercialQuote->volumen }}</p>
                            </div>

                        </div>
                    </div>

                @endif



            @endif


            <div class="col-12" id="extraFieldsOpen">
                <a class="btn btn-link btn-block text-center" data-bs-toggle="collapse" data-bs-target="#extraFields"
                    onclick="toggleArrows(true)">
                    <i class="fas fa-sort-down " id="arrowDown"></i>
                </a>
            </div>

            <div class="col-12 row collapse mt-2" id="extraFields">

                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Incoterm : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->incoterm->code }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tipo de carga : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->type_load->name }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Valor de la Carga : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">$ {{ $comercialQuote->load_value }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tipo de embarque : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">
                                {{ $comercialQuote->type_shipment->description . ($comercialQuote->type_shipment->description === 'Marítima' && $comercialQuote->lcl_fcl ? ' (' . $comercialQuote->lcl_fcl . ')' : '') }}

                            </p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Régimen : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->regime->description }}</p>
                        </div>

                    </div>
                </div>

                <div class="col-12 text-center mt-3">
                    <a class="btn btn-link text-center" data-bs-toggle="collapse" data-bs-target="#extraFields"
                        onclick="toggleArrows(false)">
                        <i class="fas fa-sort-up" id="arrowUp"></i>
                    </a>
                </div>


            </div>
        </div>

    </div>
    <div class="col-6 px-5">

        <h5 class="text-indigo mb-2 text-center py-3">
            <i class="fa-duotone fa-gear"></i>
            Servicios
        </h5>

        <select name="type_service" id="type_service" class="form-control" onchange="openModalForm(this)">
            <option></option>
            @foreach ($type_services as $type_service)
                @php
                    $disabled = false;
                    foreach ($services as $index => $service) {
                        if ($type_service->name == $index) {
                            $disabled = true;
                            break;
                        }
                    }
                @endphp
                <option value="{{ $type_service->id }}" {{ $disabled ? 'disabled' : '' }}>
                    {{ $type_service->name }}
                </option>
            @endforeach
        </select>


        <hr>
        {{-- <p class="text-indigo text-bold">Lista de Servicios: </p> --}}
        <table class="table text-center">
            <thead>
                <th class="text-indigo text-bold">Servicios</th>
                <th class="text-indigo text-bold">Seguro</th>
                <th class="text-indigo text-bold">Estado</th>
                <th class="text-indigo text-bold">Acciones</th>
            </thead>
            <tbody>

                @foreach ($services as $index => $service)
                    <tr>
                        <td>
                            <a class="btn btn-indigo w-100">
                                {{ $index }}
                            </a>
                        </td>

                        <td class="text-bold  {{ $service->insurance ? 'text-success' : 'text-danger' }}">

                            @if ($service->insurance)
                                Tiene seguro
                            @else
                                @if ($index != 'Transporte')
                                    Sin seguro
                                @else
                                    -
                                @endif
                            @endif
                        </td>
                        <td class="text-bold  status-{{ strtolower($service->state) }}">
                            {{ $service->state }}
                        </td>


                        <td>
                            <a href="{{ url('/commercial/service/' . strtolower($index). '/'. $service->id) }}" class="text-indigo"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>

    <div class="col-12">

        <h4 class="text-indigo text-center text-bold text-uppercase my-4">Cotizaciones </h4>


        <div class="col-4 offset-4">

            <div class="form-group row">
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

                        @if ($comercialQuote->quote_transport()->exists())
                            <option value="Transporte" disabled>Transporte</option>
                        @else
                            <option value="Transporte">Transporte</option>
                        @endif

                    </select>


                </div>

            </div>


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
                        <th class="{{ $comercialQuote->type_shipment->description === 'Marítima' ? '' : 'd-none' }}">
                            LCL / FCL</th>
                        <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Cubicaje-KGV</th>
                        <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Tonelada-KG</th>
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
                                <td
                                    class="{{ $comercialQuote->type_shipment->description === 'Marítima' ? '' : 'd-none' }}">
                                    {{ $quote->commercial_quote->lcl_fcl }}</td>
                                <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                    {{ $quote->cubage_kgv }}</td>
                                <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                    {{ $quote->ton_kilogram }}</td>
                                <td>{{ $quote->nro_quote_commercial }}</td>
                                <td>{{ \Carbon\Carbon::parse($quote->created_at)->format('d/m/Y') }}</td>
                                <td class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}
                                </td>


                                <td style="width: 150px">
                                    <select name="acction_transport" class="form-control form-control-sm"
                                        onchange="changeAcction(this, {{ $quote }}, 'Flete')">
                                        <option value="" disabled selected>Seleccione una acción...</option>
                                        <option>Detalle</option>
                                        <option class="{{ $quote->state != 'Pendiente' ? 'd-none' : '' }}">Anular
                                        </option>
                                        <option class="{{ $quote->state != 'Aceptado' ? 'd-none' : '' }}">Rechazar
                                        </option>
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
                        <th class="{{ $comercialQuote->type_shipment->description === 'Marítima' ? '' : 'd-none' }}">
                            LCL / FCL</th>
                        <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Cubicaje-KGV</th>
                        <th class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">Tonelada-KG</th>
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
                                <td>{!! $quote->pick_up ? e($quote->pick_up) : '<span class="text-muted">Falta información</span>' !!}</td>
                                <td>{!! $quote->delivery ? e($quote->delivery) : '<span class="text-muted">Falta información</span>' !!}</td>
                                <td
                                    class="{{ $comercialQuote->type_shipment->description === 'Marítima' ? '' : 'd-none' }}">
                                    {{ $quote->commercial_quote->lcl_fcl }}</td>
                                <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                    {{ $quote->cubage_kgv }}</td>
                                <td class="{{ $comercialQuote->is_consolidated ? 'd-none' : '' }}">
                                    {{ $quote->ton_kilogram }}</td>
                                <td>{{ $quote->nro_quote_commercial }}</td>
                                <td>{{ \Carbon\Carbon::parse($quote->created_at)->format('d/m/Y') }}</td>
                                <td class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}
                                </td>

                                <td style="width: 150px">
                                    <select name="acction_transport" class="form-control form-control-sm"
                                        onchange="changeAcction(this, {{ $quote }}, 'Transporte')">
                                        <option value="" disabled selected>Seleccione una acción...</option>
                                        <option>Detalle</option>
                                        <option class="{{ $quote->state != 'Pendiente' ? 'd-none' : '' }}">Anular
                                        </option>
                                        <option class="{{ $quote->state != 'Aceptado' ? 'd-none' : '' }}">Rechazar
                                        </option>
                                    </select>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>
        @endif


    </div>


</div>


{{-- Modal para completar informacion del transporte --}}

<div id="modalTransport" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTransport-title"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                    <div class="form-group">
                        <label for="pick_up">Dirección de Recojo:</label>
                        <input id="pick_up" class="form-control" type="text" name="pick_up">
                    </div>
                    <div class="form-group">
                        <label for="delivery">Dirección de entrega</label>
                        <input id="delivery" class="form-control" type="text" name="delivery">
                    </div>

                    <div class="form-group" id="container_return">
                        <label for="container_return">Devolución de contenedor</label>
                        <input id="container_return" class="form-control" type="text" name="container_return">
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

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="submitTransport(event)" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>



{{-- Modales de los servicios --}}


@include('commercial_quote/modals/modalFreight')
@include('commercial_quote/modals/modalCustom')
@include('commercial_quote/modals/modalTransport')

@push('scripts')
    <script>
        $('#type_service').select2({
            width: 'resolve',
            placeholder: "Seleccione una opcion...",
            allowClear: true
        });

        let TotalConcepts = 0;
        let total = 0;
        let flete = 0;
        let containerResult = '';
        let container = '';
        let typeService = '';

        function openModalForm(element) {
            let selected = element.options[element.selectedIndex].text;
            containerResult = $(`#modal${selected}`).modal('show');
            container = containerResult[0];
            typeService = element.value;
            $(`#${container.id}`).find('#typeService').val(typeService);
            element.value = '';

        }


        /* Transporte */


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


        //Confirmacion para crear una nueva cotizacion de Transporte - Flete

        function createTypeQuote(select) {

            let nro_quote_commercial = $('#nro_quote_commercial').text().trim();

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


        //Ejecutar acciones de las cotizaciones

        function changeAcction(select, quote, typeQuote) {

            const actionText = select.value === 'Anular' ? 'anular' : 'rechazar';

            switch (select.value) {
                case 'Detalle':
                    // Para ver el detalle
                    if (typeQuote === 'Transporte') {
                        if (!quote.pick_up || !quote.delivery) {
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

        function toggleArrows(isOpening) {
            var arrowDown = document.getElementById('arrowDown');
            var arrowUp = document.getElementById('arrowUp');

            if (isOpening) {
                arrowDown.style.display = 'none';
                arrowUp.style.display = 'inline';
            } else {
                arrowDown.style.display = 'inline';
                arrowUp.style.display = 'none';
            }
        }

        document.getElementById('extraFields').addEventListener('show.bs.collapse', function() {
            toggleArrows(true);
        });

        document.getElementById('extraFields').addEventListener('hide.bs.collapse', function() {
            toggleArrows(false);
        });
    </script>
@endpush

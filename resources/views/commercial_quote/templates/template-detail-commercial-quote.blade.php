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
                        <p class="form-control-plaintext text-indigo d-inline">
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
            <div class="col-12 border-bottom border-bottom-2">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Cliente : </label>
                    <div class="col-sm-8">

                        <p class="form-control-plaintext">{{ $comercialQuote->customer_company_name }}</p>
                    </div>

                </div>
            </div>
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
                @endif
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Toneladas : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->tons }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-12 border-bottom border-bottom-2">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Volumen : </label>
                        <div class="col-sm-8">

                            <p class="form-control-plaintext">{{ $comercialQuote->volumen }}</p>
                        </div>

                    </div>
                </div>
            @endif

            <div class="col-12" id="extraFieldsOpen">
                <a class="btn btn-link btn-block text-center" data-bs-toggle="collapse" data-bs-target="#extraFields">
                    <i class="fas fa-sort-down fa-lg"></i>
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
                                {{ $comercialQuote->type_shipment->description . ' (' . ($comercialQuote->type_shipment->description === 'Marítima' ? $comercialQuote->lcl_fcl : '') . ')' }}
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
                    <a class="btn btn-link text-center" data-bs-toggle="collapse" data-bs-target="#extraFields">
                        <i class="fas fa-sort-up"></i>
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
                                    <button type="button" class="btn text-indigo"
                                        onclick="openModalInsurance('{{ $service }}', '{{ $index }}')">

                                        <i class="fas fa-plus"></i>
                                    @else
                                        -
                                @endif
                                </button>
                            @endif
                        </td>
                        <td class="text-bold  {{ $service->state == 'Pendiente' ? 'text-danger' : 'text-success' }}">
                            {{ $service->state }}
                        </td>


                        <td>
                            <a href="#"></a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
    {{-- Tabla para cotizaciones de flete --}}
    @if ($comercialQuote->quote_freight()->exists())
        <div class="col-12 mt-4">
            <h6 class="text-indigo text-uppercase text-center text-bold">Cotizacion de flete</h6>

            <table class="table table-sm text-sm">
                <thead class="thead-dark">
                    <th>#</th>
                    <th>N° cotizacion</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Producto</th>
                    <th>LCL / FCL</th>
                    <th>Cubicaje-KGV</th>
                    <th>Tonelada-KG</th>
                    <th>N° de operacion</th>
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
                            <td>{{ $quote->commodity }}</td>
                            <td>{{ $quote->commercial_quote->lcl_fcl }}</td>
                            <td>{{ $quote->cubage_kgv }}</td>
                            <td>{{ $quote->ton_kilogram }}</td>
                            <td>{{ $quote->nro_quote_commercial }}</td>
                            <td class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}
                            </td>


                            <td>
                                <a href="{{ url('/quote/freight/' . $quote->id) }}"
                                    class="btn btn-outline-indigo btn-sm mb-2 ">
                                    Detalle
                                </a>
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
            <h6 class="text-indigo text-uppercase text-center text-bold">Cotizacion de transporte</h6>

            <table class="table table-sm text-sm">
                <thead class="thead-dark">
                    <th>#</th>
                    <th>N° cotizacion</th>
                    <th>Cliente</th>
                    <th>Recojo</th>
                    <th>Entrega</th>
                    <th>LCL / FCL</th>
                    <th>Cubicaje-KGV</th>
                    <th>Tonelada-KG</th>
                    <th>N° de operacion</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>
                <tbody>

                    @foreach ($comercialQuote->quote_transport as $quote)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $quote->nro_quote }}</td>
                            <td>{{ $quote->commercial_quote->customer_company_name }}</td>
                            <td>{!! $quote->pick_up ? e($quote->pick_up) : '<span class="text-muted">Falta información</span>' !!}</td>
                            <td>{!! $quote->delivery ? e($quote->delivery) : '<span class="text-muted">Falta información</span>' !!}</td>
                            <td>{{ $quote->commercial_quote->lcl_fcl }}</td>
                            <td>{{ $quote->cubage_kgv }}</td>
                            <td>{{ $quote->ton_kilogram }}</td>
                            <td>{{ $quote->nro_quote_commercial }}</td>
                            <td class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}
                            </td>

                            @if (!$quote->pick_up || !$quote->delivery)
                                <td>
                                    <button type="button" class="btn btn-outline-indigo btn-sm mb-2"
                                        onclick="openModalTransport('{{ $quote }}')">
                                        Detalle
                                    </button>
                                </td>
                            @else
                                <td>
                                    <a href="{{ url('/quote/transport/' . $quote->id) }}"
                                        class="btn btn-outline-indigo btn-sm mb-2 ">
                                        Detalle
                                    </a>
                                </td>
                            @endif

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

                    <div class="form-group row">
                        <label for="gang" class="col-sm-4 col-form-label">Cuadrilla</label>
                        <div class="col-sm-8 row align-items-center">
                            <div class="form-check d-inline mx-2">
                                <input type="radio" id="radioGang" name="gang" value="SI"
                                    class="form-check-input">
                                <label for="radioGang" class="form-check-label">
                                    SI
                                </label>
                            </div>
                            <div class="form-check d-inline mx-2">
                                <input type="radio" id="radioGang" name="gang" value="NO"
                                    class="form-check-input">
                                <label for="radioGang" class="form-check-label">
                                    NO
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row" id="container-guard">
                        <label for="guard" class="col-sm-4 col-form-label">Resguardo</label>
                        <div class="col-sm-8">
                            <div class="form-check d-inline">
                                <input type="radio" id="radioGuard" name="guard" value="SI"
                                    class="form-check-input">
                                <label for="radioGuard" class="form-check-label">
                                    SI
                                </label>
                            </div>
                            <div class="form-check d-inline">
                                <input type="radio" id="radioGuard" name="guard" value="NO"
                                    class="form-check-input">
                                <label for="radioGuard" class="form-check-label">
                                    NO
                                </label>
                            </div>
                        </div>
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

        let conceptsArray = {};
        let TotalConcepts = 0;
        let total = 0;
        let flete = 0;
        let value_insurance = 0;
        let valuea_added_insurance = 0;
        let countConcepts = 0;
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
    </script>
@endpush

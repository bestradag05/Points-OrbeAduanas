@extends('home')


@section('dinamic-content')

    <div class="row p-3">

        <div class="col-12 col-md-12 col-lg-6 px-4">

            <div class="row align-items-center">
                <div class="col-8 col-lg-6">
                    <h5 class="text-indigo text-center"> <i class="fas fa-file-alt mx-2"></i>Detalle de carga</h5>
                </div>
                {{--  @role('pricing') --}}
                <div class="col-4 col-lg-6">
                    <button onclick="copieHtmlDetailQuote()" class="btn btn-sm btn-secondary">
                        <i class="fas fa-copy"></i>
                    </button>
                    <button onclick="downloadImageDetailQuote('{{ $quote->nro_quote }}')" class="btn btn-sm btn-secondary">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
                {{-- @endrole --}}
            </div>


            <br>

            <div class="row text-muted">
                <div class="col-6">
                    <p class="text-sm">N° Cotizacion General :
                        <b class="d-block"><a
                                href="{{ url('/commercial/quote/' . $quote->commercial_quote->id . '/detail') }}">
                                {{ $quote->nro_quote_commercial }}
                            </a></b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">N° Cotizacion Flete :
                        <b class="d-block">{{ $quote->nro_quote }}</b>
                    </p>
                </div>
                <div class="col-6 {{ $quote->commercial_quote->customer_company_name ? '' : 'd-none' }}">
                    <p class="text-sm">Cliente :
                        <b class="d-block">{{ $quote->commercial_quote->customer_company_name }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Origen :
                        <b class="d-block">{{ $quote->origin }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Destino :
                        <b class="d-block">{{ $quote->destination }}</b>
                    </p>
                </div>

                <div class="col-6">
                    <p class="text-sm">Tipo de embarque :
                        <b class="d-block">{{ $quote->commercial_quote->type_shipment->description }}
                            {{ $quote->commercial_quote->lcl_fcl != null ? '(' . $quote->commercial_quote->lcl_fcl . ')' : '' }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Tipo de carga :
                        <b class="d-block">{{ $quote->load_type }}</b>
                    </p>
                </div>
            </div>

            @if ($quote->commercial_quote->is_consolidated)
                <div class="row text-muted">
                    <div class="col-6">
                        <p class="text-sm">Consolidado :
                            <b class="d-block"> SI </b>
                        </p>
                    </div>
                </div>

                <h5 class="text-center text-indigo" style="text-decoration: underline;  text-underline-offset: 4px;">Detalle
                    de consolidado</h5>

                @foreach ($quote->commercial_quote->consolidatedCargos as $consolidated)
                    @php
                        $shipper = json_decode($consolidated->supplier_temp);
                        $measures = json_decode($consolidated->value_measures);
                    @endphp


                    <div class="col-12 border-bottom border-bottom-2">
                        <div class="accordion" id="accordionConsolidated">
                            <div>
                                <h2 class="mb-0">
                                    <button
                                        class="btn btn-link btn-block px-0 text-muted text-semibold text-left d-flex align-items-center"
                                        type="button" data-toggle="collapse"
                                        data-target="#collapse{{ $consolidated->id }}" aria-expanded="true">
                                        <span class="text-indigo">Shipper {{ $loop->iteration }}</span>:
                                        {{ $shipper->shipper_name }}
                                        <i class="fas fa-sort-down mx-3"></i>
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse{{ $consolidated->id }}" class="collapse"
                                data-parent="#accordionConsolidated">

                                <div class="row text-muted px-5">
                                    <div class="col-6  {{ $shipper->shipper_name ? '' : 'd-none' }}">
                                        <p class="text-sm">Proovedor :
                                            <b class="d-block">{{ $shipper->shipper_name }}</b>
                                        </p>
                                    </div>

                                    <div class="col-6">
                                        <p class="text-sm">Contacto :
                                            <b class="d-block">{{ $shipper->shipper_contact }}</b>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="text-sm">Email :
                                            <b class="d-block">{{ $shipper->shipper_contact_email }}</b>
                                        </p>
                                    </div>
                                    <div class="col-6">
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
                                            <b class="d-block">{{ $consolidated->packingType->name }}</b>
                                        </p>
                                    </div>
                                    @if ($consolidated->commercialQuote->type_shipment->description === 'Marítima')
                                        <div class="col-6">
                                            <p class="text-sm">Volumen :
                                                <b class="d-block">{{ $consolidated->volumen }} CBM</b>
                                            </p>
                                        </div>
                                    @else
                                        <div class="col-6">
                                            <p class="text-sm">KGV :
                                                <b class="d-block">{{ $consolidated->kilogram_volumen }} KGV</b>
                                            </p>
                                        </div>
                                    @endif

                                    <div class="col-6">
                                        <p class="text-sm">Peso :
                                            <b class="d-block">{{ $consolidated->kilograms }}</b>
                                        </p>
                                    </div>
                                    @if ($measures)
                                        <table class="table table-striped">
                                            <thead>
                                                <th>Cantidad</th>
                                                <th>Ancho</th>
                                                <th>Largo</th>
                                                <th>Alto</th>
                                                <th>Unidad</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($measures as $measure)
                                                    <tr>
                                                        <td>{{ $measure->amount }}</td>
                                                        <td>{{ $measure->width }}</td>
                                                        <td>{{ $measure->length }}</td>
                                                        <td>{{ $measure->height }}</td>
                                                        <td>{{ $measure->unit_measurement }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="row text-muted">
                    <div class="col-6">
                        <p class="text-sm">Descripcion :
                            <b class="d-block">{{ $quote->commodity }}</b>
                        </p>
                    </div>


                    @if ($quote->commercial_quote->type_shipment->description === 'Marítima')


                        <div class="col-6">
                            <p class="text-sm">Volumen :
                                <b class="d-block">{{ $quote->cubage_kgv }} CBM</b>
                            </p>
                        </div>

                        @if ($quote->commercial_quote->lcl_fcl === 'FCL')
                            <div class="col-12">
                                <p class="text-sm">Contenedor(s) :
                                <div class="d-flex flex-wrap">
                                    @foreach ($quote->commercial_quote->commercialQuoteContainers as $commercialContainer)
                                        <ul class="list-group list-group-flush text-bold d-inline-block mr-3">
                                            <li class="list-group-item pl-0 pt-2">
                                                {{ $commercialContainer->container_quantity }} x
                                                {{ $commercialContainer->container->name }}
                                                <button class="btn text-primary" data-toggle="modal"
                                                    data-target="#detailContainer"
                                                    data-commercialcontainer="{{ json_encode($commercialContainer) }}">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    @endforeach
                                </div>
                                </p>
                            </div>
                        @else
                            <div class="col-6">
                                <p class="text-sm">Tipo de embalaje :
                                    <b class="d-block">{{ $quote->packaging_type }}</b>
                                </p>
                            </div>
                            <div class="col-6">
                                <p class="text-sm">Peso total :
                                    <b class="d-block">{{ $quote->ton_kilogram }} KG</b>
                                </p>
                            </div>
                        @endif
                    @else
                        <div class="col-6">
                            <p class="text-sm">Kilogramo / KGV :
                                <b class="d-block">{{ $quote->cubage_kgv }} KGV</b>
                            </p>
                        </div>

                        <div class="col-6">
                            <p class="text-sm">Peso total :
                                <b class="d-block">{{ $quote->ton_kilogram }} KG</b>
                            </p>
                        </div>

                    @endif

                </div>




                @if ($quote->commercial_quote->measures)

                    <div class="col-6">
                        <p class="text-sm">Medidas : </p>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <th>Cantidad</th>
                            <th>Ancho</th>
                            <th>Largo</th>
                            <th>Alto</th>
                            <th>Unidad</th>
                        </thead>
                        <tbody>
                            @foreach (json_decode($quote->commercial_quote->measures) as $measure)
                                <tr>
                                    <td>{{ $measure->amount }}</td>
                                    <td>{{ $measure->width }}</td>
                                    <td>{{ $measure->length }}</td>
                                    <td>{{ $measure->height }}</td>
                                    <td>{{ $measure->unit_measurement }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            @endif

        </div>

        <div class="col-12 col-md-12 col-lg-6 px-4">

            <div class="row justify-content-between h-100">
                <div class="col-12">
                    <div class="row align-items-center mb-4">
                        <div class="col-8 col-lg-6">
                            <h5 class="text-indigo text-center"> <i class="fas fa-file"></i> Lista de archivos</h5>
                        </div>
                        {{-- !$quote->responses->contains(fn($response) => $response->status === 'Aceptado') --}}
                        @if ($quote->state === 'Pendiente' && auth()->user()->hasRole('Asesor Comercial'))
                            <div class="col-6 align-items-center">
                                <button class="btn btn-indigo btn-sm" data-toggle="modal"
                                    data-target="#modalQuoteFreightDocuments">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <table id="table-file-freight" class="table">
                        <tbody>
                            @foreach ($files as $file)
                                <tr>
                                    <td>
                                        <a href="{{ $file['url'] }}" target="_blank" class="btn-link text-secondary">
                                            <i class="far fa-fw fa-file-pdf"></i> {{ $file['name'] }}
                                        </a>
                                    </td>
                                    <td class="text-center {{ $quote->state != 'Pendiente' ? 'd-none' : '' }}">
                                        <a href="#" class="text-danger"
                                            onclick="handleFileDeletion('{{ $file['name'] }}', this, event)">
                                            X
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr>

                </div>
                <div class="col-12 d-flex flex-column justify-content-end">

                    <div class="text-center">
                        <div class="custom-badge status-{{ strtolower($quote->state) }}">
                            <i class="fas fa-circle"></i> {{ $quote->state }}
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-12">
            <div class="text-center mt-5 mb-3">
                {{--  @role('Asesor Comercial') --}}
                <form action="{{ url('/quote/freight/send-pricing/' . $quote->id) }}" method="POST" class="d-inline"
                    id="form-send-pricing">
                    @csrf
                    @method('PATCH')

                    <button class="btn btn-outline-indigo btn-sm {{ $quote->state != 'Pendiente' ? 'd-none' : '' }}">
                        <i class="fas fa-paper-plane"></i> Enviar cotización</button>
                </form>
                {{--  @endrole --}}

            </div>

        </div>


        @if ($quote->state != 'Pendiente')

            <div class="col-12 px-4 mt-5">
                <div class="text-center mb-4">
                    <h5 class="text-indigo text-center d-inline mx-2"> <i class="fas fa-check-square"></i> Respuestas</h5>
                    {{-- @role('Pricing') --}}
                    @if (!$quote->responses->contains(fn($response) => $response->status === 'Aceptado'))
                        <button class="btn btn-indigo btn-sm d-inline mx-2" data-toggle="modal"
                            data-target="#modalResponseQuoteFreight">
                            <i class="fas fa-plus"></i>
                        </button>
                    @endif
                    {{-- @endrole --}}
                </div>

                @php
                    $hasAcceptedResponse = $quote->responses->contains(
                        fn($response) => $response->status == 'Aceptado',
                    );
                @endphp

                <table class="table table-sm text-sm">
                    <thead class="thead-dark">
                        <th>#</th>
                        <th>N° Respuesta</th>
                        <th>Agente</th>
                        @if ($quote->commercial_quote->type_shipment->description === 'Aérea')
                            <th>Aerolinea</th>
                        @else
                            <th>Naviera</th>
                        @endif
                        <th>Fecha de Validez</th>
                        <th>Frecuencia</th>
                        <th>Servicio</th>
                        <th>Tiempo en transito</th>
                        <th>Dias Libres</th>
                        <th>Tipo de cambio</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </thead>
                    <tbody>
                        @foreach ($quote->responses as $response)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $response->nro_response }}</td>
                                <td>{{ $response->supplier->name_businessname }}</td>
                                @if ($quote->commercial_quote->type_shipment->description === 'Aérea')
                                    <td>{{ $response->airline->name }}</td>
                                @else
                                    <td>{{ $response->shippingCompany->name }}</td>
                                @endif
                                <td>{{ $response->valid_until_formatted }}</td>
                                <td>{{ $response->frequency }}</td>
                                <td>{{ $response->service }}</td>
                                <td>{{ $response->transit_time }}</td>
                                <td>{{ $response->free_days }}</td>
                                <td>{{ $response->exchange_rate }}</td>
                                <td class="text-indigo text-bold"> $ {{ $response->total }}</td>
                                <td>
                                    <div class="custom-badge status-{{ strtolower($response->status) }}">
                                        {{ $response->status }}
                                    </div>
                                </td>

                                <td style="width: 150px">
                                    <select name="acction_transport" class="form-control form-control-sm"
                                        onchange="changeAcction(this.value, {{ $response->id }})">
                                        <option value="" disabled selected>Seleccione una acción...</option>
                                        <option>Detalle</option>

                                        @if (!$quote->freight)
                                            {{--  @role('Asesor Comercial') --}}
                                            <option class="{{ $response->status != 'Aceptado' ? 'd-none' : '' }}">Generar
                                                Flete</option>
                                            <option class="{{ $response->status === 'Aceptado' ? 'd-none' : '' }}">Aceptar
                                            </option>
                                            <option class="{{ $response->status === 'Rechazada' ? 'd-none' : '' }}">
                                                Rechazar
                                            </option>
                                            {{-- @endrole --}}
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


    <div id="quote-freight" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="quote-freight-title"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action={{ url('/quote/freight/cost/accept/' . $quote->id) }} id="sendFreightCost" method="POST">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <h5 class="modal-title" id="quote-freight-title">{{ $quote->nro_quote }}</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="ocean_freight">Flete maritimo</label>
                            <input id="ocean_freight" data-type="currency" class="form-control CurrencyInput"
                                type="text" name="ocean_freight">
                        </div>
                        <div class="form-group">
                            <label for="utility">Utilidad</label>
                            <input id="utility" data-type="currency" class="form-control CurrencyInput" type="text"
                                name="utility">
                        </div>
                        <div class="form-group">
                            <label for="operations_commission">Comision de operaciones</label>
                            <input id="operations_commission" data-type="currency" @readonly(true)
                                class="form-control CurrencyInput" type="text" name="operations_commission"
                                value="10.00">
                        </div>
                        <div class="form-group">
                            <label for="pricing_commission">Comision de pricing</label>
                            <input id="pricing_commission" data-type="currency" @readonly(true)
                                class="form-control CurrencyInput" type="text" name="pricing_commission"
                                value="10.00">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cerrar Cotización</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalQuoteFreightDocuments" tabindex="-1"
        aria-labelledby="modalQuoteFleteDocumentsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalQuoteFleteDocumentsLabel">Documentos de flete</h5>
                </div>
                <div class="modal-body">
                    <form action="quote/freight/file-upload-documents" method="post" enctype="multipart/form-data"
                        class="dropzone" id="myDropzone">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalResponseQuoteFreight" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modalResponseQuoteFreight-title" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('freight.quote.responses.store', $quote->id) }}"
                    id="formResponseQuoteFreight">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title text-uppercase text-indigo text-bold">Respuesta N°: {{ $nro_response }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="bs-stepper" id="stepperResponseFreight">
                                <div class="bs-stepper-header">
                                    <div class="step" data-target="#step-general">
                                        <button type="button" class="step-trigger" role="tab" id="stepperGeneral"
                                            aria-controls="step-general" aria-selected="false"
                                            data-target="#step-general">
                                            <span class="bs-stepper-circle">1</span>
                                            <span class="bs-stepper-label">Datos Generales</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#step-costos">
                                        <button type="button" class="step-trigger" role="tab" id="stepperCostos"
                                            aria-controls="step-costos" aria-selected="false" data-target="#step-costos">
                                            <span class="bs-stepper-circle">2</span>
                                            <span class="bs-stepper-label">Costos Incurridos</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="bs-stepper-content">
                                    <!-- Paso 1 -->
                                    <div id="step-general" class="bs-stepper-pane active dstepper-block" role="tabpanel"
                                        aria-labelledby="stepperGeneral">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <label for="id_supplier">Agente <span class="text-danger">*</span></label>
                                                <x-adminlte-select2 name="id_supplier" igroup-size="md"
                                                    data-placeholder="Buscar proveedor..." style="width:100%"
                                                    data-required="true">
                                                    <option />
                                                    @foreach ($suppliers as $sup)
                                                        <option value="{{ $sup->id }}">
                                                            {{ $sup->name_businessname }}
                                                        </option>
                                                    @endforeach
                                                </x-adminlte-select2>
                                            </div>

                                            <div class="col-md-6">
                                                <label>Fecha de validez <span class="text-danger">*</span></label>
                                                @php
                                                    $config = [
                                                        'format' => 'DD/MM/YYYY',
                                                        'minDate' => now()->format('Y-m-d'),
                                                        'language' => 'es', // Configurar en español
                                                    ];

                                                    $currentDate = \Carbon\Carbon::now()->format('d/m/Y'); // Formato compatible con el picker
                                                @endphp

                                                <x-adminlte-input-date id="valid_until" name="valid_until"
                                                    value="{{ $currentDate }}" :config="$config" data-required="true"
                                                    placeholder="Selecciona la fecha de validez..." />

                                            </div>

                                            @if ($quote->commercial_quote->type_shipment->description === 'Aérea')
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="airline_id">Aerolinea <span
                                                                class="text-danger">*</span></label>
                                                        <x-adminlte-select2 name="airline_id" igroup-size="md"
                                                            data-placeholder="seleccionar naviera..." style="width:100%">
                                                            <option />
                                                            @foreach ($airlines as $airline)
                                                                <option value="{{ $airline->id }}">
                                                                    {{ $airline->name }}</option>
                                                            @endforeach
                                                        </x-adminlte-select2>

                                                    </div>
                                                </div>
                                            @endif
                                            @if ($quote->commercial_quote->type_shipment->description === 'Marítima')
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="shipping_company_id">Naviera</label>
                                                        <x-adminlte-select2 name="shipping_company_id" igroup-size="md"
                                                            data-placeholder="seleccionar naviera..." style="width:100%">
                                                            <option />
                                                            @foreach ($shipping_companies as $shipping_company)
                                                                <option value="{{ $shipping_company->id }}">
                                                                    {{ $shipping_company->name }}</option>
                                                            @endforeach
                                                        </x-adminlte-select2>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="frequency">Fecuencia </label>
                                                    <x-adminlte-select2 name="frequency" igroup-size="md"
                                                        data-placeholder="seleccionar frecuencia..." style="width:100%">
                                                        <option />
                                                        <option>Diario</option>
                                                        <option>Semanal</option>
                                                        <option>Quincenal</option>
                                                        <option>Mensual</option>
                                                    </x-adminlte-select2>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="service">Servicio</label>
                                                    <input type="text" class="form-control" id="service"
                                                        name="service">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="transit_time">TT</label>
                                                    <input type="text" class="form-control" id="transit_time"
                                                        name="transit_time">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="free_days">Free Days</label>
                                                    <input type="text" class="form-control" id="free_days"
                                                        name="free_days">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exchange_rate">Tipo de cambio</label>
                                                    <input type="text" class="form-control CurrencyInput"
                                                        data-type="currency" id="exchange_rate" name="exchange_rate">
                                                </div>
                                            </div>
                                        </div>


                                        <button type="button" class="btn btn-primary mt-3"
                                            onclick="handleStepValidation('#step-general')">Siguiente</button>
                                    </div>

                                    <!-- Paso 2 -->
                                    <div id="step-costos" class="bs-stepper-pane" role="tabpanel"
                                        aria-labelledby="stepperCostos">

                                        <div id="divResponseFreight" class="p-2 row">

                                            <div class="col-12 row justify-content-center align-items-center my-2 p-3"
                                                style="background-color: rgb(157 160 166 / 27%);">
                                                <div class="col-2">
                                                    <label class="m-0">Detalle de la carga: </label>
                                                </div>

                                                @if ($quote->commercial_quote->type_shipment->description === 'Marítima')
                                                    <div class="col-2">
                                                        <label class="m-0" for="cubage_kgv">Volumen : <span
                                                                class="font-weight-normal">{{ $quote->cubage_kgv }}
                                                                CBM</span></label>
                                                    </div>

                                                    @if ($quote->commercial_quote->lcl_fcl === 'FCL')
                                                        <div class="col-2">
                                                            <label class="m-0" for="ton_kilogram">Toneladas : <span
                                                                    class="font-weight-normal">{{ $quote->ton_kilogram }}
                                                                    TON</span></label>
                                                        </div>
                                                    @else
                                                        <div class="col-2">
                                                            <label class="m-0" for="ton_kilogram">Peso : <span
                                                                    class="font-weight-normal">{{ $quote->ton_kilogram }}
                                                                    KG</span></label>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="col-2">
                                                        <label class="m-0" for="cubage_kgv">KGV : <span
                                                                class="font-weight-normal">{{ $quote->cubage_kgv }}
                                                                KGV</span></label>
                                                    </div>

                                                    <div class="col-2">
                                                        <label class="m-0" for="ton_kilogram">Peso : <span
                                                                class="font-weight-normal">{{ $quote->ton_kilogram }}
                                                                KG</span></label>
                                                    </div>
                                                @endif


                                            </div>
                                            <div class="col-4">
                                                <x-adminlte-select2 name="concept" id="concept_response_freight"
                                                    label="Conceptos" data-placeholder="Seleccione un concepto..."
                                                    data-required="true">
                                                    <option />
                                                    @foreach ($concepts as $concept)
                                                        @if ($concept->typeService->name == 'Flete' && $quote->commercial_quote->type_shipment->id == $concept->id_type_shipment)
                                                            <option value="{{ $concept->id }}">{{ $concept->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </x-adminlte-select2>

                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="unit_cost">Costo unitario</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <select class="custom-select" id="currency" name="currency"
                                                                data-required="true">
                                                                @foreach ($currencies as $currency)
                                                                    <option value="{{ $currency->id }}">
                                                                        {{ $currency->symbol }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <input type="text" class="form-control CurrencyInput"
                                                            id="unit_cost" name="unit_cost" data-type="currency"
                                                            placeholder="Ingrese valor del concepto" value=""
                                                            data-required="true">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-2 text-center">
                                                <div class="form-group">
                                                    <label for="fixed_miltiplyable_cost">C/W</label><br>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="fixed_miltiplyable_cost" name="fixed_miltiplyable_cost"
                                                            value="C/W">
                                                        <label class="form-check-label" for="fixed_miltiplyable_cost">
                                                            Aplicar C/W
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="observations">Observaciones</label>
                                                    <input type="text" class="form-control " name="observations"
                                                        placeholder="Ingrese alguna observación">
                                                </div>

                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="observations">Costo Final</label>
                                                    <input type="text" class="form-control CurrencyInput"
                                                        id="final_cost" name="final_cost"
                                                        placeholder="Ingrese el costo final" data-type="currency"
                                                        data-required="true" readonly>
                                                </div>

                                            </div>
                                            <div class="col-4 form-group d-flex align-items-center justify-content-center">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" name="hasIgv" class="custom-control-input"
                                                        id="hasIgv" {{ isset($insurance) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="hasIgv">Agregar
                                                        IGV</label>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-center align-items-center pt-3 mb-2">
                                                <button class="btn btn-indigo" type="button" id="btnAddConcept"
                                                    onclick="addConceptResponseFreight(this)">
                                                    Agregar
                                                </button>

                                            </div>

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th>Cargos en Origen</th>
                                                        <th>Costo Unitario</th>
                                                        <th>Fijo / CW</th>
                                                        <th>Observaciones</th>
                                                        <th>Costo Final</th>
                                                        <th>x</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbodyQuoteResponseFreight">


                                                </tbody>
                                            </table>

                                        </div>

                                        <div class="row w-100 justify-content-end">

                                            <div class="col-4 row">
                                                <label for="total" class="col-sm-4 col-form-label">Total:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control"
                                                        id="total_response_concept_freight"
                                                        name="total_response_concept_freight" value="0.00"
                                                        @readonly(true)>
                                                </div>
                                            </div>

                                            <div class="col-12 row justify-content-center gap-4">
                                                <button type="button" class="btn btn-secondary mt-3 mx-2"
                                                    onclick="stepper.previous()">Anterior</button>
                                                <button class="btn btn-indigo mt-3 mx-2" type="submit"> <i
                                                        class="fas fa-save mr-2"></i>Guardar respuesta</button>
                                            </div>

                                        </div>



                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>


                </form>
            </div>
        </div>
    </div>



    <!-- Modal para PDF -->
    <div class="modal fade" id="pdfDetailResponse" tabindex="-1" role="dialog"
        aria-labelledby="pdfDetailResponseLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalle de Cotización</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="pdfFrame" src="" frameborder="0" style="width: 100%; height: 80vh;"></iframe>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal de justificacion --}}

    <!-- Modal de justificación de aceptación -->
    <div class="modal fade" id="modalJustification" tabindex="-1" aria-labelledby="modalJustificationLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="formModalJustification" method="POST">
                @csrf
                <div class="modal-content">
                    <div id="headerModalJustification" class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalJustificationLabel">Justificar aceptación</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="responseId" name="response_id">
                        <div class="mb-3">
                            <label for="justification" class="form-label">Explique el motivo:</label>
                            <textarea id="justification" name="justification" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button id="btnJustification" type="submit" class="btn btn-primary">Aceptar respuesta</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="detailContainer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalles del Contenedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="containerDetails">
                        <!-- Aquí se llenará la información del contenedor -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Template para copiar y enviar por Outlook --}}


    <div id="plantilla-cotizacion" class="row justify-content-center flex-column p-5 d-none" style="width: 600px">
        @if ($quote->commercial_quote->is_consolidated)

            @foreach ($quote->commercial_quote->consolidatedCargos as $consolidated)
                <p>• SHIPPER {{ $loop->iteration }} :</p>

                <table border="1" cellpadding="4" cellspacing="0" style="border-collapse: collapse;width: 500px">
                    <thead>
                        <th colspan="2" class="text-center" style="background-color: #e2efd9">ORBE ADUANAS S.A.C</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Tipo de embarque</strong></td>
                            <td>{{ $quote->commercial_quote->type_shipment->name }}
                                {{ $quote->commercial_quote->lcl_fcl != null ? "({$quote->commercial_quote->lcl_fcl})" : '' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Incoterm</strong></td>
                            <td>{{ $consolidated->incoterm->code }}</td>
                        </tr>
                        <tr>
                            <td><strong>Origen</strong></td>
                            <td>{{ $quote->origin }}</td>
                        </tr>
                        <tr>
                            <td><strong>Destino</strong></td>
                            <td>{{ $quote->destination }}</td>
                        </tr>
                        @if ($consolidated->supplier_id)
                            //TODO:: Aqui tenemos que obtener segun la relacion si es que tiene
                        @else
                            @php
                                $supplier = json_decode($consolidated->supplier_temp);
                            @endphp

                            <tr>
                                <td><strong>Shipper</strong></td>
                                <td>{{ $supplier->shipper_name }}</td>
                            </tr>

                            <tr>
                                <td><strong>Direccion</strong></td>
                                <td>{{ $supplier->shipper_address }}</td>
                            </tr>
                            <tr>
                                <td><strong>Contacto</strong></td>
                                <td>{{ $supplier->shipper_contact }} // {{ $supplier->shipper_contact_email }} //
                                    {{ $supplier->shipper_contact_phone }} </td>
                            </tr>
                        @endif

                        <tr>
                            <td><strong>Producto</strong></td>
                            <td>{{ $consolidated->commodity }}</td>
                        </tr>
                        @if ($quote->commercial_quote->type_shipment->description === 'Marítima')
                            @if ($quote->commercial_quote->lcl_fcl === 'FCL')
                                <tr>
                                    <td><strong>Tipo de contenedor</strong></td>
                                    {{-- <td>{{ $quote->commercial_quote->container_quantity }}x{{ $quote->commercial_quote->container->name }} --}}
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td><strong>Volumen</strong></td>
                                <td>{{ $consolidated->volumen }} CBM</td>
                            </tr>
                        @else
                            <tr>
                                <td><strong>KGV</strong></td>
                                <td>{{ $consolidated->kilogram_volumen }} KGV</td>
                            </tr>
                        @endif

                        <tr>
                            <td><strong>Peso</strong></td>
                            <td>{{ $consolidated->kilograms }} KG</td>
                        </tr>

                        @php
                            $measures = json_decode($consolidated->value_measures);
                        @endphp

                        @if (!empty($measures))
                            <tr>
                                <td><strong>Medidas</strong></td>
                                <td>
                                    @foreach ($measures as $item)
                                        <p><span class="text-bold">{{ $item->amount }}</span> = {{ $item->width }}
                                            {{ $item->unit_measurement }} x {{ $item->length }}
                                            {{ $item->unit_measurement }}
                                            x
                                            {{ $item->height }} {{ $item->unit_measurement }}</p>
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td><strong>Bulto</strong></td>
                            <td>{{ $consolidated->nro_packages }} {{ $consolidated->packaging_type }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tipo de carga</strong></td>
                            <td>{{ $quote->load_type }}</td>
                        </tr>

                    </tbody>

                </table>
                <br>
            @endforeach
        @else
            <table border="1" cellpadding="4" cellspacing="0" style="border-collapse: collapse;width: 500px">
                <thead>
                    <th colspan="2" class="text-center" style="background-color: #e2efd9">ORBE ADUANAS S.A.C</th>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Tipo de embarque</strong></td>
                        <td>{{ $quote->commercial_quote->type_shipment->name }}
                            {{ $quote->commercial_quote->lcl_fcl != null ? "({$quote->commercial_quote->lcl_fcl})" : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Incoterm</strong></td>
                        <td>{{ $quote->commercial_quote->incoterm->code }}</td>
                    </tr>
                    <tr>
                        <td><strong>Origen</strong></td>
                        <td>{{ $quote->origin }}</td>
                    </tr>
                    <tr>
                        <td><strong>Destino</strong></td>
                        <td>{{ $quote->destination }}</td>
                    </tr>
                    <tr>
                        <td><strong>Producto</strong></td>
                        <td>{{ $quote->commodity }}</td>
                    </tr>
                    @if ($quote->commercial_quote->type_shipment->description === 'Marítima')

                        <tr>
                            <td><strong>Volumen</strong></td>
                            <td>{{ $quote->cubage_kgv }} CBM</td>
                        </tr>

                        @if ($quote->commercial_quote->lcl_fcl === 'FCL')
                            <tr>
                                <td><strong>Tipo de contenedor</strong></td>
                                {{--  <td>{{ $quote->commercial_quote->container_quantity }}x{{ $quote->commercial_quote->container->name }} --}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>TONELADAS</strong></td>
                                <td>{{ $quote->ton_kilogram }} TON</td>
                            </tr>
                        @else
                            <tr>
                                <td><strong>Peso</strong></td>
                                <td>{{ $quote->ton_kilogram }} KG</td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td><strong>KGV</strong></td>
                            <td>{{ $quote->cubage_kgv }} KGV</td>
                        </tr>

                        <tr>
                            <td><strong>Peso</strong></td>
                            <td>{{ $quote->ton_kilogram }} KG</td>
                        </tr>

                    @endif

                    @php
                        $measures = json_decode($quote->measures);
                    @endphp

                    @if (!empty($measures))
                        <tr>
                            <td><strong>Medidas</strong></td>
                            <td>
                                @foreach ($measures as $item)
                                    <p><span class="text-bold">{{ $item->amount }}</span> = {{ $item->width }}
                                        {{ $item->unit_measurement }} x {{ $item->length }}
                                        {{ $item->unit_measurement }}
                                        x
                                        {{ $item->height }} {{ $item->unit_measurement }}</p>
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td><strong>Bulto</strong></td>
                        <td>{{ $quote->packages }} {{ $quote->packaging_type }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tipo de carga</strong></td>
                        <td>{{ $quote->load_type }}</td>
                    </tr>

                </tbody>

            </table>

        @endif
    </div>




@stop


@push('scripts')
    <script>
        let conceptsResponseFreightArray = [];
        let commissionsResponseFreightArray = [];
        //Obtenemos las comisiones para agregarlo a las respuestas
        const commissionsFromDB = @json($commissions) || [];


        $('#modalResponseQuoteFreight').on('shown.bs.modal', function() {
            // Solo cargamos las comisiones si aún no han sido insertadas
            if (commissionsResponseFreightArray.length === 0) {
                commissionsFromDB.forEach(c => {
                    commissionsResponseFreightArray.push({
                        commission_id: c.id,
                        concept: {
                            name: c.name
                        },
                        unit_cost: c.default_amount,
                        fixed_miltiplyable_cost: 'FIJO',
                        observations: '',
                        final_cost: c.default_amount
                    });
                });
            }

            updateTableRespnoseFreight();
        });



        $('#sendFreightCost').on('submit', (e) => {

            e.preventDefault();

            let isValid = true; // Bandera para comprobar si el formulario es válido
            let form = e.target;
            const inputs = form.querySelectorAll('input');


            inputs.forEach((input) => {
                // Ignorar campos ocultos (d-none)
                if (input.closest('.d-none')) {
                    return;
                }

                // Validar si el campo está vacío
                if (input.value.trim() === '') {
                    input.classList.add('is-invalid');
                    isValid = false; // Cambiar bandera si algún campo no es válido
                    showError(input, 'Debe completar este campo');
                } else {
                    input.classList.remove('is-invalid');
                    hideError(input);
                }
            });


            if (isValid) {
                form.submit();
            }

        });


        function calculateFinalCost() {
            let cubage_kgv = parseFloat(@json($quote->cubage_kgv)) || 0;
            let ton_kilogram = parseFloat(@json($quote->ton_kilogram)) || 0;
            let unit_cost = parseFloat($('#unit_cost').val().replace(/,/g, '')) || 0;
            let cw = $('#fixed_miltiplyable_cost');
            let higherCost = 0;
            let final_cost = 0;



            //Verificamos que el C/W este marcado

            if (cw.is(':checked')) {
                higherCost = cubage_kgv > ton_kilogram ? cubage_kgv : ton_kilogram;
                final_cost = unit_cost * higherCost;
            } else {
                final_cost = unit_cost;
            }


            //Verificamos cual es mayor para realizar calculo del costo final


            let formattedNumber = final_cost.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            $('#final_cost').val(formattedNumber);
        }

        /* Calculamos cuando el costo final multiplicando el costo unitario pr el peso cargable (va depender de si el volumen o el peso sea mayor) */
        $('#unit_cost').on('change', () => {

            calculateFinalCost();
        });

        $('#fixed_miltiplyable_cost').on('change', function() {
            calculateFinalCost();
        });

        function addConceptResponseFreight(buton) {

            let divConcepts = $('#divResponseFreight');
            const inputs = divConcepts.find('input , select');
            const currencies = @json($currencies);
            let isValid = true;

            inputs.each(function() {
                const input = this;

                if (input.closest('.d-none')) return;

                // Solo validar si el campo tiene el atributo data-required
                if (input.dataset.required === 'true') {
                    if (input.value.trim() === '' || input.value == null) {
                        input.classList.add('is-invalid');
                        isValid = false;
                        showError(input, 'Debe completar este campo');
                    } else {
                        input.classList.remove('is-invalid');
                        hideError(input);
                    }
                } else {
                    // No requerido, aseguramos que no tenga error visible
                    input.classList.remove('is-invalid');
                    hideError(input);
                }
            });

            if (isValid) {
                let data = loadConceptData(inputs);
                const selectedCurrencyId = parseInt(data.currency.id);
                const selectedCurrency = currencies.find(c => c.id === selectedCurrencyId);
                const dollarCurrency = currencies.find(c => c.abbreviation === 'USD');

                if (!checkExchangeRateNotEmpyt(selectedCurrency, dollarCurrency)) return;

                const unitCost = parseFloat(data.unit_cost) || 0;
                let finalCost = 0;

                if (selectedCurrency.id !== dollarCurrency.id) {
                    const exchangeRateInput = $('#exchange_rate')[0];
                    const exchangeRate = parseFloat(exchangeRateInput.value) || 0;


                    finalCost = unitCost * exchangeRate;

                    if (data.fixed_miltiplyable_cost === "C/W") {
                        let cubage_kgv = parseFloat(@json($quote->cubage_kgv)) || 0;
                        let ton_kilogram = parseFloat(@json($quote->ton_kilogram)) || 0;

                        let higherCost = cubage_kgv > ton_kilogram ? cubage_kgv : ton_kilogram;
                        finalCost = finalCost * higherCost;

                    }

                    if (data.hasIgv === "on") {
                        finalCost = finalCost * 1.18;
                        data.observations = 'Con IGV';
                    }


                    data.final_cost = finalCost.toFixed(2);
                } else {
                    finalCost = unitCost;

                    if (data.fixed_miltiplyable_cost === "C/W") {
                        let cubage_kgv = parseFloat(@json($quote->cubage_kgv)) || 0;
                        let ton_kilogram = parseFloat(@json($quote->ton_kilogram)) || 0;

                        let higherCost = cubage_kgv > ton_kilogram ? cubage_kgv : ton_kilogram;
                        finalCost = finalCost * higherCost;

                    }

                    if (data.hasIgv === "on") {
                        finalCost = finalCost * 1.18;
                        data.observations = 'Con IGV';
                    }


                    data.final_cost = finalCost.toFixed(2);

                }


                const index = conceptsResponseFreightArray.findIndex(item => item.concept?.id === parseInt(data.concept
                    .id));

                if (index !== -1) {

                    conceptsResponseFreightArray[index] = data;

                } else {

                    conceptsResponseFreightArray.push(data);
                }

                updateTableRespnoseFreight(conceptsResponseFreightArray);
                clearConceptsData(inputs);

            }
        };


        function updateTableRespnoseFreight(conceptsResponseFreightArray) {
            let tbodyRouting = $(`#divResponseFreight`).find('tbody')[0];
            if (tbodyRouting) {
                tbodyRouting.innerHTML = '';
            }

            let setObservation = '';

            TotalResponseConcepts = 0;
            let contador = 0;

            if (conceptsResponseFreightArray && Array.isArray(conceptsResponseFreightArray)) {

                // 1. Primero renderizamos los conceptos normales
                conceptsResponseFreightArray.forEach((item, index) => {
                    contador++;
                    let fila = tbodyRouting.insertRow();

                    // Establecer color de fila si tiene IGV
                    if (item.hasIgv) {
                        fila.style.backgroundColor = '#f8d7da'; // Color de fondo para filas con IGV
                    }

                    fila.insertCell(0).textContent = contador;
                    fila.insertCell(1).textContent = item.concept.text;
                    fila.insertCell(2).textContent = item.currency.text + " " + item.unit_cost;
                    fila.insertCell(3).textContent = item.fixed_miltiplyable_cost;
                    fila.insertCell(4).textContent = item.observations;
                    fila.insertCell(5).textContent = "$ " + parseFloat(item.final_cost).toFixed(2);

                    let celdaEliminar = fila.insertCell(6);
                    let botonEliminar = document.createElement('a');
                    botonEliminar.href = '#';
                    botonEliminar.innerHTML = '<p class="text-danger">X</p>';
                    botonEliminar.addEventListener('click', function() {
                        // Eliminar el concepto
                        conceptsResponseFreightArray.splice(index, 1);
                        updateTableRespnoseFreight(); // Re-renderizar tabla
                    });
                    celdaEliminar.appendChild(botonEliminar);

                    TotalResponseConcepts += parseFloat(item.final_cost);
                });

            }

            // 2. Luego renderizamos las comisiones fijas
            commissionsResponseFreightArray.forEach((item) => {
                contador++;
                let fila = tbodyRouting.insertRow();

                fila.insertCell(0).textContent = contador;
                fila.insertCell(1).textContent = item.concept.name;
                fila.insertCell(2).textContent = "$ " + item.unit_cost;
                fila.insertCell(3).textContent = item.fixed_miltiplyable_cost;
                fila.insertCell(4).textContent = item.observations;
                fila.insertCell(5).textContent = "$ " + parseFloat(item.final_cost).toFixed(2);

                // Celda de eliminar deshabilitada
                let celdaEliminar = fila.insertCell(6);
                /*  celdaEliminar.innerHTML = '<span class="text-muted">Fijo</span>'; */

                TotalResponseConcepts += parseFloat(item.final_cost);
            });

            // 3. Actualizar el total
            $('#total_response_concept_freight').val(TotalResponseConcepts.toFixed(2));
        }


        $('#formResponseQuoteFreight').on('submit', function(e) {
            e.preventDefault();

            let formResponseQuote = $('#formResponseQuoteFreight');


            if (conceptsResponseFreightArray.length > 0) {

                let conceptops = JSON.stringify(conceptsResponseFreightArray);
                let commissions = JSON.stringify(commissionsResponseFreightArray);

                formResponseQuote.append(`<input type="hidden" name="concepts" value='${conceptops}' />`);
                formResponseQuote.append(`<input type="hidden" name="commissions" value='${commissions}' />`);

                e.target.submit();

            } else {
                toastr.error('Debe agregar algun concepto para esta respuesta aparte de las comisiones');
            }

        });



        function loadConceptData(inputs) {
            let data = {};
            inputs.each(function() {
                const input = this;
                let name = input.name;
                if (name) {
                    if (input.tagName === 'SELECT') {

                        data[name] = {
                            id: parseInt(input.value),
                            text: input.options[input.selectedIndex] ? input.options[input.selectedIndex].text :
                                ''
                        };

                    } else if (input.type === 'checkbox') {
                        data[name] = $(input).is(':checked') ? input.value : '';
                    } else {
                        // Si es un valor numérico formateado, lo limpiamos
                        if (input.classList.contains('CurrencyInput')) {
                            // Elimina comas y convierte a número
                            data[name] = parseFloat(input.value.replace(/,/g, '')) || 0;
                        } else {
                            data[name] = input.value;
                        }
                    }
                }
            });

            return data;
        }


        function clearConceptsData(inputs) {
            inputs.each(function() {
                const input = this;

                if (input.tagName === 'SELECT') {
                    $(input).val(null).trigger('change'); // Resetea select2
                } else if (input.type === 'checkbox') {
                    input.checked = false; // Desmarca el checkbox
                } else {
                    input.value = ''; // Limpia input de texto, número, etc.
                }

                input.classList.remove('is-invalid');
                hideError(input);
            });
        }

        $('#detailContainer').on('show.bs.modal', function(event) {
            // Obtener el botón que activó el modal
            var button = $(event.relatedTarget);

            // Extraer el objeto contenedor de los atributos data-*
            var commercialcontainer = button.data(
                'commercialcontainer'); // Convertimos el JSON de vuelta a un objeto
            console.log(commercialcontainer);
            // Acceder a las propiedades del objeto contenedor y colocarlas en el modal
            var modalBody = $(this).find('.modal-body #containerDetails');

            // Construir la tabla para las medidas
            var measuresTable = '';
            if (commercialcontainer.measures) {
                var measures = JSON.parse(commercialcontainer
                    .measures); // Asegúrate de que las medidas estén en formato JSON
                measuresTable =
                    '<table class="table table-bordered"><thead><tr><th>Cantidad</th><th>Anchura (cm)</th><th>Longitud (cm)</th><th>Altura (cm)</th><th>Unidad de Medida</th></tr></thead><tbody>';

                // Iterar sobre las medidas y agregar filas a la tabla
                $.each(measures, function(key, measure) {
                    measuresTable += `
            <tr>
                <td>${measure.amount}</td>
                <td>${measure.width}</td>
                <td>${measure.length}</td>
                <td>${measure.height}</td>
                <td>${measure.unit_measurement}</td>
            </tr>
        `;
                });

                measuresTable += '</tbody></table>';
            }

            modalBody.html(`
                <div class="row px-3">
                    <div class="col-md-6">
                        <p><strong>Nombre del Contenedor:</strong> ${commercialcontainer.container.name}</p>
                        <p><strong>Mercancía:</strong> ${commercialcontainer.commodity}</p>
                        <p><strong>Bultos:</strong> ${commercialcontainer.nro_package}</p>
                        
                       
                    </div>
                    <div class="col-md-6">
                        <p><strong>Cantidad:</strong> ${commercialcontainer.container_quantity}</p>
                        <p><strong>Valor de la carga:</strong> ${commercialcontainer.load_value}</p>
                        <p><strong>Tipo de Embalaje:</strong> ${commercialcontainer.packing_type.name}</p>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-md-6">
                        <p><strong>Kilogramos:</strong> ${commercialcontainer.kilograms}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Volumen:</strong> ${commercialcontainer.volumen}</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        ${measuresTable}
                    </div>
                </div>
            `);
        });



        function changeAcction(action, responseId) {
            if (!action) return;

            if (action === "Detalle") {
                //Abrir modal
                const url = `/quote/freight/response/${responseId}/show`;
                $('#pdfFrame').attr('src', url);
                $('#pdfDetailResponse').modal('show');
                return;
            } else if (action === "Aceptar") {
                Swal.fire({
                    title: '¿Aceptar respuesta?',
                    text: '¿Está seguro de aceptar esta respuesta?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#2e37a4'
                }).then((result) => {
                    if (result.isConfirmed) {
                        /* window.location.href = `/quote/freight/response/${responseId}/accept`; */
                        $('#modalJustificationLabel').text('Justificar aceptación');
                        $('#headerModalJustification').addClass('bg-primary').removeClass('bg-danger');
                        $('#btnJustification').text('Aceptar respuesta');
                        $('#btnJustification').addClass('btn-primary').removeClass('btn-danger');
                        // Guardar temporalmente el responseId
                        $('#acceptResponseId').val(responseId);
                        // Limpiar el campo de justificación
                        const justification = $('#justification')

                        // Mostrar el modal de justificación
                        justification.removeClass('is-invalid');
                        hideError(justification[0]);
                        $('#modalJustification').modal('show');

                        $('#formModalJustification').attr('action', `/quote/freight/response/${responseId}/accept`);

                    }
                });
            } else if (action === "Rechazar") {
                Swal.fire({
                    title: '¿Rechazar respuesta?',
                    text: '¿Está seguro de rechazar esta respuesta?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Rechazar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        /*   window.location.href = `/quote/freight/response/${responseId}/reject`; */
                        $('#modalJustificationLabel').text('Justificar rechazo');
                        $('#headerModalJustification').addClass('bg-danger').removeClass('bg-primary');
                        $('#btnJustification').text('Rechazar respuesta');
                        $('#btnJustification').addClass('btn-danger').removeClass('btn-primary');
                        $('#acceptResponseId').val(responseId);
                        // Limpiar el campo de justificación
                        const justification = $('#justification')

                        // Mostrar el modal de justificación
                        justification.removeClass('is-invalid');
                        hideError(justification[0]);
                        $('#modalJustification').modal('show');

                        $('#formModalJustification').attr('action', `/quote/freight/response/${responseId}/reject`);

                    }
                });
            } else if (action === 'Generar Flete') {
                window.location.href = `/quote/freight/response/${responseId}/generate`;
            }
        }


        $('#formModalJustification').on('submit', function(e) {
            const justification = $('#justification')
            const valueJustification = justification.val().trim();
            hideError(justification[0]);
            if (!valueJustification) {
                e.preventDefault();
                justification.addClass('is-invalid');
                showError(justification[0], 'Debe completar el campo de justificacion');
            } else {
                justification.removeClass('is-invalid');
                hideError(justification[0]);
            }
        });


        function checkExchangeRateNotEmpyt(selectedCurrency, dollarCurrency) {

            const exchangeRateInput = $('#exchange_rate')[0];

            if (!selectedCurrency) {
                toastr.error('La moneda seleccionada no es válida.');
                return false;
            }

            if (selectedCurrency.id !== dollarCurrency.id) {

                if (!exchangeRateInput || exchangeRateInput.value.trim() === '') {
                    toastr.error(`Debe ingresar el tipo de cambio para la moneda ${selectedCurrency.badge}`);
                    exchangeRateInput.classList.add('is-invalid');
                    showError(exchangeRateInput, 'Ingrese el tipo de cambio');
                    return false;
                } else {
                    exchangeRateInput.classList.remove('is-invalid');
                    hideError(exchangeRateInput);
                }
            }

            return true;

        }


        function handleStepValidation(stepId) {
            if (validateCurrentStep(stepId)) {
                stepper.next();
            } else {
                toastr.error("Por favor completa todos los campos requeridos antes de continuar.");
            }
        }


        function validateCurrentStep(stepId) {
            let isValid = true;
            const currentStep = document.querySelector(stepId);
            const inputs = currentStep.querySelectorAll('[data-required="true"]');

            inputs.forEach(input => {
                if (input.closest('.d-none')) return;

                const value = input.value?.trim();
                if (!value || value === '') {
                    input.classList.add('is-invalid');
                    showError(input, 'Debe completar este campo');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                    hideError(input);
                }
            });

            return isValid;
        }



        //Formatear el valor para poder hacer calculos
        function formatValue(value) {
            // Verifica si el valor es una cadena (string)
            if (typeof value === 'string') {
                return value.replace(/,/g, '');
            }
            // Si es un número, simplemente lo retorna tal cual
            return value;
        }



        // Mostrar mensaje de error
        function showError(input, message) {
            let container = input;

            // Si es un SELECT2
            if (input.tagName === 'SELECT' && $(input).hasClass('select2-hidden-accessible')) {
                container = $(input).next('.select2')[0];
            }

            let errorSpan = container.nextElementSibling;

            if (!errorSpan || !errorSpan.classList.contains('invalid-feedback')) {
                errorSpan = document.createElement('span');
                errorSpan.classList.add('invalid-feedback', 'd-block'); // Asegura visibilidad
                container.after(errorSpan);
            }

            errorSpan.textContent = message;
            errorSpan.style.display = 'block';
        }

        function hideError(input) {
            let container = input;

            if (input.tagName === 'SELECT' && $(input).hasClass('select2-hidden-accessible')) {
                container = $(input).next('.select2')[0];
            }

            let errorSpan = container.nextElementSibling;

            if (errorSpan && errorSpan.classList.contains('invalid-feedback')) {
                errorSpan.classList.remove('d-block');
                errorSpan.style.display = 'none';
            }
        }
    </script>

    {{-- Drop zone for documents --}}

    <script>
        let commercial_quote = @json($quote->nro_quote_commercial);
        let freight_quote = @json($quote->nro_quote);

        var stepper = new Stepper(document.querySelector('#stepperResponseFreight'));

        Dropzone.options.myDropzone = {

            url: '/quote/freight/file-upload-documents', // Ruta para subir los archivos
            maxFilesize: 2, // Tamaño máximo en MB
            acceptedFiles: '.jpg,.jpeg,.png,.gif,.pdf', // Tipos permitidos
            autoProcessQueue: true, // Subir automáticamente al añadir
            params: {
                commercial_quote,
                freight_quote // Envía este dato adicional al servidor
            },

            init: function() {
                let uploadedFiles = []; // Almacena los nombres de archivos subidos
                let myDropzone = this;

                let tableBody = document.querySelector("#table-file-freight tbody");

                this.on('addedfile', function(file) {
                    // Si el archivo es PDF, asigna una miniatura personalizada (imagen predeterminada)
                    if (/\.pdf$/i.test(file.name)) {
                        // Usamos la URL de la imagen predeterminada para los PDFs
                        let pdfThumbnailUrl =
                            'https://static.vecteezy.com/system/resources/previews/023/234/824/non_2x/pdf-icon-red-and-white-color-for-free-png.png'; // Cambia esto por la ruta de tu imagen predeterminada
                        this.emit("thumbnail", file, pdfThumbnailUrl);
                    }




                    let existingFile = uploadedFiles.find(item => item.filename === file.name);
                    if (existingFile) {
                        myDropzone.removeFile(existingFile.file);
                        existingFile.row.remove();
                        uploadedFiles = uploadedFiles.filter(item => item.filename !== file.name);
                    }


                })

                this.on('success', function(file, response) {

                    let row = document.createElement("tr");

                    let fileCell = document.createElement("td");
                    let link = document.createElement("a");
                    link.href = response.url;
                    link.target = "_blank";
                    link.className = "btn-link text-secondary";
                    link.innerHTML = `<i class="far fa-fw fa-file-pdf"></i> ${response.filename}`;
                    fileCell.appendChild(link);


                    //Creamos el boton de eliminar

                    // Columna del botón eliminar
                    let actionCell = document.createElement("td");
                    actionCell.className = "text-center";
                    let removeButton = document.createElement("a");
                    removeButton.href = "#";
                    removeButton.className = "text-danger";
                    removeButton.textContent = "X";


                    removeButton.addEventListener('click', function(event) {
                        event.preventDefault();

                        axios.post('/quote/freight/file-delete-documents', {

                            filename: response.filename,
                            commercial_quote: commercial_quote,
                            freight_quote: freight_quote

                        }).then(response => {

                            row.remove();
                            // Eliminar de Dropzone
                            myDropzone.removeFile(file);

                        }).catch(error => {
                            console.error('Error al eliminar el archivo:', error);
                        });
                    });


                    actionCell.appendChild(removeButton);
                    row.appendChild(fileCell);
                    row.appendChild(actionCell);

                    tableBody.appendChild(row);

                    // Guardar en el mapa de archivos subidos
                    /* uploadedFiles.set(response.filename, listItem); */


                    uploadedFiles.push({
                        "filename": file.name,
                        "row": row,
                        "file": file
                    });


                });

            }
        };

        function handleFileDeletion(filename, element, e) {

            e.preventDefault();

            axios.post('/quote/freight/file-delete-documents', {
                filename: filename,
                commercial_quote: commercial_quote,
                freight_quote: freight_quote
            }).then(response => {
                let listItem = element.parentElement;
                row.remove();
            }).catch(error => {
                console.error('Error al eliminar el archivo:', error);
            });
        }


        /* Copiar informacion en portapapeles */

        function copieHtmlDetailQuote() {

            const plantilla = document.getElementById("plantilla-cotizacion");
            const blob = new Blob([plantilla.innerHTML], {
                type: "text/html"
            });
            const itemText = new ClipboardItem({
                "text/html": blob
            });

            navigator.clipboard.write([itemText])
                .then(() => toastr.success("Detalle copiado en portapapeles !"))
                .catch(() => toastr.error("❌ No se pudo copiar al portapapeles."));

        }

        function downloadImageDetailQuote(nro_quote) {
            const plantilla = document.getElementById("plantilla-cotizacion");


            const wasHidden = plantilla.classList.contains("d-none");

            if (wasHidden) {
                plantilla.classList.remove("d-none");
                plantilla.classList.add("offscreen-capture");
            }


            html2canvas(plantilla, {
                useCORS: true, // Esto ayuda a evitar problemas con imágenes externas
                scrollX: 0, // Evita desplazamiento horizontal durante la captura
                scrollY: -window.scrollY, // Evita desplazamiento vertical
            }).then(function(canvas) {
                const dataUrl = canvas.toDataURL("image/png");

                // Crear un enlace para descargar la imagen
                const link = document.createElement('a');
                link.download = `detalle-cotizacion-${nro_quote}.png`; // Nombre del archivo a descargar
                link.href = dataUrl;
                link.click(); // Simula el clic para descargar la imagen

                if (wasHidden) {
                    plantilla.classList.remove("offscreen-capture");
                    plantilla.classList.add("d-none");
                }

                toastr.success("La imagen fue generadad.");

            }).catch(function(error) {
                toastr.error("❌ No se pudo generar la imagen.");
            });
        }

        $('#form-send-pricing').on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción enviará y notificara al área de pricing.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2e37a4',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, enviar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit(); // Enviar formulario si confirma
                }
            });
        });
    </script>
@endpush

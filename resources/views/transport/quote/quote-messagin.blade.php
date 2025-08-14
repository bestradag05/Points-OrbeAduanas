@extends('home')


@section('dinamic-content')

    <div class="row">

        {{-- <div class="col-12  mb-4 text-right">
            <a href="{{ url('/quote/freight') }}" class="btn btn-primary"> Atras </a>
</div> --}}
        <div class="col-12 col-md-12 col-lg-5">
            <h5 class="text-indigo text-center"><i class="fas fa-file-alt"></i> Detalle de carga</h5>

            <br>


            <div class="row text-muted">
                <div class="col-6">
                    <p class="text-sm">N° Cotizacion General :
                        <b class="d-block">{{ $quote->nro_quote_commercial }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">N° Cotizacion :
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
                        <b class="d-block">{{ $quote->pick_up }}</b>
                    </p>
                </div>
                <div class="col-6">
                    <p class="text-sm">Destino :
                        <b class="d-block">{{ $quote->delivery }}</b>
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
                                        type="button" data-toggle="collapse" data-target="#collapse{{ $consolidated->id }}"
                                        aria-expanded="true">
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
                                            <b class="d-block">{{ $consolidated->packaging_type }}</b>
                                        </p>
                                    </div>
                                    @if ($consolidated->commercialQuote->type_shipment->description === 'Marítima')
                                        <div class="col-6">
                                            <p class="text-sm">Volumen :
                                                <b class="d-block">{{ $consolidated->volumen }} CBM</b>
                                            </p>
                                        </div>

                                        @if ($quote->commercial_quote->lcl_fcl === 'LCL')
                                            <div class="col-6">
                                                <p class="text-sm">Apilable :
                                                    <b class="d-block">{{ $quote->stackable }}</b>
                                                </p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="col-6">
                                            <p class="text-sm">KGV :
                                                <b class="d-block">{{ $consolidated->kilogram_volumen }} KGV</b>
                                            </p>
                                        </div>

                                        <div class="col-6">
                                            <p class="text-sm">Apilable :
                                                <b class="d-block">{{ $quote->stackable }}</b>
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
                                <b class="d-block">{{ $quote->ton_kilogram }} CBM</b>
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
                                <p class="text-sm">Peso total :
                                    <b class="d-block">{{ $quote->ton_kilogram }} KG</b>
                                </p>
                            </div>

                            <div class="col-6">
                                <p class="text-sm">Apilable :
                                    <b class="d-block">{{ $quote->stackable }}</b>
                                </p>
                            </div>
                        @endif

                </div>
            @else
                <div class="row text-muted">
                    <div class="col-6">
                        <p class="text-sm">Kilogramo volumen / KGV :
                            <b class="d-block">{{ $quote->cubage_kgv }} KGV</b>
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-sm">Peso total :
                            <b class="d-block">{{ $quote->ton_kilogram }} KG</b>
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-sm">Apilable :
                            <b class="d-block">{{ $quote->stackable }}</b>
                        </p>
                    </div>

                </div>
            @endif



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



            <div class="row text-muted mt-3">
                <div class="col-6">
                    <p class="text-uppercase ">Estado :
                        <b class="status-{{ strtolower($quote->state) }}">{{ $quote->state }}</b>
                        <b class="status-{{ strtolower($quote->state) }}"><i class="fas fa-circle"></i></b>
                    </p>
                </div>

            </div>

            <hr>
            <div class="row align-items-center">
                <div class="col-6 align-items-center">
                    <h5 class="mt-3 text-muted">Archivos : </h5>
                </div>
                <div class="col-6 align-items-center {{ $quote->state === 'Aceptado' ? 'd-none' : '' }}">
                    <button class="btn btn-indigo btn-sm" data-toggle="modal"
                        data-target="#modalQuoteTransportDocuments">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <table id="table-file-transport" class="table">
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td>
                                <a href="{{ $file['url'] }}" target="_blank" class="btn-link text-secondary">
                                    <i class="far fa-fw fa-file-pdf"></i> {{ $file['name'] }}
                                </a>
                            </td>
                            <td class="text-center {{ $quote->state === 'Aceptado' ? 'd-none' : '' }}"">
                                <a href=" #" class="text-danger"
                                    onclick="handleFileDeletion('{{ $file['name'] }}', this, event)">
                                    X
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>
            @if ($quote->cost_transport != null && $quote->state === 'Aceptado')
                <div class="row">

                    <div class="col-12">
                        <h6 class="text-indigo text-center mb-3 text-bold"><i class="fas fa-dollar-sign"></i> Detalle de
                            costos
                        </h6>
                    </div>

                    <div class="col-12 ml-4">

                        <div class="row text-muted">
                            <div class="col-4">
                                <p class="text-sm">Flete :
                                </p>
                            </div>
                            <div class="col-6">
                                <b class="d-inline">$ {{ $quote->cost_transport }}</b>
                            </div>

                        </div>
                        @if ($quote->gang === 'SI')
                            <div class="row text-muted">
                                <div class="col-4">
                                    <p class="text-sm">Cuadrilla :
                                    </p>
                                </div>
                                <div class="col-6">
                                    <b class="d-inline">$ {{ $quote->cost_gang }}</b>
                                </div>

                            </div>
                        @endif
                        @if ($quote->guard === 'SI')
                            <div class="row text-muted">
                                <div class="col-4">
                                    <p class="text-sm">Reguardo :
                                    </p>
                                </div>
                                <div class="col-6">
                                    <b class="d-inline">$ {{ $quote->cost_guard }}</b>
                                </div>

                            </div>
                        @endif



                        <div class="row text-muted mt-3 ">
                            <div class="col-12 row justify-content-center">
                                <p class="text-uppercase text-bold text-lg">Costo del Transporte :
                                    <b class="status-{{ strtolower($quote->state) }}">$
                                        {{ $quote->total_transport }}</b>
                                </p>
                            </div>

                        </div>


                    </div>


                </div>
            @endif
        </div>
        <!-- Crear lista de respuestas -->
        <div class="col-12 col-md-12 col-lg-6">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="text-indigo"><i class="fas fa-file-alt"></i> Lista de respuestas</h5>
                <!-- Botón para abrir el modal -->
                @can('transporte.quote.response')
                    @if (!$quote->responses->contains('status', 'Aceptado'))
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#modalCotizarTransporte">
                            <i class="fas fa-truck mr-1"></i> Responder
                        </button>
                    @endif
                @endcan
            </div>
            <table class="table table-sm text-sm my-5">
                <thead class="thead-dark">
                    <th>#</th>
                    <th>N° respuesta</th>
                    <th>Proveedor</th>
                    <th class="text-end">Costo Neto (S/.)</th>
                    <th class="text-end">IGV (S/.)</th>
                    <th class="text-end">Total (S/.)</th>
                    <th class="text-end">Total (US$)</th>
                    <th class="text-end">Utilidad (US$)</th>
                    <th class="text-end">Total + Util (US$)</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    @foreach ($quote->responses as $response)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $response->nro_response }}</td>
                            <td>{{ optional($response->supplier)->name_businessname ?? '—' }}</td>

                            {{-- Mostrar valores con number_format y proteger nulls --}}
                            <td class="text-end">{{ number_format($response->provider_cost ?? 0, 2) }}</td>
                            <td class="text-end">{{ number_format($response->igv ?? 0, 2) }}</td>
                            <td class="text-end">{{ number_format($response->total_sol ?? 0, 2) }}</td>

                            <td class="text-end">{{ number_format($response->total_usd ?? 0, 2) }}</td>
                            <td class="text-end">{{ number_format($response->value_utility ?? 0, 2) }}</td>
                            <td class="text-end">{{ number_format($response->total_prices_usd ?? 0, 2) }}</td>

                            <td class="status-{{ strtolower($response->status ?? 'enviada') }}">
                                {{ $response->status ?? 'Enviada' }}
                            </td>

                            <td>
                                @if ($locked)
                                    <span class="text-muted">Cotización cerrada</span>
                                @else
                                    @if ($response->status === 'Rechazada')
                                        <span class="text-muted">Rechazada</span>
                                    @elseif ($response->status === 'Aceptado')
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modalRejectResponse" data-response-id="{{ $response->id }}">
                                            Rechazar
                                        </button>
                                    @elseif ($quote->responses->contains('status', 'Aceptado'))
                                        <span class="text-muted">Sin acciones</span>
                                    @else
                                        <button class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#quote-transport" data-response-id="{{ $response->id }}"
                                            data-response-nro="{{ $response->nro_response }}">
                                            Aceptar
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modalRejectResponse" data-response-id="{{ $response->id }}">
                                            Rechazar
                                        </button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    {{-- Modal de “Cerrar Cotización” con selección de respuesta --}}
    <div id="quote-transport" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-labelledby="quote-transport-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ url('/quote/transport/cost/accept/' . $quote->id) }}" id="sendTransportCost"
                    method="POST">
                    @csrf
                    {{ method_field('PATCH') }}

                    <div class="modal-header">
                        <h5 class="modal-title" id="quote-transport-title">
                            {{ $quote->nro_quote }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- 1) Campo solo lectura con la respuesta seleccionada --}}
                        <div class="form-group">
                            <label for="response_display"><strong>Respuesta seleccionada</strong></label>
                            {{-- Valor visible --}}
                            <input type="text" id="response_display" class="form-control" readonly>
                            {{-- Valor real que se envía --}}
                            <input type="hidden" name="response_id" id="response_id">
                        </div>

                        {{-- 4) Fecha aproximada de retiro --}}
                        <div class="form-group">
                            <label for="withdrawal_date">Fecha aproximada de retiro</label>
                            <input id="withdrawal_date" name="withdrawal_date" type="date" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnCerrarCotizacion">
                            Cerrar Cotización
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modalQuoteTransportDocuments" tabindex="-1"
        aria-labelledby="modalQuoteTransportDocumentsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalQuoteTransportDocumentsLabel">Documentos de transporte</h5>
                </div>
                <div class="modal-body">
                    <form action="quote/transport/file-upload-documents" method="post" enctype="multipart/form-data"
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
                            <td>{{ $quote->pick_up }}</td>
                        </tr>
                        <tr>
                            <td><strong>Destino</strong></td>
                            <td>{{ $quote->delivery }}</td>
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
                                    {{ $supplier->shipper_contact_phone }}
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <td><strong>Producto</strong></td>
                            <td>{{ $consolidated->commodity }}</td>
                        </tr>
                        @if ($quote->commercial_quote->type_shipment->description === 'Marítima')
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
                                            {{ $item->height }} {{ $item->unit_measurement }}
                                        </p>
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
                        <td>{{ $quote->pick_up }}</td>
                    </tr>
                    <tr>
                        <td><strong>Destino</strong></td>
                        <td>{{ $quote->delivery }}</td>
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
                                        {{ $item->height }} {{ $item->unit_measurement }}
                                    </p>
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

    {{-- Modal para que Transporte cotice sobre la respuesta del proveedor --}}
    <div id="modalCotizarTransporte" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modalCotizarTransporte-title" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('transport.quote.responses.store') }}"
                    id="formCotizarTransporte">
                    @csrf

                    <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                    {{-- HEADER --}}
                    <div class="modal-header py-2">
                        <h4 class="modal-title mb-0">
                            Respuesta: <strong>{{ $nro_response }}</strong>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    {{-- BODY --}}
                    <div class="modal-body py-2">

                        {{-- Proveedor --}}
                        <div id="row-provider" class="form-group row mb-3 align-items-center">
                            <label for="provider_id" class="col-sm-3 col-form-label small font-weight-bold">
                                Proveedor <span class="text-danger">*</span>
                            </label>
                            <div class="col-sm-9">
                                <x-adminlte-select2 name="provider_id" igroup-size="sm" data-placeholder="Seleccione...">
                                    <option />
                                    @foreach ($transportSuppliers as $sup)
                                        <option value="{{ $sup->id }}"
                                            {{ optional($quote)->provider_id == $sup->id ? 'selected' : '' }}>
                                            {{ $sup->name_businessname }}
                                        </option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>
                        </div>

                        <hr class="my-2">

                        {{-- Exchange + Utilidad global --}}
                        <div id="row-exchange-utility" class="form-row mb-3 align-items-center">
                            <div class="col pr-1">
                                <label for="exchange_rate" class="small">Tipo de cambio (S/.)</label>
                                <input type="number" step="0.0001" name="exchange_rate" id="exchange_rate"
                                    class="form-control form-control-sm is-required" value="3.70">
                            </div>
                            <div class="col px-1">
                                <label for="value_utility" class="small">Tipo de vehiculo</label>
                                <input type="number" step="0.01" class="form-control form-control-sm">
                            </div>
                            <div class="col-auto pl-1">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="includeIgv" class="custom-control-input"
                                        id="includeIgv" {{ isset($insurance) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="includeIgv">Incluir IGV</label>
                                </div>
                            </div>
                        </div>


                        <hr class="my-2">

                        {{-- Encabezados de la “tabla” --}}
                        <div id="row-headers" class="form-row font-weight-bold small mb-2">
                            <div class="col-sm-2">Concepto (S/.)</div>
                            <div class="col-sm-2">Valor concepto (S/.)</div>
                            <div class="col-sm-2">Valor venta (S/.)</div>
                            <div class="col-sm-2">Total (US$)</div>
                            <div class="col-sm-2">Utilidad (US$)</div>
                            <div class="col-sm-2">Costo Venta (US$)</div>
                        </div>

                        {{-- Filas de conceptos --}}
                        @foreach ($quote->transportConcepts->unique('id') as $tc)
                            @if (!empty($tc->name))
                                <div class="form-row mb-2 align-items-center">
                                    {{-- Concepto --}}
                                    <div class="col-sm-2">
                                        <span class="small">{{ $tc->name }}</span>
                                        <input type="hidden" id="name_{{ $tc->name }}"
                                            value="{{ $tc->name }}"
                                            name="conceptTransport[{{ $tc->id }}][name]">
                                    </div>

                                    {{-- Valor concepto (S/.) ← ESTA COLUMNA TIENE CLASS="concept-input" --}}
                                    <div class="col-sm-2">
                                        <input type="number" step="0.01" id="price_{{ $tc->id }}"
                                            data-id="{{ $tc->id }}"
                                            name="conceptTransport[{{ $tc->id }}][price]"
                                            class="form-control form-control-sm text-end concept-input is-required">
                                    </div>

                                    <div class="col-sm-2">
                                        <input type="text" id="priceIgv_{{ $tc->id }}"
                                            name="conceptTransport[{{ $tc->id }}][priceIgv]"
                                            class="form-control form-control-sm text-end" readonly>
                                    </div>

                                    {{-- Total (US$) --}}
                                    <div class="col-sm-2">
                                        <input type="text" id="totalIgvUsd_{{ $tc->id }}"
                                            name="conceptTransport[{{ $tc->id }}][totalusd]"
                                            class="form-control form-control-sm text-end" readonly>
                                    </div>

                                    {{-- Utilidad (US$) ← ESTA COLUMNA TIENE CLASS="concept-utility" --}}
                                    <div class="col-sm-2">
                                        <input type="number" step="0.01" id="utility_{{ $tc->id }}"
                                            data-id="{{ $tc->id }}"
                                            name="conceptTransport[{{ $tc->id }}][utility]"
                                            class="form-control form-control-sm text-end concept-utility is-required">
                                    </div>

                                    {{-- Costo Venta (US$) --}}
                                    <div class="col-sm-2">
                                        <input type="text" id="totalIgvUtilUsd_{{ $tc->id }}"
                                            name="conceptTransport[{{ $tc->id }}][saleprice]"
                                            class="form-control form-control-sm text-end" readonly>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <hr class="my-2">

                        {{-- Total costo venta --}}
                        <div id="row-total-costo" class="form-row justify-content-end mb-2">
                            <div class="col-sm-3 offset-sm-6">
                                <label for="totalCostoVenta" class="small fw-bold">Total costo venta (US$):</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" id="totalCostoVenta" class="form-control form-control-sm text-end"
                                    readonly value="0.00">
                            </div>
                        </div>


                    </div>

                    {{-- FOOTER --}}
                    <div class="modal-footer py-2">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-save mr-1"></i> Guardar
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Cerrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <div class="modal fade" id="modalAcceptResponse" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('transport.quote.accept') }}">
                @csrf
                <input type="hidden" name="response_id" id="accept_response_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Aceptar respuesta del proveedor</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <label>¿Por qué aceptas esta respuesta?</label>
                        <textarea name="justification" class="form-control" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">Aceptar</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalRejectResponse" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('transport.quote.reject') }}">
                @csrf
                <input type="hidden" name="response_id" id="reject_response_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Rechazar respuesta</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Motivo del rechazo</label>
                            <textarea name="justification" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" type="submit">Rechazar</button>
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop


@push('scripts')
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#quote-text').summernote();

            @if (session('open_modal_accept_justification'))
                $('#accept_response_id').val(@json(session('response_id')));

                setTimeout(function() {
                    $('#modalAcceptResponse').appendTo('body').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');
                }, 300);
            @endif
        });


        //TODO: (Task) Poner funcion de forma global para todos los modales que tengan un select2
        $('#modalCotizarTransporte').on('shown.bs.modal', function() {
            $(this).find('#provider_id').select2({
                dropdownParent: $(this),
                width: '100%', // o 'resolve' según prefieras
                placeholder: 'Seleccione una opción...',
                allowClear: true
            });
        });





        let commercial_quote = @json($quote->nro_quote_commercial);
        let transport_quote = @json($quote->nro_quote);


        Dropzone.options.myDropzone = {

            url: '/quote/transport/file-upload-documents', // Ruta para subir los archivos
            maxFilesize: 2, // Tamaño máximo en MB
            acceptedFiles: '.jpg,.jpeg,.png,.gif,.pdf', // Tipos permitidos
            autoProcessQueue: true, // Subir automáticamente al añadir
            params: {
                commercial_quote,
                transport_quote // Envía este dato adicional al servidor
            },

            init: function() {
                let uploadedFiles = []; // Almacena los nombres de archivos subidos
                let myDropzone = this;

                let tableBody = document.querySelector("#table-file-transport tbody");

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
                        axios.post('/quote/transport/file-delete-documents', {

                            filename: response.filename,
                            commercial_quote,
                            transport_quote

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

            axios.post('/quote/transport/file-delete-documents', {
                filename: filename,
                commercial_quote,
                transport_quote
            }).then(response => {
                let listItem = element.parentElement;
                row.remove();
            }).catch(error => {
                console.error('Error al eliminar el archivo:', error);
            });
        }

        // —– 1) Recalcula una sola fila —–
        function recalcRow(id) {
            const exchangeRate = parseFloat(document.getElementById('exchange_rate').value) || 1;
            const price = parseFloat(document.getElementById(`price_${id}`).value) || 0;
            const util = parseFloat(document.getElementById(`utility_${id}`).value) || 0;
            const includeIGV = document.getElementById('includeIgv').checked;

            // precio + IGV en S/
            const withIgv = includeIGV ?
                +(price * 1.18).toFixed(2) :
                price;
            // pasa a USD
            const totalUsd = +(withIgv / exchangeRate).toFixed(2);
            // suma utilidad
            const totalUsdUtil = +(totalUsd + util).toFixed(2);

            // vuelca en los campos de la fila
            document.getElementById(`priceIgv_${id}`).value = withIgv.toFixed(2);
            document.getElementById(`totalIgvUsd_${id}`).value = totalUsd.toFixed(2);
            document.getElementById(`totalIgvUtilUsd_${id}`).value = totalUsdUtil.toFixed(2);

            // y recalc general
            recalcTotalCostoVenta();
        }

        // —– 2) Suma todas las filas para Total Costo Venta —–
        function recalcTotalCostoVenta() {
            let sum = 0;
            document.querySelectorAll('[id^="totalIgvUtilUsd_"]').forEach(input => {
                sum += parseFloat(input.value) || 0;
            });
            document.getElementById('totalCostoVenta').value = sum.toFixed(2);
        }

        // —– 3) Engancha los eventos al cargar la página —–
        document.addEventListener('DOMContentLoaded', () => {
            // cuando cambias precio
            document.querySelectorAll('.concept-input').forEach(input => {
                const id = input.dataset.id;
                input.addEventListener('input', () => recalcRow(id));
            });
            // cuando cambias utilidad
            document.querySelectorAll('.concept-utility').forEach(input => {
                const id = input.dataset.id;
                input.addEventListener('input', () => recalcRow(id));
            });
            // y recalcula todo al principio (por si hay valores precargados)
            document.querySelectorAll('.concept-input, .concept-utility').forEach(input => {
                const id = input.dataset.id;
                recalcRow(id);
            });
        });

        document.getElementById('includeIgv')
            .addEventListener('change', () => {
                document.querySelectorAll('.concept-input, .concept-utility')
                    .forEach(input => recalcRow(input.dataset.id));
            });


        $('#formCotizarTransporte').on('submit', function(e) {
            // Obtener todos los inputs con la clase is-required
            let campos = $(this).find('input.is-required');
            let valido = true;

            // Recorrer los campos y verificar si están vacíos
            campos.each(function() {
                if ($.trim($(this).val()) === '') {
                    valido = false;
                    // Puedes marcar el campo con borde rojo si está vacío
                    $(this).addClass('is-invalid');
                } else {
                    // Remover la clase si ya está lleno
                    $(this).removeClass('is-invalid');
                }
            });

            if (!valido) {
                e.preventDefault(); // Evitar que el formulario se envíe
                alert('Debes completar todos los campos requeridos.');
            }
        });


        $('#quote-transport').on('show.bs.modal', function(e) {
            var modal = $(this);

            // Solo si hay un botón que activó el modal
            if (e.relatedTarget) {
                var button = $(e.relatedTarget);
                var responseId = button.data('response-id');
                var responseNro = button.data('response-nro');

                modal.find('#response_id').val(responseId);
                modal.find('#response_display').val(responseNro);
            }
        });


        $('#detailContainer').on('show.bs.modal', function(event) {
            // Obtener el botón que activó el modal
            var button = $(event.relatedTarget);

            // Extraer el objeto contenedor de los atributos data-*
            var commercialcontainer = button.data(
                'commercialcontainer'); // Convertimos el JSON de vuelta a un objeto

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

        $('#modalRejectResponse').on('show.bs.modal', function(e) {
            $('#reject_response_id').val($(e.relatedTarget).data('response-id'));
        });
    </script>
@endpush

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
                    <div class="col-6">
                        <p class="text-sm">Tipo de embalaje :
                            <b class="d-block">{{ $quote->packaging_type }}</b>
                        </p>
                    </div>
                </div>

                @if ($quote->commercial_quote->type_shipment->description === 'Marítima')

                    <div class="row text-muted">
                        <div class="col-6">
                            <p class="text-sm">Volumen :
                                <b class="d-block">{{ $quote->ton_kilogram }} CBM</b>
                            </p>
                        </div>

                        @if ($quote->commercial_quote->lcl_fcl === 'FCL')
                            <div class="col-6">
                                <p class="text-sm">Toneladas :
                                    <b class="d-block">{{ $quote->ton_kilogram }} TON</b>
                                </p>
                            </div>
                            <div class="col-6">
                                <p class="text-sm">Tipo de contenedor :
                                    <b
                                        class="d-block">{{ $quote->commercial_quote->container_quantity }}x{{ $quote->commercial_quote->container->name }}</b>
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
                    @if (!$quote->responseTransportQuotes->contains('status', 'Aceptado'))
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
                    <th>Costo Neto</th>
                    <th>Comision</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    @foreach ($quote->responseTransportQuotes as $response)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $response->nro_response }}</td>
                            <td>{{ optional($response->supplier)->name_businessname }}</td>
                            <td>{{ $response->provider_cost }}</td>
                            <td>{{ $response->commission }}</td>
                            <td>{{ $response->total }}</td>
                            <td class="status-{{ strtolower($response->state) }}">
                                {{ $response->status }}
                            </td>
                            <td>
                                @if ($locked)
                                    <span class="text-muted">Cotización cerrada</span>
                                @else
                                    @if ($response->status === 'Rechazada')
                                        <span class="text-muted">Rechazada</span>
                                    @elseif ($response->status === 'Aceptado')
                                        {{-- Solo se puede rechazar la aceptada --}}
                                        <button class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#modalRejectResponse" data-response-id="{{ $response->id }}">
                                            Rechazar
                                        </button>
                                    @elseif ($quote->responseTransportQuotes->contains('status', 'Aceptado'))
                                        {{-- Ya hay una aceptada y esta no lo es, no se muestran acciones --}}
                                        <span class="text-muted">Sin acciones</span>
                                    @else
                                        {{-- Aún no hay ninguna aceptada, esta se puede aceptar o rechazar --}}
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
                        {{-- 2) Cuadrilla, si aplica --}}
                        @if ($quote->gang === 'SI')
                            <div class="form-group">
                                <label for="cost_gang">Cuadrilla</label>
                                <input id="cost_gang" name="cost_gang" data-type="currency"
                                    class="form-control CurrencyInput" type="text">
                            </div>
                        @endif

                        {{-- 3) Resguardo, si aplica --}}
                        @if ($quote->guard === 'SI')
                            <div class="form-group">
                                <label for="cost_guard">Resguardo</label>
                                <input id="cost_guard" name="cost_guard" data-type="currency"
                                    class="form-control CurrencyInput" type="text">
                            </div>
                        @endif

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
                                <tr>
                                    <td><strong>Tipo de contenedor</strong></td>
                                    <td>{{ $quote->commercial_quote->container_quantity }}x{{ $quote->commercial_quote->container->name }}
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
                            <tr>
                                <td><strong>Tipo de contenedor</strong></td>
                                <td>{{ $quote->commercial_quote->container_quantity }}x{{ $quote->commercial_quote->container->name }}
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('transport.quote.responses.store', $quote->id) }}"
                    id="formCotizarTransporte">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCotizarTransporte-title">Respuesta Proveedor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="modal-body">
                        {{-- Fila: Proveedor + RPTA --}}
                        <div class="form-row align-items-center mb-4">
                            <div class="col-md-8">
                                <label for="provider_id">Proveedor <span class="text-danger">*</span></label>
                                <x-adminlte-select2 name="provider_id" igroup-size="md"
                                    data-placeholder="Seleccione una opcion...">
                                    <option />
                                    @foreach ($transportSuppliers as $sup)
                                        <option value="{{ $sup->id }}"
                                            {{ optional($quote)->provider_id == $sup->id ? 'selected' : '' }}>
                                            {{ $sup->name_businessname }}
                                        </option>
                                    @endforeach

                                </x-adminlte-select2>
                            </div>




                            <div class="col-md-4 text-right">
                                <div class="bg-light p-3 rounded">
                                    <div class="small text-muted mb-1">RPTA</div>
                                    <b class="d-block">{{ $nro_response }}</b>
                                </div>
                            </div>
                        </div>


                        <hr class="mb-4">

                        {{-- Conceptos elegidos por Comercial --}}
                        <div class="mb-4">
                            <h4 class="mb-3">Precios de conceptos</h4>

                            @foreach ($quote->transportConcepts->unique('id') as $tc)
                                @if (!empty($tc->name))
                                    <div class="form-group row">
                                        <label class="col-sm-6 col-form-label font-weight-bold">
                                            {{ $tc->name }}
                                        </label>
                                        <div class="col-sm-6">
                                            <input type="number" step="0.01"
                                                name="price_concept[{{ $tc->id }}]"
                                                class="form-control concept-input" value="">
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <hr class="my-4">

                            {{-- Comisión --}}
                            <div class="form-group row">
                                <label for="commission" class="col-sm-6 col-form-label font-weight-bold">
                                    Comisión
                                </label>
                                <div class="col-sm-6">
                                    <input type="number" step="0.01" name="commission" id="commission"
                                        class="form-control concept-input" value="">
                                </div>
                            </div>

                            {{-- Total general (sólo lectura) --}}
                            <div class="form-group row mt-4">
                                <label class="col-sm-6 font-weight-bold">Total</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="totalConceptos" readonly
                                        value="0.00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save mr-2"></i> Guardar respuesta
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i> Cerrar
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
                <input type="hidden" name="withdrawal_date" id="hidden_withdrawal_date">
                <input type="hidden" name="cost_gang" id="hidden_cost_gang">
                <input type="hidden" name="cost_guard" id="hidden_cost_guard">
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

            // 1) Inicializar tus plugins normales
            $('#quote-text').summernote();

            // 2) Delegar el click / submit de “Cerrar Cotización”
            $(document)
                // click en el botón → disparamos el submit
                .on('click', '#btnCerrarCotizacion', function(e) {
                    e.preventDefault();
                    $('#sendTransportCost').submit();
                })
                // submit del form → recogemos datos, cerramos el primer modal y abrimos el segundo
                .on('submit', '#sendTransportCost', function(e) {
                    e.preventDefault();
                    const $f = $(this);
                    const respId = $f.find('#response_id').val();
                    const retiro = $f.find('#withdrawal_date').val();
                    const gang = $f.find('#cost_gang').val();
                    const guard = $f.find('#cost_guard').val();

                    // inyectamos en el modal de justificación
                    $('#accept_response_id').val(respId);
                    $('#hidden_withdrawal_date').val(retiro);
                    $('#hidden_cost_gang').val(gang);
                    $('#hidden_cost_guard').val(guard);

                    // cerramos el primero y, cuando termine de ocultarse, abrimos el segundo
                    $('#quote-transport')
                        .one('hidden.bs.modal', function() {
                            $('#modalAcceptResponse').modal('show');
                        })
                        .modal('hide');
                });

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

        function recalcTotal() {
            let sum = 0;
            document.querySelectorAll('.concept-input').forEach(i => {
                sum += parseFloat(i.value) || 0;
            });
            document.getElementById('totalConceptos').value = sum.toFixed(2);
        }
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.concept-input')
                .forEach(i => i.addEventListener('input', recalcTotal));
            recalcTotal();
        });


        (function() {
            const form = document.getElementById('formCotizarTransporte');

            // Campos que validamos:
            const providerSelect = document.getElementById('provider_id');
            const conceptInputs = Array.from(document.querySelectorAll('.concept-input'));
            const commissionInput = document.getElementById('commission');

            form.addEventListener('submit', function(e) {
                // 1) Limpia errores anteriores
                form.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
                form.querySelectorAll('.invalid-feedback').forEach(feedback => {
                    feedback.remove();
                });

                let hasError = false;

                // 2) Valida proveedor
                if (!providerSelect.value) {
                    markInvalid(providerSelect, 'Seleccione un proveedor.');
                    hasError = true;
                }

                // 3) Valida cada concepto
                conceptInputs.forEach(input => {
                    const val = input.value.trim();
                    if (val === '' || isNaN(parseFloat(val))) {
                        const label = input.closest('.form-group')
                            .querySelector('label')
                            .innerText.replace(/ *\(.+\)$/, '');
                        markInvalid(input, `Complete el precio de "${label}".`);
                        hasError = true;
                    }
                });

                // 4) Valida comisión
                const comm = commissionInput.value.trim();
                if (comm === '' || isNaN(parseFloat(comm))) {
                    markInvalid(commissionInput, 'Ingrese la comisión.');
                    hasError = true;
                }

                if (hasError) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                // Si no hay errores, el formulario se envía normalmente.
            });

            // Función helper para marcar invalidez
            function markInvalid(inputEl, message) {
                inputEl.classList.add('is-invalid');
                const feedback = document.createElement('div');
                feedback.className = 'invalid-feedback';
                feedback.innerText = message;
                // asegúrate de insertarlo justo después del input
                inputEl.parentNode.appendChild(feedback);
            }
        })();

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




        $('#modalAcceptResponse').on('show.bs.modal', function(e) {
            $('#accept_response_id').val($(e.relatedTarget).data('response-id'));
        });
        $('#modalRejectResponse').on('show.bs.modal', function(e) {
            $('#reject_response_id').val($(e.relatedTarget).data('response-id'));
        });
    </script>
@endpush

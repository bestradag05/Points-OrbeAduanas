@extends('home')


@section('dinamic-content')

    <div class="row">

        {{-- <div class="col-12  mb-4 text-right">
            <a href="{{ url('/quote/freight') }}" class="btn btn-primary"> Atras </a>
        </div> --}}
        <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
            <div class="card direct-chat direct-chat-primary h-100">
                <div class="card-header bg-sisorbe-100 py-2">
                    <h5 class="text-center text-bold text-uppercase text-indigo">Cotizacion : {{ $quote->nro_quote }}</h5>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    <div class="direct-chat-messages h-100">
                        @foreach ($messages as $message)
                            <div class="direct-chat-msg {{ $message->sender_id != auth()->user()->id ? 'right' : '' }}">
                                <div class="direct-chat-infos clearfix">
                                    <span
                                        class="direct-chat-name float-left text-indigo text-bold">{{ $message->sender->personal->names }}</span>
                                    <span
                                        class="direct-chat-timestamp float-right text-bold">{{ $message->created_at }}</span>
                                </div>
                                @if ($message->sender->personal->img_url !== null)
                                    <img src="{{ asset('storage/' . $message->sender->personal->img_url) }}"
                                        class="direct-chat-img" alt="User Image">
                                @else
                                    <img src="{{ asset('storage/personals/user_default.png') }}" class="direct-chat-img"
                                        alt="User Image">
                                @endif
                                <div class="direct-chat-text">
                                    {!! $message->message !!}
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="card-footer">
                    <form action="/quote/freight/message" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <textarea id="quote-text" name="message"></textarea>
                                <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                            </div>
                            <div class="col-12 row align-items-center justify-content-center mt-2">
                                <button type="submit"
                                    {{ $quote->state === 'Borrador' || $quote->state === 'Aceptada' ? 'disabled' : '' }}
                                    class="btn btn-indigo">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2 px-4">
            <h5 class="text-indigo text-center"><i class="fas fa-file-alt"></i> Detalle de carga</h5>

            <br>

            <div class="row text-muted">
                <div class="col-6">
                    <p class="text-sm">N° Cotizacion General :
                        <b class="d-block">{{ $quote->nro_quote_commercial }}</b>
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

                @if ($quote->commercial_quote->lcl_fcl === 'LCL' || $quote->commercial_quote->lcl_fcl === null)
                    <div class="row text-muted">
                        <div class="col-6">
                            <p class="text-sm">Cubicaje/KGV :
                                <b class="d-block">{{ $quote->cubage_kgv }}</b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="text-sm">Peso total :
                                <b class="d-block">{{ $quote->total_weight }}</b>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="row text-muted">
                        <div class="col-6">
                            <p class="text-sm">Tipo de contenedor :
                                <b class="d-block">{{ $quote->container_type }}</b>
                            </p>
                        </div>
                        <div class="col-6">
                            <p class="text-sm">Toneladas/Kilogramos :
                                <b class="d-block">{{ $quote->ton_kilogram }}</b>
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
                    <button class="btn btn-indigo btn-sm" data-toggle="modal" data-target="#modalQuoteFreightDocuments">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
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
                            <td class="text-center {{ $quote->state === 'Aceptado' ? 'd-none' : '' }}"">
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
            @if ($quote->ocean_freight != null && $quote->state === 'Aceptada')
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
                                <b class="d-inline">$ {{ $quote->ocean_freight }}</b>
                            </div>

                        </div>
                        <div class="row text-muted">
                            <div class="col-4">
                                <p class="text-sm"> Orbe (utilidad) :
                                </p>
                            </div>
                            <div class="col-6">
                                <b class="d-inline">$ {{ $quote->utility }}</b>
                            </div>

                        </div>
                        <div class="row text-muted">
                            <div class="col-4">
                                <p class="text-sm">Operaciones :
                                </p>
                            </div>
                            <div class="col-6">
                                <b class="d-inline">$ {{ $quote->operations_commission }}</b>
                            </div>

                        </div>
                        <div class="row text-muted">
                            <div class="col-4">
                                <p class="text-sm">Pricing :
                                </p>
                            </div>
                            <div class="col-6">
                                <b class="d-inline">$ {{ $quote->pricing_commission }}</b>
                            </div>

                        </div>

                        <div class="row text-muted mt-3 ">
                            <div class="col-12 row justify-content-center">
                                <p class="text-uppercase text-bold text-lg">Costo del Flete :
                                    <b class="status-{{ strtolower($quote->state) }}">$
                                        {{ $quote->total_ocean_freight }}</b>
                                </p>
                            </div>

                        </div>


                    </div>


                </div>
            @endif


            <div class="text-center mt-5 mb-3">
                <button class="btn btn-sm btn-success {{ $quote->state === 'Aceptado' ? 'd-none' : '' }}" type="button"
                    data-toggle="modal" data-target="#quote-freight">Cotización Aceptada</button>


                <button onclick="copieDetailQuote()" class="btn btn-sm btn-secondary">
                    <i class="fas fa-copy"></i>
                    Copiar detalle
                </button>

            </div>
        </div>
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


    {{-- Template para copiar y enviar por Outlook --}}


    <div id="plantilla-cotizacion" class="d-none">
        @if ($quote->commercial_quote->is_consolidated)

            @foreach ($quote->commercial_quote->consolidatedCargos as $consolidated)
                <p>• SHIPPER {{ $loop->iteration }} :</p>

                <table border="1" cellpadding="4" cellspacing="0"
                    style="border-collapse: collapse;min-width: 500px">
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
                            <tr>
                                <td><strong>Tipo de contenedor</strong></td>
                                <td>{{ $quote->container_type }}</td>
                            </tr>
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
            <table border="1" cellpadding="4" cellspacing="0" style="border-collapse: collapse;min-width: 500px">
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
                            <td><strong>Tipo de contenedor</strong></td>
                            <td>{{ $quote->container_type }}</td>
                        </tr>
                        <tr>
                            <td><strong>Volumen</strong></td>
                            <td>{{ $quote->cubage_kgv }} CBM</td>
                        </tr>

                        @if ($quote->commercial_quote->lcl_fcl === 'FCL')
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
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#quote-text').summernote();
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

        })



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
    </script>

    <script>
        let commercial_quote = @json($quote->nro_quote_commercial);
        let freight_quote = @json($quote->nro_quote);

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

                    console.log(tableBody);

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

        function copieDetailQuote() {

            const plantilla = document.getElementById("plantilla-cotizacion");
            const blob = new Blob([plantilla.innerHTML], {
                type: "text/html"
            });
            const item = new ClipboardItem({
                "text/html": blob
            });

            htmlToImage.toPng(plantilla)
                .then(function(dataUrl) {
                    var img = new Image();
                    img.src = dataUrl;
                    document.body.appendChild(img);
                })
                .catch(function(error) {
                    console.error('Oops, something went wrong!', error);
                });


            navigator.clipboard.write([item])
                .then(() => toastr.success("Detalle copiado en portapapeles !"))
                .catch(() => toastr.error("❌ No se pudo copiar al portapapeles."));

        }
    </script>
@endpush

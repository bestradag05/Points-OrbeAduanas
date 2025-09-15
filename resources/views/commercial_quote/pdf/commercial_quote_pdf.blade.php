<!doctype html>
<html lang="en">

<head>
    <title>Cotizacion Comercial</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>
        body {
            font-size: 10px;
            border: 2px solid #000;
            overflow: hidden;
            position: relative;

        }

        .title {
            text-align: center;
        }

        .image {
            width: 180px;
            text-align: center;
        }

        .image img {
            width: 100%;
            height: auto;
            max-height: 80px;
        }

        .title {
            width: 100%;
            text-align: center;

            /* Simula la segunda línea */
        }

        .title h1 {
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            text-decoration-thickness: 2px;
            text-shadow: 0px 3px 0px #234195;
            color: #234195;

        }

        .detail {
            width: 90%;
            display: table;
            margin-top: 30px;

            /* Hace que el contenedor actúe como tabla */
        }

        .items-detail {
            display: table-cell;
            /* Hace que los elementos se alineen en la misma fila */
            width: 50%;
            /* Distribuye cada tabla al 50% */
            vertical-align: top;
            /* Alinea el contenido arriba */
        }

        .items-detail table {

            width: 100%;
            /* Hace que las tablas ocupen todo el ancho del contenedor */
            border-collapse: collapse;
        }

        .detail .items-detail:first-child table {
            border: 1px solid #000;
            border-left: none;
            border-bottom: none;
            /* Agrega borde para mejor visualización */
        }

        .detail .items-detail:last-child table {
            margin-top: 20px;
            /* Agrega borde para mejor visualización */
        }

        .detail .items-detail:last-child table td {
            text-align: right;
            /* Agrega borde para mejor visualización */
        }

        .items-detail td {
            padding: 5px;
            /* Agrega borde para mejor visualización */
        }

        .title-table {
            background: #234195;
            padding: 10px;
            color: white;
            text-transform: uppercase;
        }

        .title-item-table {
            color: #234195;
            text-transform: uppercase;
            font-weight: bold;

        }

        #detail-freight {
            width: 100%;
        }

        .container-service table {
            width: 100%;
        }

        .table {
            border-collapse: collapse;
        }

        .table th {
            background: #7A9CC7;
            padding: 5px;
            color: white
        }

        .table td {
            padding: 5px;
        }

        .table td#observation {
            width: 20%;
            text-align: center;
        }

        th {
            text-transform: uppercase;
        }

        .table td:last-child {
            text-align: right;
        }

        .total-service {
            background: #FFC000;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        #detail-quote {
            width: 100%;
            display: table;
        }


        .item-detail-quote {
            display: table-cell;
            /* Hace que los elementos se alineen en la misma fila */
            width: 50%;
            /* Distribuye cada tabla al 50% */
            vertical-align: top;
            /* Alinea el contenido arriba */
        }

        #detail-quote .item-detail-quote:first-child {
            border: 2px solid black;
            border-left: none;
            padding: 5px;
        }

        #detail-quote .item-detail-quote:first-child p {
            text-transform: uppercase;
            text-decoration: underline;
            font-weight: bold;
        }

        #detail-quote .item-detail-quote:first-child ul {
            text-align: justify;
            list-style: none;
            padding: 0;
            margin: 0;

        }

        #detail-quote .item-detail-quote:first-child ul li {
            margin-bottom: 5px;

        }


        .item-detail-quote:last-child {
            position: relative;
            /* Necesario para que el hijo absoluto se posicione dentro */
            height: 215px;
            /* Ajusta según tu necesidad */
        }

        .total-quote {
            background: #48c759;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: auto;
            /* Para que ocupe todo el ancho */
            text-align: center;
            /* Alinear texto si es necesario */
            padding: 10px;
            font-weight: bold;
            text-transform: uppercase;
            /* Espaciado opcional */
            font-size: 12px;

        }

        .total-info {
            font-size: 8px;
            display: block;
            margin-top: 10px;
            color: #234195;
            font-weight: bold;
        }


        .footer-quote {
            text-align: center;
        }

        .footer-quote p {
            margin: 0;
            margin-top: 5px;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 110%;
            height: 100%;
            background-image: url('{{ public_path('vendor/adminlte/dist/img/logoorbe.png') }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.1;
            z-index: -1;
            transform: translate(-50%, -50%) rotate(-45deg);
            /* Rotación en diagonal */
        }
    </style>


</head>

<body>
    {{-- 
    <div class="image">
        <img src="{{ public_path('vendor/adminlte/dist/img/logoorbe.png') }}">
    </div> --}}

    <div class="watermark"></div>


    @if (in_array('Transporte', $quoteSentClient->services_to_quote) && count($quoteSentClient->services_to_quote) == 1)
        <div class="title">
            <h1>Cotizacion de transporte </h1>
            <h3>N ° {{ $quoteSentClient->nro_quote_commercial }}</h3>

        </div>
    @else
        <div class="title">
            <h1>Cotizacion {{ $quoteSentClient->type_shipment->description }} </h1>
            <h3>N ° {{ $quoteSentClient->nro_quote_commercial }}</h3>

        </div>
    @endif

    <div class="detail">
        <div class="items-detail">

            @if (in_array('Transporte', $quoteSentClient->services_to_quote) && count($quoteSentClient->services_to_quote) == 1)
                <table>
                    <thead>
                        <th colspan="2" class="title-table">Detalles de la carga</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="title-item-table">Origen</td>
                            <td class="text-item-table">
                                {{ $quoteSentClient->commercialQuote->transport->origin }}
                            </td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Destino</td>
                            <td class="text-item-table">
                                {{ $quoteSentClient->commercialQuote->transport->destination }}
                            </td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Cliente</td>
                            <td class="text-item-table">
                                {{ $quoteSentClient->customer->name_businessname ?? $quoteSentClient->customer_company_name }}
                            </td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Tipo de embarque</td>
                            <td class="text-item-table">{{ $quoteSentClient->type_shipment->name }}</td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Tipo de carga</td>
                            <td class="text-item-table">{{ $quoteSentClient->type_load->name }}</td>
                        </tr>

                        <tr>
                            <td class="title-item-table">Bultos</td>
                            <td class="text-item-table">{{ $quoteSentClient->nro_package }}</td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Volumen</td>
                            <td class="text-item-table">{{ $quoteSentClient->volumen }} CBM</td>
                        </tr>

                        @if ($quoteSentClient->lcl_fcl === 'FCL')
                            <tr>
                                <td class="title-item-table">Peso total</td>
                                <td class="text-item-table">{{ $quoteSentClient->tons }} TONS</td>

                            </tr>
                        @else
                            <tr>
                                <td class="title-item-table">Peso total</td>
                                <td class="text-item-table">{{ $quoteSentClient->kilograms }} KG</td>

                            </tr>
                        @endif


                    </tbody>
                </table>
            @else
                <table>
                    <thead>
                        <th colspan="2" class="title-table">Detalles de la carga</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="title-item-table">Cliente</td>
                            <td class="text-item-table">
                                {{ $quoteSentClient->customer->name_businessname ?? $quoteSentClient->customer_company_name }}
                            </td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Puerto de salida</td>
                            <td class="text-item-table"> {{ $quoteSentClient->originState->country->name }} -
                                {{ $quoteSentClient->originState->name }}</td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Puerto de llegada</td>
                            <td class="text-item-table">{{ $quoteSentClient->destinationState->country->name }} -
                                {{ $quoteSentClient->destinationState->name }}</td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Incoterm</td>
                            <td class="text-item-table">{{ $quoteSentClient->incoterm->code }}</td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Tipo de embarque</td>
                            <td class="text-item-table">{{ $quoteSentClient->type_shipment->name }}</td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Tipo de carga</td>
                            <td class="text-item-table">{{ $quoteSentClient->type_load->name }}</td>
                        </tr>
                        @if ($quoteSentClient->is_consolidated)

                            <tr>
                                <td class="title-item-table">Bultos</td>
                                <td class="text-item-table">{{ $quoteSentClient->nro_package }}</td>
                            </tr>
                            <tr>
                                <td class="title-item-table">Volumen / KGV</td>
                                @if ($quoteSentClient->volumen)
                                    <td class="text-item-table">{{ $quoteSentClient->volumen }} CBM</td>
                                @else
                                    <td class="text-item-table">{{ $quoteSentClient->kilogram_volumen }} KGV</td>
                                @endif
                            </tr>
                            <tr>
                                <td class="title-item-table">Peso total</td>
                                <td class="text-item-table">{{ $quoteSentClient->kilograms }} KG</td>
                            </tr>
                        @else
                            <tr>
                                <td class="title-item-table">Bultos</td>
                                <td class="text-item-table">{{ $quoteSentClient->nro_package }}</td>
                            </tr>
                            <tr>
                                <td class="title-item-table">Volumen</td>
                                <td class="text-item-table">{{ $quoteSentClient->volumen }} CBM</td>
                            </tr>

                            @if ($quoteSentClient->lcl_fcl === 'FCL')
                                <tr>
                                    <td class="title-item-table">Peso total</td>
                                    <td class="text-item-table">{{ $quoteSentClient->tons }} TONS</td>

                                </tr>
                            @else
                                <tr>
                                    <td class="title-item-table">Peso total</td>
                                    <td class="text-item-table">{{ $quoteSentClient->kilograms }} KG</td>

                                </tr>
                            @endif


                        @endif
                        <tr>
                            <td class="title-item-table">Valor de factura</td>
                            <td class="text-item-table">{{ $quoteSentClient->load_value }}</td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Valor CIF</td>
                            <td class="text-item-table">{{ $quoteSentClient->cif_value }}</td>
                        </tr>
                        {{--  <tr>
                        <td class="title-item-table">Valor Cif</td>
                        <td class="text-item-table">{{ $commercialQuote->type_shipment->name }}</td>
                    </tr> --}}
                    </tbody>
                </table>

            @endif


        </div>

        <div class="items-detail">

            <table>
                <tbody>
                    <tr>
                        <td class="title-item-table">Fecha de Creacion</td>
                        <td class="text-item-table" style="font-weight: bold">
                            {{ $quoteSentClient->created_at->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">ReF ##</td>
                        <td class="text-item-table" style="font-weight: bold">
                            {{ $quoteSentClient->commercialQuote->nro_quote_commercial }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">Fecha de Validez</td>
                        <td class="text-item-table" style="font-weight: bold">
                            {{ $quoteSentClient->valid_until->format('d/m/Y') }}</td>

                    </tr>

                </tbody>
            </table>

        </div>
    </div>



    @if ($freightConcepts->isNotEmpty())
        @php
            // Dividir los conceptos en dos grupos: con IGV y sin IGV
            $conceptsWithoutIgv = $freightConcepts->filter(function ($concept) {
                return $concept->pivot->has_igv === 0;
            });

            $conceptsWithIgv = $freightConcepts->filter(function ($concept) {
                return $concept->pivot->has_igv === 1;
            });

            // Calcular los montos y subtotales
            $subtotalWithoutIgv = $conceptsWithoutIgv->sum(function ($concept) {
                return $concept->pivot->concept_value;
            });

            $subtotalWithIgv = $conceptsWithIgv->sum(function ($concept) {
                return $concept->pivot->concept_value;
            });

            // Calcular el total
            $total = $subtotalWithoutIgv + $subtotalWithIgv;
        @endphp

        <div id="detail-freight" class="container-service">
            <table id="table-freight" class="table">
                <thead>
                    <th style="width: 45%; background-color: #234195">Flete Maritimo</th>
                    <th style="width: 40%">Observacion</th>
                    <th style="width: 15%">Total</th>
                </thead>
                <tbody>
                    {{-- Mostrar los conceptos sin IGV --}}
                    @foreach ($conceptsWithoutIgv as $concept)
                        <tr>
                            <td>{{ $concept->name }}</td>
                            <td id="observation"> - </td>
                            <td> $ {{ number_format($concept->pivot->concept_value, 2) }}</td>
                        </tr>
                    @endforeach

                    {{-- Subtotal sin IGV --}}
                    <tr class="total-service">
                        <td colspan="2" style="text-align: right">Subtotal:</td>
                        <td> $ {{ number_format($subtotalWithoutIgv, 2) }}</td>
                    </tr>

                    {{-- Mostrar los conceptos con IGV --}}
                    @foreach ($conceptsWithIgv as $concept)
                        <tr>
                            <td>{{ $concept->name }}</td>
                            <td id="observation"> - </td>
                            <td> $ {{ number_format($concept->pivot->concept_value, 2) }}</td>
                        </tr>
                    @endforeach

                    {{-- Total --}}
                    <tr class="total-service">
                        <td colspan="2" style="text-align: right">Total Flete:</td>
                        <td> $ {{ number_format($total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif



    @if ($customConcepts->isNotEmpty())

        <div id="detail-taxes-custom" class="container-service">
            <table id="table-taxes-custom" class="table">
                <thead>
                    <th style="width: 45%; background-color: #234195">Impuesto de aduanas</th>
                    <th style="width: 40%">Impuestos</th>
                    <th style="width: 15%">Total Aprox.</th>
                </thead>
                <tbody>
                    <tr>
                        <td>IMPUESTOS DE ADUANAS </td>
                        <td>(ADV. 0% + IGV 16% + IPM 2%) X VALOR CIF</td>
                        <td>$ {{ $quoteSentClient->customs_taxes }}</td>
                    </tr>
                    <tr>
                        <td>PERCEPCIÓN ADUANAS </td>
                        <td>3.5% X ( CIF+ IMPUESTOS DE ADUANAS)</td>
                        <td>$ {{ $quoteSentClient->customs_perception }}</td>
                    </tr>

                    <tr class="total-service">
                        <td colspan="2" style="text-align: right">* Total impuestos:</td>
                        <td> $
                            {{ number_format($quoteSentClient->customs_taxes + $quoteSentClient->customs_perception, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="detail-custom" class="container-service">
            <table id="table-custom" class="table">
                <thead>
                    <th style="width: 45%; background-color: #234195">Gastos en destino</th>
                    <th style="width: 40%">Observacion</th>
                    <th style="width: 15%">Total</th>
                </thead>
                <tbody>
                    @foreach ($customConcepts as $concept)
                        <tr>
                            <td>{{ $concept->name }}</td>
                            @if ($concept->name === 'AGENCIAMIENTO DE ADUANAS')
                                <td id="observation"> 0.4 % x fob / min $100.00 </td>
                            @else
                                <td id="observation"> - </td>
                            @endif
                            <td> $ {{ $concept->pivot->concept_value }}</td>
                        </tr>
                    @endforeach

                    @if ($transportConcepts->isNotEmpty())

                        @foreach ($transportConcepts as $concept)
                            <tr>
                                <td>{{ $concept->name }}</td>
                                <td id="observation"> - </td>
                                <td> $ {{ number_format($concept->pivot->concept_value / 1.18, 2) }}</td>
                            </tr>
                        @endforeach


                        @php
                            $subtotal =
                                $quoteSentClient->total_custom + ($quoteSentClient->total_transport / 1.18 ?? 0);
                            $igv = $subtotal * 0.18;
                            $cats_destinations = $subtotal * 1.18;

                        @endphp


                        <tr class="total-service">
                            <td colspan="2" style="text-align: right">Sub Total:</td>
                            <td> $ {{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr class="total-service">
                            <td colspan="2" style="text-align: right">IGV:</td>
                            <td> $ {{ number_format($igv, 2) }}</td>
                        </tr>
                        <tr class="total-service">
                            <td colspan="2" style="text-align: right">Total:</td>
                            <td> $ {{ number_format($cats_destinations, 2) }}</td>
                        </tr>
                    @else
                        @php
                            $subtotal = $quoteSentClient->total_custom;
                            $igv = $subtotal * 0.18;
                            $cats_destinations = $subtotal * 1.18;

                        @endphp


                        <tr class="total-service">
                            <td colspan="2" style="text-align: right">Sub Total:</td>
                            <td> $ {{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr class="total-service">
                            <td colspan="2" style="text-align: right">IGV:</td>
                            <td> $ {{ number_format($igv, 2) }}</td>
                        </tr>
                        <tr class="total-service">
                            <td colspan="2" style="text-align: right">Total:</td>
                            <td> $ {{ number_format($cats_destinations, 2) }}</td>
                        </tr>

                    @endif



                </tbody>
            </table>
        </div>
    @else
        @if ($transportConcepts->isNotEmpty())

            <div id="detail-transport" class="container-service">
                <table id="table-transport" class="table">
                    <thead>
                        <th style="width: 45% ; background-color: #234195">Gastos en destino</th>
                        <th style="width: 40%">Observacion</th>
                        <th style="width: 15%">Total</th>
                    </thead>
                    <tbody>
                        @foreach ($transportConcepts as $concept)
                            <tr>
                                <td>{{ $concept->name }}</td>
                                <td id="observation"> - </td>
                                <td> $ {{ number_format($concept->pivot->concept_value / 1.18, 2) }}</td>
                            </tr>
                        @endforeach


                        @php
                            $subtotal = $quoteSentClient->total_transport / 1.18;
                            $igv = $subtotal * 0.18;
                            $cats_destinations = $subtotal * 1.18;

                        @endphp


                        <tr class="total-service">
                            <td colspan="2" style="text-align: right">Sub Total:</td>
                            <td> $ {{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr class="total-service">
                            <td colspan="2" style="text-align: right">IGV:</td>
                            <td> $ {{ number_format($igv, 2) }}</td>
                        </tr>
                        <tr class="total-service">
                            <td colspan="2" style="text-align: right">Total:</td>
                            <td> $ {{ number_format($cats_destinations, 2) }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>

        @endif

    @endif


    <div class="container-footer-quote">

        <div id="detail-quote">

            <div class="item-detail-quote">
                <p>Observaciones: </p>

                <ul>
                    <li>1. TARIFA SUJETA A LAS CARACTERISTICAS REALES DE LA
                        MERCADERIA, COMMODITIES SEGÚN EL MERCADO INTERNACIONAL
                        Y CONDICIONES DE EMBARQUE.
                    </li>
                    <li>
                        2. SUJETO LOS COSTOS LOGISTICOS DE ACUERDO AL
                        PROCEDIMIENTO A LA LINEA AEREA, LINEA NAVIERA, EMPRESA DE
                        TRANSPORTE INTERNACIONAL, REGISTRADA EN EL CONVENIO
                        INTERNACINAL DE VARSOVIA , MONTREAL Y REGISTRO DE
                        COMERCIO INTERNACIONAL DE EEUU.
                    </li>
                    <li>
                        3. COTIZACION SUJETA A VARIACION DE ACUERDO A ESTRUCTURA Y CONSOLIDACION DE EMBARQUE GENERADA EN
                        ORIGEN.
                    </li>
                    <li>
                        4. LOS COSTOS QUE SE INDICARON COMO APROXIMADOS EN LA COTIZACION ESTAN SUJETAS A LA FACTURACION
                        FINAL DE LOS OPERADORES DE SERVICIO EN DESTINO PERU.
                    </li>
                </ul>

            </div>

            <div class="item-detail-quote">
                {{-- TODO: Modificar para calcular el total de forma automatica --}}
                <div class="total-quote">
                    TOTAL COTIZACION: $
                    {{ number_format($quoteSentClient->total_quote_sent_client, 2) }}
                    <span class="total-info">*Este precio no incluye el pago de impuestos*</span>
                </div>

            </div>

        </div>

        <div class="footer-quote">

            <p>Si usted tiene alguna pregunta sobre esta cotización, por favor, pónganse en contacto con nosotros</p>
            <p>[{{ $personal->names }} {{ $personal->last_name }}, +51 {{ $personal->cellphone }},
                {{ $personal->user->email }}]</p>
            <p style="font-weight: bold">Gracias por hacer negocios con nosotros!</p>
        </div>

    </div>





</body>

</html>

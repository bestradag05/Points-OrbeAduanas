<!doctype html>
<html lang="en">

<head>
    <title>Cotizacion Comercial</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>
        body {
            font-size: 12px;
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
            width: 100%;
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
            background: #234195;
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

        .table td:last-child {
            text-align: right;
        }

        .total-service {
            background: #FFC000;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
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
            margin-bottom: 10px;

        }


        .item-detail-quote:last-child {
            position: relative;
            /* Necesario para que el hijo absoluto se posicione dentro */
            height: 321px;
            /* Ajusta según tu necesidad */
        }

        .total-quote {
            background: #FFC000;
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

        }


        .footer-quote {
            text-align: center;
        }

        .footer-quote p {
            margin: 0;
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="image">
        <img src="{{ public_path('vendor/adminlte/dist/img/logoorbe.png') }}">
    </div>

    <div class="title">
        <h1>Cotizacion {{ $commercialQuote->type_shipment->description }} </h1>

    </div>

    <div class="detail">
        <div class="items-detail">

            <table>
                <thead>
                    <th colspan="2" class="title-table">Detalles de la carga</th>
                </thead>
                <tbody>
                    <tr>
                        <td class="title-item-table">Cliente</td>
                        <td class="text-item-table">{{ $commercialQuote->customer_company_name }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">Puerto de salida</td>
                        <td class="text-item-table">{{ $commercialQuote->origin }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">Puerto de llegada</td>
                        <td class="text-item-table">{{ $commercialQuote->destination }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">Incoterm</td>
                        <td class="text-item-table">{{ $commercialQuote->incoterm->code }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">Tipo de embarque</td>
                        <td class="text-item-table">{{ $commercialQuote->type_shipment->name }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">Bultos</td>
                        <td class="text-item-table">{{ $commercialQuote->nro_package }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">Volumen</td>
                        <td class="text-item-table">{{ $commercialQuote->volumen }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">Peso total</td>
                        <td class="text-item-table">{{ $commercialQuote->tons }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">Valor de factura</td>
                        <td class="text-item-table">{{ $commercialQuote->load_value }}</td>
                    </tr>
                    {{--  <tr>
                        <td class="title-item-table">Valor Cif</td>
                        <td class="text-item-table">{{ $commercialQuote->type_shipment->name }}</td>
                    </tr> --}}
                </tbody>
            </table>

        </div>

        <div class="items-detail">

            <table>
                <tbody>
                    <tr>
                        <td class="title-item-table">Fecha</td>
                        <td class="text-item-table" style="font-weight: bold">
                            {{ $commercialQuote->created_at->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">Cotizacion #</td>
                        <td class="text-item-table" style="font-weight: bold">
                            {{ $commercialQuote->nro_quote_commercial }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">Fecha de Validez</td>
                        <td class="text-item-table" style="font-weight: bold">
                            {{ $commercialQuote->created_at->format('d/m/Y') }}</td>

                    </tr>

                </tbody>
            </table>

        </div>
    </div>


    @if ($freight)

        <div id="detail-freight" class="container-service">
            <table id="table-freight" class="table">
                <thead>
                    <th>Flete Maritimo</th>
                    <th>Observacion</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    @foreach ($freight->concepts as $concept)
                        <tr>
                            <td>{{ $concept->name }}</td>
                            <td id="observation"> - </td>
                            <td> $ {{ $concept->pivot->total_value_concept }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-service">
                        <td colspan="2" style="text-align: right">Total Flete:</td>
                        <td> $ {{ $freight->value_freight }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    @endif



    @if ($transport)

        <div id="detail-transport" class="container-service">
            <table id="table-transport" class="table">
                <thead>
                    <th>Transporte</th>
                    <th>Observacion</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    @foreach ($transport->concepts as $concept)
                        <tr>
                            <td>{{ $concept->name }}</td>
                            <td id="observation"> - </td>
                            <td> $ {{ $concept->pivot->total }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-service">
                        <td colspan="2" style="text-align: right">Total Transporte:</td>
                        <td> $ {{ $transport->value_transport }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
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
                <div class="total-quote">
                    TOTAL COTIZACION: $ {{ number_format($freight->value_freight + $transport->value_transport, 2, '.', ',') }}
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

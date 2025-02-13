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
            padding: 5px;
            border: 1px solid #000;
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

        #detail-freight{
            width: 100%;
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


    <div id="detail-freight">
        <table id="table-freight">
            <thead>
                <th>Flete Maritimo</th>
                <th>Observacion</th>
                <th>Total</th>
            </thead>
            <tbody>
                @foreach ($freightConcepts as $concept)
                    <tr>
                        <td>{{ $concept->name }}</td>
                        <td> - </td>
                        <td>{{ $concept->pivot->total_value_concept }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>




</body>

</html>

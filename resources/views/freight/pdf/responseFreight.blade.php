<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cotización de Flete</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #888;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #002060;
            color: white;
        }

        td.highlight {
            background-color: #FFD966;
            font-weight: bold;
        }

        .header {
            text-transform: uppercase;
            background-color: #002060;
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            padding: 10px;
        }

        .right {
            text-align: right;
        }

        .total-row td {
            background-color: #002060;
            color: white;
            font-weight: bold;
        }

        .section-title {
            background-color: #D9E1F2;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>

    <!-- ENCABEZADO PRINCIPAL -->
    <div class="header">
        ORBE ADUANAS S.A.C - {{ $response->quote->commercial_quote->type_shipment->name }}
        {{ $response->quote->commercial_quote->lcl_fcl }}
    </div>

    <!-- DATOS GENERALES -->
    <table style="text-transform: uppercase">
        <tr>
            <td class="highlight">Cotización</td>
            <td>{{ $response->nro_response }}</td>
            <td class="highlight">VALIDEZ</td>
            <td>{{ $response->validity_date_formatted }}</td>
        </tr>
        <tr>
            <td class="highlight">POL</td>
            <td>{{ $response->origin }}</td>
            <td class="highlight">POD</td>
            <td>{{ $response->destination }}</td>
        </tr>
        <tr>
            <td class="highlight">AGENTE</td>
            <td>{{ $response->supplier->name_businessname }}</td>
            <td class="highlight">SERVICIO</td>
            <td>{{ $response->service }}</td>
        </tr>
        <tr>
            @if ($response->quote->commercial_quote->type_shipment->description === 'Marítima')
                <td class="highlight">NAVIERA</td>
                <td>{{ $response->shippingCompany->name }}</td>
            @else
                <td class="highlight">AEROLINEA</td>
                <td>{{ $response->airline->name }}</td>
            @endif
            <td class="highlight">FRECUENCIA</td>
            <td>{{ $response->frequency }}</td>
        </tr>
         <tr>
            <td class="highlight">TIEMPO DE TRANSITO</td>
            <td>{{ $response->transit_time }}</td>
            <td class="highlight">DIAS LIBRES</td>
            <td>{{ $response->free_days }}</td>

        </tr>
    </table>

    <!-- DETALLES DE CARGA -->
    <table>
        <tr>
            <td class="section-title" colspan="4">DETALLES DE CARGA COTIZADO</td>
        </tr>
        <tr>
            <td class="highlight">INCOTERMS COTIZADO</td>
            <td>{{ $response->quote->commercial_quote->incoterm->code }}</td>
            <td class="highlight">TIPO DE CAMBIO</td>
            <td>{{ $response->exchange_rate }}</td>
        </tr>
        @if ($response->quote->commercial_quote->type_shipment->description === 'Marítima')

            @if ($response->quote->commercial_quote->lcl_fcl === 'FCL')
                <tr>
                    <td class="highlight">CONTENEDOR</td>
                    <td colspan="3">{{ $response->quote->commercial_quote->container_quantity }} x
                        {{ $response->quote->commercial_quote->container->name }}</td>
                </tr>
                <tr>
                    <td class="highlight">PESO</td>
                    <td>{{ $response->quote->ton_kilogram }} TON</td>
                    <td class="highlight">VOLUMEN</td>
                    <td>{{ $response->quote->cubage_kgv }} CBM</td>
                </tr>
            @else
                <tr>
                    <td class="highlight">PESO</td>
                    <td>{{ $response->quote->ton_kilogram }} KG</td>
                    <td class="highlight">VOLUMEN</td>
                    <td>{{ $response->quote->cubage_kgv }} CBM</td>
                </tr>
            @endif
        @else
            <tr>
                <td class="highlight">PESO</td>
                <td>{{ $response->quote->ton_kilogram }} KG</td>
                <td class="highlight">VOLUMEN</td>
                <td>{{ $response->quote->cubage_kgv }} KGV</td>
            </tr>


        @endif

    </table>

    <!-- CUADRO DE COSTOS INCURRIDOS -->
    <table>
        <thead>
            <tr>
                <th colspan="5">COSTOS INCURRIDOS</th>
            </tr>
            <tr class="section-title">
                <td>CARGOS EN ORIGEN</td>
                <td>COSTO UNITARIO</td>
                <td>BASIS</td>
                <td>OBSERVACIONES</td>
                <td>COSTO FINAL</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($response->concepts as $concept)
                <tr>
                    <td>{{ $concept->name }}</td>
                    <td class="right">{{ $concept->pivot->unit_cost }}</td>
                    <td>{{ $concept->pivot->fixed_miltiplyable_cost }}</td>
                    <td>{{ $concept->pivot->observations }}</td>
                    <td class="right">{{ $concept->pivot->final_cost }}</td>
                </tr>
            @endforeach
            @foreach ($response->commissions as $commission)
                <tr>
                    <td>{{ $commission->name }}</td>
                    <td class="right">{{ $commission->pivot->amount }}</td>
                    <td>FIJO</td>
                    <td></td>
                    <td class="right">{{ $commission->pivot->amount }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4">COSTOS TOTALES</td>
                <td class="right">{{ $response->total }}</td>
            </tr>
        </tfoot>
    </table>

</body>

</html>

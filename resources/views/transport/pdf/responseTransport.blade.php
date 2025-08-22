@php
    // Señal de si incluyó IGV a nivel de cabecera (igv null => No)
    $incluyeIgv = !is_null($response->igv);
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle Respuesta Transporte - {{ $response->nro_response ?? '' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            /* un poco más grande */
            color: #222;
        }

        h2,
        h3 {
            margin: 0 0 6px;
            color: #002060;
            /* azul corporativo */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
        }

        /* Encabezados de tablas en azul corporativo */
        th {
            background: #002060;
            color: #fff;
            font-size: 12px;
            text-align: center;
        }

        /* Filas alternadas */
        tbody tr:nth-child(odd) td {
            background: #f9f9f9;
        }

        /* Totales destacados */
        .totales td {
            font-weight: bold;
        }

        .totales td:first-child {
            background: #FFC000;
            /* amarillo acento */
            color: #002060;
            text-align: right;
            width: 25%;
        }

        .totales td:nth-child(3) {
            background: #FFC000;
            color: #002060;
            text-align: right;
            width: 25%;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Cabecera del documento */
        .doc-title {
            font-size: 18px;
            font-weight: bold;
            color: #002060;
            border-bottom: 3px solid #FFC000;
            padding-bottom: 4px;
            margin-bottom: 10px;
        }
    </style>

</head>

<body>
    <h2 class="mb-2">Detalle de Respuesta de Transporte</h2>

    <table class="mb-3">
        <tr>
            <td><strong>N° Respuesta</strong></td>
            <td>{{ $response->nro_response ?? '—' }}</td>
            <td><strong>Proveedor</strong></td>
            <td>{{ optional($response->supplier)->name_businessname ?? '—' }}</td>
        </tr>
        <tr>
            <td><strong>Tipo de cambio (S/.)</strong></td>
            <td>{{ number_format($response->exchange_rate ?? 0, 4) }}</td>
            <td><strong>Tipo de vehículo</strong></td>
            <td>{{ $response->type_vehicle ?? '—' }}</td>
        </tr>
        <tr>
            <td><strong>Incluye IGV</strong></td>
            <td>{{ $incluyeIgv ? 'Sí' : 'No' }}</td>
            <td><strong>N° Cotización Transporte</strong></td>
            <td>{{ optional($response->quoteTransport)->nro_quote ?? '—' }}</td>
        </tr>
    </table>

    <h3 class="mb-2">Detalle por concepto</h3>
    <table class="mb-3">
        <thead>
            <tr>
                <th>Concepto</th>
                <th class="text-right">Valor concepto (S/.)</th>
                <th class="text-right">IGV (S/.)</th>
                <th class="text-right">Total (S/.)</th>
                <th class="text-right">Total (US$)</th>
                <th class="text-right">Utilidad (US$)</th>
                <th class="text-right">Costo Venta (US$)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($response->conceptResponseTransports as $row)
                <tr>
                    <td>{{ optional($row->concept)->name ?? '—' }}</td>
                    <td class="text-right">{{ number_format($row->net_amount ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($row->igv ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($row->total_sol ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($row->total_usd ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($row->value_utility ?? 0, 2) }}</td>
                    <td class="text-right">{{ number_format($row->sale_price ?? 0, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mb-2">Totales</h3>
    <table>
        <tr>
            <td><strong>Costo Neto (S/.)</strong></td>
            <td class="text-right">{{ number_format($response->provider_cost ?? 0, 2) }}</td>
            <td><strong>IGV (S/.)</strong></td>
            <td class="text-right">{{ number_format($response->igv ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Total (S/.)</strong></td>
            <td class="text-right">{{ number_format($response->total_sol ?? 0, 2) }}</td>
            <td><strong>Total (US$)</strong></td>
            <td class="text-right">{{ number_format($response->total_usd ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Utilidad (US$)</strong></td>
            <td class="text-right">{{ number_format($response->value_utility ?? 0, 2) }}</td>
            <td><strong>Total + Util (US$)</strong></td>
            <td class="text-right">{{ number_format($response->total_prices_usd ?? 0, 2) }}</td>
        </tr>
    </table>
</body>

</html>

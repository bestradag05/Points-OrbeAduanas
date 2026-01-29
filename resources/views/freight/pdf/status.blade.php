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
            overflow: hidden;
            position: relative;
            font-family: Arial, Helvetica, sans-serif;

        }

        .table-head {
            border-collapse: collapse;
            color: #234195;
        }

        .table-detail {
            padding: 15px 5px;
            width: 100%;
        }

        .table-detail span {
            text-transform: uppercase;
            color: #234195;
            font-weight: bold;
        }

        .table-shipment,
        .table-load,
        .table-payment {
            width: 100%;
            border-collapse: collapse;

        }

        .table-shipment td,
        .table-load td {

            border-bottom: 1px solid #525252;

        }

        .table-shipment .title,
        .table-load .title,
        .table-payment .title {
            width: 20%;
            color: #234195;
            font-weight: bold;
        }
    </style>


</head>

<body>


    <table class="table-head" width="100%">
        <tr>
            <td style="text-align: left;">
                <h1 style="margin: 0; font-weight: bold; font-size: 28px">
                    Pre Aviso de Salida</h1>
            </td>
            <td style="text-align: right;">
                <img src="{{ public_path('assets/img/logo.png') }}" alt="Orbe Aduanas S.A.C" style="height: 45px;">
            </td>
        </tr>
        <tr style="color: #fff; background: #234195; font-weight: 800px; text-align: right; font-size: 14px; ">
            <td colspan="2" style="padding: 2px 20px">{{ $commercialQuote->type_shipment->name }}</td>
        </tr>
    </table>

    <table class="table-detail">
        <tr>
            <td>
                <span>SEÑORES: </span>
            </td>
            <td>{{ $commercialQuote->customer->name_businessname }}</td>
        </tr>

        <tr>
            <td>
                <span>RUC: </span>
            </td>
            <td>{{ $commercialQuote->customer->document_number }}</td>
        </tr>
        <tr>
            <td>
                <span>ATT. </span>
            </td>
            <td>{{ $commercialQuote->customer->contact_name }}</td>
        </tr>
        <tr>
            <td>
                <span>TELEF. </span>
            </td>
            <td>{{ $commercialQuote->customer->contact_number }}</td>
        </tr>
    </table>

    <div style="margin-top: -12px; padding-left: 5px">
        <p style="font-weight: bold">Estimados Señores</p>
        <p>Orbeaduanas, tiene el agrado de informar que el estado de su mercancia segun el siguiente detalle: </p>
    </div>


    <div style="padding: 0 5px; margin-top: -20px">
        <h3 style="color: orange; text-transform: uppercase">Datos de embarque</h3>

        <table class="table-shipment">
            <tr>
                <td class="title">Proveedor</td>
                <td colspan="3" style="text-transform: uppercase; font-weight: bold">
                    {{ $commercialQuote->supplier->name_businessname }}</td>
            </tr>
            <tr>
                <td class="title">HBL</td>
                <td>{{ $freight->hawb_hbl }}</td>
                <td class="title">Zarpe / ETD</td>
                <td>{{ $freight->etd }}</td>
            </tr>
            <tr>
                <td class="title">Buque</td>
                <td>{{ $freight->buque }}</td>
                <td class="title">Arribo / ETA</td>
                <td>{{ $freight->eta }}</td>
            </tr>
            <tr>
                <td class="title">Almacen</td>
                <td>{{ $freight->warehouse->name_businessname }}</td>
                <td class="title">Cond. de Flete</td>
                <td>{{ $freight->condition_freight }}</td>
            </tr>
            <tr>
                <td class="title">VB° Gremios</td>
                <td>{{ $freight->vb_gremios }}</td>
                <td class="title">Destino</td>
                <td>{{ $commercialQuote->destinationState->country->name }} -
                    {{ $commercialQuote->destinationState->name }}</td>
            </tr>
            <tr>
                <td class="title">Origen</td>
                <td> {{ $commercialQuote->originState->country->name }} -
                    {{ $commercialQuote->originState->name }}</td>
                <td class="title">Terminal Portuario</td>
                <td> {{ $freight->port_terminal }}</td>
            </tr>
            <tr>
                <td class="title">Ref. Cliente</td>
                <td> {{ $commercialQuote->nro_quote_commercial }}</td>
                <td class="title">Incoterms</td>
                <td> {{ $commercialQuote->incoterm->code }}</td>
            </tr>
        </table>

    </div>


    <div style="padding: 0 5px;">
        <h3 style="color: orange; text-transform: uppercase">Datos de la carga</h3>

        <table class="table-load">
            <tr>
                <td class="title">Peso</td>
                <td>
                    {{ $commercialQuote->weight }}
                    {{ $commercialQuote->unit_of_weight }}</td>
                <td class="title">Volumen</td>
                <td>{{ $commercialQuote->volumen_kgv }}
                    {{ $commercialQuote->unit_of_volumen_kgv }}</td>
            </tr>
            <tr>
                <td class="title">Bultos</td>
                <td>{{ $commercialQuote->nro_package }} {{ $commercialQuote->packingType->name }}</td>
                <td class="title">Modalidad</td>
                <td>{{ $commercialQuote->type_shipment->name }}</td>
            </tr>
            <tr>
                <td class="title">Tipo / N° Contenedor</td>
                <td>{{ $freight->container_number }}</td>
                <td class="title">Tipo de carga</td>
                <td>{{ $commercialQuote->lcl_fcl }}</td>
            </tr>
            <tr>
                <td class="title">Precintos</td>
                <td colspan="3">{{ $freight->seals }}</td>
            </tr>
            <tr>
                <td class="title">Mercaderia</td>
                <td colspan="3">{{ $commercialQuote->commodity }}</td>
            </tr>
        </table>

    </div>

    <div style="padding: 0 5px;">
        <h3 style="color: orange; text-transform: uppercase">Pagos a efectuar</h3>

        <table class="table-payment">
            @php
                $total_sin_igv = 0;
            @endphp
            @foreach ($concepts as $concept)
                @if ($concept->pivot->has_igv === 0)
                    <tr>
                        <td class="title" style="width: 70%">{{ $concept->name }}</td>
                        <td style="width: 30%;">
                            <span style="float: left;">$</span>
                            <span style="float: right;">{{ $concept->pivot->value_concept }}</span>
                        </td>
                    </tr>
                    @php
                        $total_sin_igv += $concept->pivot->value_concept;
                    @endphp
                @endif
            @endforeach
            <tr>
                <td class="title" style="width: 70%; font-weight: bold; text-transform: uppercase">Total sin IGV</td>
                <td style="width: 30%; border-top: 1px solid #000">
                    <span style="float: left;">$</span>
                    <span style="float: right;">{{ number_format($total_sin_igv, 2) }}</span>
                </td>
            </tr>

            <!-- Total con IGV -->

            <br>

            @php
                $total_con_igv = 0;
            @endphp
            @foreach ($concepts as $concept)
                @if ($concept->pivot->has_igv === 1)
                    <tr>
                        <td class="title" style="width: 70%">{{ $concept->name }}</td>
                        <td style="width: 30%;">
                            <span style="float: left;">$</span>
                            <span style="float: right;">{{ $concept->pivot->value_concept }}</span>
                        </td>
                    </tr>
                    @php
                        $total_con_igv += $concept->pivot->value_concept;
                    @endphp
                @endif
            @endforeach
            <tr>
                <td class="title" style="width: 70%; font-weight: bold; text-transform: uppercase">Total con IGV</td>
                <td style="width: 30%; border-top: 1px solid #000">
                    <span style="float: left;">$</span>
                    <span style="float: right;">{{ number_format($total_con_igv, 2) }}</span>
                </td>
            </tr>

            <br>
            <!-- Total Final -->
            @php
                $total_final = $total_sin_igv + $total_con_igv;
            @endphp
            <tr style="background: yellow">
                <td class="title" style="width: 70%; font-weight: bold; text-transform: uppercase">Total a agar</td>
                <td style="width: 30%; border-top: 1px solid #000">
                    <span style="float: left;">$</span>
                    <span style="float: right;">{{ number_format($total_final, 2) }}</span>
                </td>
            </tr>
        </table>

        <div style="font-size: 11px">
            <p style="font-weight: bold">Observaciones: </p>
            <p style="text-align: justify">Despues de 96 horas de ser recibida la presente informacion será aceptada por
                el cliente bajo su
                responsabilidad. <br>
                Agradecimos coordinar sus pagos con: Srt Irina Rodriguez - email: irina.rodriguez@orbeaduanas.com <br>
            </p>

            <p style="color: #234195; font-weight: bold; text-transform: uppercase;">Importante: </p>

            <p style="text-align: justify">Las solicitudes de rectificación de consignatario, descripcion de bultos y
                otros, se deben solicitar
                hasta 12 horas del ETa de su carga correo operaciones@orbeaduanas.com, caso
                contrario la rectificaciónse podra realizar previo pago de la sanción determinada por la Ley General de
                Auanas, D.L. Nro 1053, Reglamento y la Tabla de Sanciones Aplicables a las infracciones de Lay.
            </p>

        </div>

        <div>
            <img src="{{ public_path('assets/img/cuentas_bancarias.jpg') }}"
                alt="Cuentas bancarias de Orbe Aduanas S.A.C" style="height: 100%; width: 100%">
        </div>


    </div>






</body>

</html>

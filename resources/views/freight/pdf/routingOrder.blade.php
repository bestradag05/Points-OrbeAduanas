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
            font-family: Arial, Helvetica, sans-serif
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

        .table-consignee,
        .table-shipper,
        .table-wrloading,
        .table-producs,
        .table-concepts {
            width: 100%;
            border-collapse: collapse;

        }

        .table-consignee td,
        .table-shipper td,
        .table-producs td {

            border-bottom: 1px solid #525252;

        }

        .table-consignee .title,
        .table-shipper .title,
        .table-producs .title,
        .table-concepts .title {
            width: 20%;
            color: #234195;
            font-weight: bold;
        }

        .table-wrloading td {
            border: 1px solid #525252;
            height: 80px;
        }
    </style>


</head>

<body>


    <table class="table-head" width="100%">
        <tr>
            <td style="text-align: left;">
                <h1 style="margin: 0; font-weight: bold; font-size: 28px">
                    ROUTING ORDER</h1>
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
                <span>Fecha: </span> {{ $commercialQuote->freight->created_at->format('d/m/Y') }}
            </td>
            <td>
                <span>Origen: </span> {{ $commercialQuote->origin }}
            </td>
            <td>
                <span>Destino: </span> {{ $commercialQuote->destination }}
            </td>
            <td>
                <span>Vendedor: </span> {{ $commercialQuote->personal->names }}
            </td>
        </tr>
    </table>


    <div style="padding: 0 5px;">
        <h2 style="color: orange">CONSIGNEE</h2>

        <table class="table-consignee">
            <tr>
                <td class="title">Company Name</td>
                <td style="text-transform: uppercase; font-weight: bold">
                    {{ $commercialQuote->customer->name_businessname }}</td>
            </tr>
            <tr>
                <td class="title">RUC</td>
                <td>{{ $commercialQuote->customer->document_number }}</td>
            </tr>
            <tr>
                <td class="title">Address</td>
                <td>{{ $commercialQuote->customer->address }}</td>
            </tr>
            <tr>
                <td class="title">Telephone</td>
                <td>{{ $commercialQuote->customer->contact_number }}</td>
            </tr>
            <tr>
                <td class="title">Contact</td>
                <td>{{ $commercialQuote->customer->contact_name }}</td>
            </tr>
            <tr>
                <td class="title">E-mail</td>
                <td>{{ $commercialQuote->customer->contact_email }}</td>
            </tr>
        </table>

    </div>


    <div style="padding: 0 5px;">
        <h2 style="color: orange">Shipper</h2>

        <table class="table-shipper">
            <tr>
                <td class="title">Company Name</td>
                <td style="text-transform: uppercase; font-weight: bold">
                    {{ $commercialQuote->supplier->name_businessname ?? '' }}</td>
            </tr>
            <tr>
                <td class="title">Address</td>
                <td>{{ $commercialQuote->supplier->address }}</td>
            </tr>
            <tr>
                <td class="title">Contact</td>
                <td>{{ $commercialQuote->supplier->contact_name }}</td>
            </tr>
            <tr>
                <td class="title">E-mail</td>
                <td>{{ $commercialQuote->supplier->contact_email }}</td>
            </tr>
        </table>

    </div>

    <div style="padding: 0 5px;">
        <h2 style="color: orange">WR LOADING</h2>

        <table class="table-wrloading">
            <tr>
                <td style="width: 20%; text-align: center">WR loading</td>
                <td style="padding-left: 10px">
                    {{ $freight->wr_loading}}
                </td>
            </tr>

        </table>

    </div>


    <div style="padding: 0 5px;">
        <h2 style="color: orange">DESCRIPTION OF PRODUCTS</h2>

        <table class="table-producs">

            @if ($commercialQuote->is_consolidated)

                <tr>
                    <td class="title">Commodity</td>
                    <td colspan="5" style="text-transform: uppercase; font-weight: bold">
                        {{ $commercialQuote->commodity }}</td>
                </tr>
                <tr>
                    <td class="title">Package N°</td>
                    <td colspan="5">{{ $commercialQuote->total_nro_package_consolidated }}</td>
                </tr>
                <tr>
                    <td class="title">Total gross weight</td>
                    <td>{{ $commercialQuote->pounds }}</td>
                    <td class="title">pounds</td>
                    <td> {{ $commercialQuote->total_kilogram_consolidated }} </td>
                    <td class="title">kilograms</td>
                    @if ($commercialQuote->type_shipment->description === 'Marítima')
                        <td>{{ $commercialQuote->total_volumen_consolidated }} <span class="title">M3</span></td>
                    @else
                        <td>{{ $commercialQuote->total_kilogram_volumen_consolidated }} <span class="title">KGV</span></td>
                    @endif


                </tr>
            @else
                <tr>
                    <td class="title">Commodity</td>
                    <td colspan="5" style="text-transform: uppercase; font-weight: bold">
                        {{ $commercialQuote->commodity }}</td>
                </tr>
                <tr>
                    <td class="title">Package N°</td>
                    <td colspan="5">{{ $commercialQuote->nro_package }}</td>
                </tr>
                <tr>
                    <td class="title">Total gross weight</td>
                    <td>{{ $commercialQuote->pounds }}</td>
                    <td class="title">pounds</td>
                    <td> {{ $commercialQuote->kilograms }} </td>
                    <td class="title">kilograms</td>
                    @if ($commercialQuote->type_shipment->description === 'Marítima')
                        <td>{{ $commercialQuote->volumen }} <span class="title">M3</span></td>
                    @else
                        <td>{{ $commercialQuote->kilogram_volumen }} <span class="title">KGV</span></td>
                    @endif


                </tr>

            @endif

            <tr>
                <td class="title">Insurance</td>
                @if ($commercialQuote->freight->insurance)
                    <td>C/ SEGURO</td>
                @else
                    <td></td>
                @endif
                <td class="title">Quantity Container</td>
                <td>{{ $commercialQuote->container_quantity ?? 0 }}</td>
                <td class="title">Type Container</td>
                <td>{{ $commercialQuote->container->name ?? '' }}</td>
            </tr>
            <tr>
                <td class="title">Value invoice</td>
                <td colspan="5">{{ $commercialQuote->load_value }}</td>
            </tr>
            <tr>
                <td class="title">Incoterms</td>
                <td colspan="2">{{ $commercialQuote->incoterm->code }}</td>
                <td class="title">Mode</td>
                <td colspan="2">{{ $commercialQuote->lcl_fcl }}</td>
            </tr>
            <tr>
                <td class="title">Type Load</td>
                <td colspan="5">{{ $commercialQuote->type_load->name }}</td>
            </tr>
            <tr>
                <td class="title">H.S. Code</td>
                <td colspan="5"> </td>
            </tr>

        </table>


        <div>
            <p style="font-size: 12px; color: #525252; text-align: center">* Are mandatory enforcement details for the
                International Freight Forwarders in origin of the country of the supplier under financial responsibility
                in order of the Peruvian importer.</p>
        </div>

    </div>

    @php
        $chunks = $concepts->chunk(7); // Dividimos cada 7
        $rows = $chunks->chunk(2); // Cada fila tendrá 2 columnas máximo
    @endphp

    <table style="width: 100%; border-collapse: collapse;">
        @foreach ($rows as $row)
            <tr>
                @foreach ($row as $chunk)
                    <td style="vertical-align: top; width: 50%;">
                        <table class="table-concepts" style="width: 100%; border-collapse: collapse;">
                            @foreach ($chunk as $concept)
                                <tr>
                                    <td class="title" style="width: 55%">
                                        {{ $concept->name }}
                                    </td>
                                    <td style="border-bottom: 1px solid #5a5a5a; text-align: right">
                                        $ {{ $concept->pivot->total_value_concept }}
                                    </td>
                                    @if (isset($concept->pivot->additional_points) && $concept->pivot->additional_points > 0)
                                        <td style="color: red;">
                                            ({{ $concept->pivot->additional_points }})
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    </td>
                @endforeach

                {{-- Si hay solo una columna en la fila, agrega una celda vacía para alinear --}}
                @if ($row->count() < 2)
                    <td style="width: 50%;"></td>
                @endif
            </tr>
        @endforeach
    </table>

    <div style="width: 100%; text-align: right;">
        <p style="padding-right: 75px"> <span style="font-weight: bold">TOTAL A PAGAR :</span> $
            {{ $freight->value_freight }}</p>
    </div>



</body>

</html>

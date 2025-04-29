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
            overflow: hidden;
            position: relative;
            font-family: Arial, Helvetica, sans-serif
        }

        .table-head {
            border-collapse: collapse;
            color: #234195;
        }

        .table-detail{
            padding: 15px 5px;
            width: 100%;
            font-size: 12px;
        }

        .table-detail span{
            text-transform: uppercase;
            color: #234195;
            font-weight: bold;
        }
    </style>


</head>

<body>


    <table class="table-head" width="100%" >
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
                <span>Fecha: </span> {{ $commercialQuote->freight->created_at}}
            </td>
            <td>
                <span>Origen: </span> {{ $commercialQuote->origin}}
            </td>
            <td>
                <span>Destino: </span> {{ $commercialQuote->destination}}
            </td>
            <td>
                <span>Vendedor: </span> {{ $commercialQuote->personal->names}}
            </td>
        </tr>
    </table>


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
                        <td class="title-item-table">Tipo de carga</td>
                        <td class="text-item-table">{{ $commercialQuote->type_load->name }}</td>
                    </tr>
                    @if ($commercialQuote->is_consolidated)

                        <tr>
                            <td class="title-item-table">Bultos</td>
                            <td class="text-item-table">{{ $commercialQuote->total_nro_package_consolidated }}</td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Volumen / KGV</td>
                            @if ($commercialQuote->total_volumen_consolidated)
                                <td class="text-item-table">{{ $commercialQuote->total_volumen_consolidated }} CBM</td>
                            @else
                                <td class="text-item-table">{{ $commercialQuote->total_kilogram_volumen_consolidated }}
                                    KGV</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="title-item-table">Peso total</td>
                            <td class="text-item-table">{{ $commercialQuote->total_kilogram_consolidated }}</td>
                        </tr>
                    @else
                        <tr>
                            <td class="title-item-table">Bultos</td>
                            <td class="text-item-table">{{ $commercialQuote->nro_package }}</td>
                        </tr>
                        <tr>
                            <td class="title-item-table">Volumen</td>
                            <td class="text-item-table">{{ $commercialQuote->volumen }}</td>
                        </tr>

                        @if ($commercialQuote->lcl_fcl === 'FCL')
                            <tr>
                                <td class="title-item-table">Peso total</td>
                                <td class="text-item-table">{{ $commercialQuote->tons }} TONS</td>
                            </tr>
                        @else
                            <tr>
                                <td class="title-item-table">Peso total</td>
                                <td class="text-item-table">{{ $commercialQuote->kilograms }} KG</td>
                            </tr>
                        @endif


                    @endif

                    <tr>
                        <td class="title-item-table">Valor de factura</td>
                        <td class="text-item-table">{{ $commercialQuote->load_value }}</td>
                    </tr>
                    <tr>
                        <td class="title-item-table">Valor CIF</td>
                        <td class="text-item-table">{{ $commercialQuote->cif_value }}</td>
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
                        <td class="title-item-table">Fecha de Creacion</td>
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
                            {{ $commercialQuote->valid_date->format('d/m/Y') }}</td>

                    </tr>

                </tbody>
            </table>

        </div>
    </div>



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
                    TOTAL COTIZACION: $
                    {{ number_format(($freight->value_freight ?? 0) + ($cats_destinations ?? 0), 2, '.', ',') }}
                </div>
            </div>

        </div>

        {{--  <div class="footer-quote">

            <p>Si usted tiene alguna pregunta sobre esta cotización, por favor, pónganse en contacto con nosotros</p>
            <p>[{{ $personal->names }} {{ $personal->last_name }}, +51 {{ $personal->cellphone }},
                {{ $personal->user->email }}]</p>
            <p style="font-weight: bold">Gracias por hacer negocios con nosotros!</p>
        </div> --}}

    </div>




</body>

</html>

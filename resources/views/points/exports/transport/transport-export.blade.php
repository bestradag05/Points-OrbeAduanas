<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exportacion de transporte</title>
    <style>
         #tabla_transport {
            font-size: 12px;
            text-align: center;
            border-collapse: collapse;
         } 

       
         th, td {
            border: 1px solid black; /* Agrega bordes a las celdas */
            padding: 3px; /* Espaciado interno */
            text-align: center; /* Centra el texto */
        }

        #tabla_transport thead {
            background: #2e37a4;
            color: #fff;
        }

        #tabla_transport thead tr th{
            width: 55px;
        }
    </style>
</head>

<body>


    <table id="tabla_transport" class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>N° Factura</th>
                <th>Proveedor</th>
                <th>Cliente</th>
                <th>Ruc</th>
                <th>Numero de Orden</th>
                <th>Numero de Dua</th>
                <th>Direccion</th>
                {{-- <th>Concepto</th> --}}
                <th>Base Imponible</th>
                <th>IGV</th>
                <th>Total</th>
                <th>Estado de pago</th>
                <th>Fecha de pago</th>
                <th>Vendedor</th>
                <th>Peso</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transports as $transport)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transport->date_register }}</td>
                    <td>{{ $transport->invoice_number }}</td>
                    <td>{{ $transport->routing->supplier->name_businessname }}</td>
                    <td>{{ $transport->routing->customer->name_businessname }}</td>
                    <td>{{ $transport->routing->customer->document_number }}</td>
                    <td>{{ $transport->nro_orden }}</td>
                    <td>{{ $transport->nro_dua }}</td>
                    <td>{{ $transport->origin . ' - ' . $transport->destination  }}</td>
                    <td>{{ $transport->tax_base }}</td>
                    <td>{{ $transport->igv }}</td>
                    <td>{{ $transport->total }}</td>
                    <td>{{ $transport->payment_state }}</td>
                    <td>{{ $transport->payment_date }}</td>
                    <td>{{ $transport->routing->personal->names }}</td>
                    <td>{{ $transport->weight }}</td>
                </tr>
            @endforeach

        </tbody>

    </table>

</body>

</html>

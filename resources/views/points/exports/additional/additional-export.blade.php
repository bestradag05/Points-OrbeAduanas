<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exportacion de Adicionales</title>
    <style>
         #tabla_additional {
            font-size: 12px;
            text-align: center;
            border-collapse: collapse;
         } 

       
         th, td {
            border: 1px solid black; /* Agrega bordes a las celdas */
            padding: 3px; /* Espaciado interno */
            text-align: center; /* Centra el texto */
        }

        #tabla_additional thead {
            background: #2e37a4;
            color: #fff;
        }

        #tabla_additional thead tr th{
            width: 62px;
        }
    </style>
</head>

<body>


    <table id="tabla_additional" class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Bl a trabajar</th>
                <th>Fecha</th>
                <th>Ruc a facturar</th>
                <th>N° Factura</th>
                <th>Cliente</th>
                <th>Ruc</th>
                <th>Vendedor</th>
                <th>Tipo de servicio</th>
                <th>Monto</th>
                <th>IGV</th>
                <th>Total</th>
                <th>Addicional</th>
                <th>Encargado</th>
                <th>Tipo de Adicional</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($additionals as $additional)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $additional->bl_to_work }}</td>
                    <td>{{ $additional->date_register }}</td>
                    <td>{{ $additional->ruc_to_invoice }}</td>
                    <td>{{ $additional->invoice_number }}</td>
                    <td>{{ $additional->additional->routing->customer->name_businessname }}</td>
                    <td>{{ $additional->additional->routing->customer->document_number }}</td>
                    <td>{{ $additional->additional->routing->personal->names }}</td>
                    <td>{{ $additional->type_of_service }}</td>
                    <td>{{ $additional->amount }}</td>
                    <td>{{ $additional->igv }}</td>
                    <td>{{ $additional->total }}</td>
                    <td>Punto</td>
                    <td>{{ $additional->administrator }}</td>
                    <td>{{ $additional->additional_type }}</td>
                </tr>
            @endforeach

        </tbody>

    </table>

</body>

</html>

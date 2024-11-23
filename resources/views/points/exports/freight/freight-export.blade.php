<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exportacion de Flete</title>
    <style>
         #tabla_freight {
            font-size: 12px;
            text-align: center;
            border-collapse: collapse;
         } 

       
         th, td {
            border: 1px solid black; /* Agrega bordes a las celdas */
            padding: 3px; /* Espaciado interno */
            text-align: center; /* Centra el texto */
        }

        #tabla_freight thead {
            background: #2e37a4;
            color: #fff;
        }

        #tabla_freight thead tr th{
            width: 58px;
        }
    </style>
</head>

<body>


    <table id="tabla_freight" class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>Roi</th>
                <th>Cliente</th>
                <th>Ruc</th>
                <th>Fecha</th>
                <th>Vendedor</th>
                <th>Tipo de Embarque</th>
                <th>Regimen</th>
                <th>HAWB / HBL</th>
                <th>BL a trabajar</th>
                <th>ETD</th>
                <th>ETA</th>
                <th>Origen - Destino</th>
                <th>Utilidad Orbe</th>
                <th>Flete Orbe</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($freights as $freight)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $freight->roi }}</td>
                    <td>{{ $freight->routing->customer->name_businessname }}</td>
                    <td>{{ $freight->routing->customer->document_number }}</td>
                    <td>{{ $freight->date_register }}</td>
                    <td>{{ $freight->routing->personal->names }}</td>
                    <td>{{ $freight->routing->type_shipment->code }}</td>
                    <td>{{ $freight->routing->regime->code }}</td>
                    <td>{{ $freight->hawb_hbl }}</td>
                    <td>{{ $freight->bl_work }}</td>
                    <td>{{ $freight->edt }}</td>
                    <td>{{ $freight->eta }}</td>
                    <td>{{ $freight->routing->origin .' / '. $freight->routing->destination }}</td>
                    <td>{{ $freight->value_utility }}</td>
                    <td>{{ $freight->value_freight }}</td>
                </tr>
            @endforeach

        </tbody>

    </table>

</body>

</html>

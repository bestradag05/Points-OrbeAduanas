<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exportacion de aduanas</title>
    <style>
         #tabla_custom {
            font-size: 12px;
            text-align: center;
            border-collapse: collapse;
         } 

       
         th, td {
            border: 1px solid black; /* Agrega bordes a las celdas */
            padding: 3px; /* Espaciado interno */
            text-align: center; /* Centra el texto */
        }

        #tabla_custom thead {
            background: #2e37a4;
            color: #fff;
        }

        #tabla_custom thead tr th{
            width: 65px;
        }
    </style>
</head>

<body>


    <table id="tabla_custom" class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>N° Orden</th>
                <th>Cliente</th>
                <th>Ruc</th>
                <th>Nro Dam</th>
                <th>Fecha</th>
                <th>Tipo de Embarque</th>
                <th>Modalidad</th>
                <th>Regimen</th>
                <th>Valor CIF</th>
                <th>Vendedor</th>
                <th>Canal</th>
                <th>N° Bl/AW</th>
                <th>Fecha de Regularizacion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customs as $custom)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $custom->nro_orde }}</td>
                    <td>{{ $custom->routing->customer->name_businessname }}</td>
                    <td>{{ $custom->routing->customer->document_number }}</td>
                    <td>{{ $custom->nro_dam }}</td>
                    <td>{{ $custom->date_register }}</td>
                    <td>{{ $custom->routing->type_shipment->code }}</td>
                    <td>{{ $custom->modality->name }}</td>
                    <td>{{ $custom->routing->regime->code }}</td>
                    <td>{{ $custom->cif_value }}</td>
                    <td>{{ $custom->routing->personal->names }}</td>
                    <td>{{ $custom->channel }}</td>
                    <td>{{ $custom->nro_bl }}</td>
                    <td>{{ $custom->regularization_date }}</td>
                </tr>
            @endforeach

        </tbody>

    </table>

</body>

</html>

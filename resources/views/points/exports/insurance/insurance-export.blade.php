<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exportacion de seguro</title>
    <style>
         #tabla_insurance {
            font-size: 12px;
            text-align: center;
            border-collapse: collapse;
         } 

       
         th, td {
            border: 1px solid black; /* Agrega bordes a las celdas */
            padding: 3px; /* Espaciado interno */
            text-align: center; /* Centra el texto */
        }

        #tabla_insurance thead {
            background: #2e37a4;
            color: #fff;
        }

        #tabla_insurance thead tr th{
            width: 55px;
        }
    </style>
</head>

<body>


    <table id="tabla_insurance" class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>N° de certificado</th>
                <th>N° de aseguradora</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Ruc</th>
                <th>Vendedor</th>
                <th>Regimen</th>
                <th>Via</th>
                <th>Aduana / Flete</th>
                <th>Valor Asegurado</th>
                <th>Venta aseguradora</th>
                <th>Valor de venta</th>
                <th>Precio Venta</th>
                <th>Tipo de seguro</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($insurances as $insurance)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $insurance->certified_number }}</td>
                    <td>{{ $insurance->insured_references }}</td>
                    <td>{{ $insurance->date}}</td>
                    <td>{{ $insurance->insurable->routing->customer->name_businessname }}</td>
                    <td>{{ $insurance->insurable->routing->customer->document_number }}</td>
                    <td>{{ $insurance->insurable->routing->personal->names }}</td>
                    <td>{{ $insurance->insurable->routing->regime->description }}</td>
                    <td>{{ $insurance->insurable->routing->type_shipment->description  }}</td>
                    <td>{{ $insurance->name_service }}</td>
                    <td>{{ $insurance->insurable->routing->load_value }}</td>
                    <td>{{ $insurance->insurance_sale }}</td>
                    <td>{{ $insurance->sales_value }}</td>
                    <td>{{ $insurance->sales_price }}</td>
                    <td>{{ $insurance->typeInsurance->name}}</td>
                </tr>
            @endforeach

        </tbody>

    </table>

</body>

</html>

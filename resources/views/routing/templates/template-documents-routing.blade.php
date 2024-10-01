@foreach ($routing_services as $routing_service)
    <table class="table">
        <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th>Documentos de {{$routing_service->name}} </th>
                <th>Documento </th>
            </tr>
        </thead>
        <tbody>
            <td>{{ $loop->iteration }}</td>
            <td>Liquidacion de aduana</td>
            <td>Archivo</td>
        </tbody>
    </table>
@endforeach


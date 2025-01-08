@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Listado de cotizaciones transporte</h2>
    </div>

@stop
@section('dinamic-content')


    <x-adminlte-datatable id="table1" :heads="$heads" hoverable>
        @foreach ($quotes as $quote)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $quote->nro_quote }}</td>
                <td>{{ $quote->routing->customer->name_businessname}}</td>
                <td>{{ $quote->origin }}</td>
                <td>{{ $quote->destination }}</td>
                <td>{{ $quote->commodity  }}</td>
                <td>{{ $quote->routing->lcl_fcl  }}</td>
                <td>{{ $quote->cubage_kgv }}</td>
                <td>{{ $quote->ton_kilogram }}</td>
                <td>{{ $quote->total_weight }}</td>
                <td>{{ $quote->routing->personal->names }}</td>
                <td>{{ $quote->nro_operation }}</td>
                <td class="status-{{strtolower($quote->state)}}">{{ $quote->state }}
                </td>


                <td>
                    <a href="{{ url('/quote/freight/'. $quote->id) }}" class="btn btn-outline-indigo btn-sm mb-2 ">
                        Detalle
                    </a>
                </td>

            </tr>
        @endforeach
    </x-adminlte-datatable>

@stop


@push('scripts')


    @if (session('eliminar') == 'ok')
        <script>
            Swal.fire({
                title: "Eliminado!",
                text: "tu registro fue eliminado.",
                icon: "success"
            });
        </script>
    @endif
    <script>
        $('.form-delete').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: "¿Estas seguro?",
                text: "Si eliminas no podras revertirlo",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, Eliminar!",
                cancelButtonText: "Descartar"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });

        });
    </script>
@endpush

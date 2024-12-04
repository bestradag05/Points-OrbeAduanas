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
                <td>
                    {{ $quote->routing->customer->name_businessname }}
                </td>
                <td>{{ $quote->pick_up }}</td>
                <td>{{ $quote->delivery }}</td>
                <td>{{ $quote->contact_name }}</td>
                <td>{{ $quote->contact_phone }}</td>
                <td>{{ $quote->max_attention_hour }}</td>
                <td>{{ $quote->lcl_fcl }}</td>
                <td>{{ $quote->cubage_kgv  }}</td>
                <td>{{ $quote->ton_kilogram  }}</td>
                <td>{{ $quote->total_weight }}</td>
                <td>{{ $quote->routing->personal->names }}</td>
                <td class="{{ $quote->state == 'Pendiente' ? 'text-warning' : 'text-success' }}">{{ $quote->state }}
                </td>


                <td>
                    <a href="{{ url('/quote/transport/'. $quote->id) }}" class="btn btn-outline-success btn-sm">
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
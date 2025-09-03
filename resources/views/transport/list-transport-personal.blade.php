@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Transportes</h2>
    </div>

@stop
@section('dinamic-content')


    <x-adminlte-datatable id="table1" :heads="$heads" hoverable>
        @foreach ($transports as $transport)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $transport->nro_operation_transport }}</td>
                @if (isset($transport->routing))
                    <td>
                        <a href="{{ url('/routing/' . $transport->routing->id . '/detail') }}">
                            {{ $transport->nro_operation }}
                        </a>
                    </td>
                @else
                    <td>Solo transporte</td>
                @endif
                <td>{{ $transport->origin }}</td>
                <td>{{ $transport->destination }}</td>
                <td>{{ $transport->value_sale }}</td>
                <td class="text-indigo text-bold">{{ \Carbon\Carbon::parse($transport->withdrawal_date)->format('d/m/Y') }}
                </td>
                <td>
                    <div class="custom-badge text-sm status-{{ Str::slug($transport->state) }}">
                        {{ $transport->state }}
                    </div>
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

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Transport Pendientes</h2>
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads" hoverable>
        @foreach ($transports as $transport)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/routing/' . $transport->routing->id . '/detail') }}">
                        {{ $transport->nro_operation }}
                    </a>
                </td>
                <td>{{$transport->routing->personal->names}}</td>
                <td>{{ $transport->origin }}</td>
                <td>{{ $transport->destination }}</td>
                <td class="{{ $transport->state == 'Pendiente' ? 'text-warning' : '' }}">
                    {{ $transport->state }}
                </td>

                @can('transporte.generate')
                <td>
                    <a href="{{ url('/transport/' . $transport->id . '/edit') }}" class="btn btn-outline-success btn-sm">
                        Generar punto
                    </a>

                </td>
                @else
                <td></td>
                @endcan
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

@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Fletes pendientes</h2>
    </div>

@stop
@section('dinamic-content')


    <x-adminlte-datatable id="table1" :heads="$heads" hoverable>
        @foreach ($freights as $freight)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/routing/' . $freight->routing->id . '/detail') }}">
                        {{ $freight->nro_operation }}
                    </a>
                </td>
                <td>{{$freight->routing->personal->names}}</td>

                <td>{{ $freight->value_utility }}</td>

                <td class="{{ $freight->state == 'Pendiente' ? 'text-warning' : 'text-success' }}">{{ $freight->state }}
                </td>

                @can('operaciones.generate')
                <td>
                    <a href="{{ url('/freight/' . $freight->id . '/edit') }}" class="btn btn-outline-success btn-sm">
                        {{ $freight->state == 'Pendiente' ? 'Generar punto' : 'Modificar' }}
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

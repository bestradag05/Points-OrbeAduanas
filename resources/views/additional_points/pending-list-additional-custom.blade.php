@extends('home')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h2>Puntos adicionales Pendientes</h2>
    </div>

@stop
@section('dinamic-content')
    <x-adminlte-datatable id="table1" :heads="$heads" hoverable>
        @foreach ($additionals as $additional_point)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/routing/' . $additional_point->additional->routing->id . '/detail') }}">
                        {{ $additional_point->additional->nro_operation }}
                    </a>
                </td>
                <td>{{ $additional_point->type_of_service }}</td>
                <td>{{ $additional_point->amount }}</td>
                <td>{{ $additional_point->igv }}</td>
                <td>{{ $additional_point->total }}</td>
                <td>{{ $additional_point->points }}</td>
                <td>{{ $additional_point->additional_type }} </td>
                <td>
                    {{ $additional_point->state }}
                </td>

                <td>
                    <a href="{{ url('/additionals/' . $additional_point->id . '/edit') }}"
                        class="btn btn-outline-success btn-sm">
                        {{ $additional_point->state == 'Pendiente' ? 'Generar punto' : 'Modificar' }} </a>

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
